<?php
  require_once 'Model.php';
  require_once 'Subject.php';
  require_once 'User.php';
  require_once 'Grades.php';
  require_once 'Course.php';

  class Student extends Model
  {
    protected static $table = 'students';

    public $id;
    public $student_id;
    public $name;
    public $gender;
    public $birthdate;
    public $course_id;
    public $year_level;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all(): ?array
    {
        $result = parent::all();
        return $result ? array_map(fn($data) => new self($data), $result) : null;
    }

    public static function find($id): ?self
    {
        $result = parent::find($id);
        return $result ? new self($result) : null;
    }

    public static function findByStudentId(string $studentId): ?self
    {
        try {
            $sql = 'SELECT * FROM students WHERE student_id = ?;';
            $stmt = self::$conn->prepare($sql);
            $stmt->execute([$studentId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? new self($result) : null;
        } catch (Exception $e) {
            echo '(!) Error fetching student: ' . $e->getMessage();
            return null;
        }
    }

    public static function create($data): ?self
    {
        $result = parent::create($data);
        return $result ? new self($result) : null;
    }

    public function update($data): bool
    {
        $result = parent::updateById($this->id, $data);
        if ($result) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }
        return $result;
    }

    public function save(): bool
    {
      $data = 
      [
        'student_id' => $this->student_id,
        'name'       => $this->name,
        'gender'     => $this->gender,
        'birthdate'  => $this->birthdate,
        'course_id'  => $this->course_id,
        'year_level' => $this->year_level,
        'status'     => $this->status,
      ];
      
      if ($this->id) 
      {
        return $this->update($data);
      } else {
        $newStudent = self::create($data);
        if ($newStudent)
        {
          $this->id = $newStudent->id;
          return true;
        }
      return false;
      }
    }

    public function delete(): bool
    {
        $result = parent::deleteById($this->id);
        if ($result) {
            foreach ($this as $key => $value) {
                if (property_exists($this, $key)) {
                    unset($this->$key);
                }
            }
        }
        return $result;
    }

    // ======== Instructor View =========
    public static function getInstructorSubjectDetails(int $instructor_Id): array
    {
        $subjects = Subject::getInstructorSubjects($instructor_Id);
        $instructorName = User::getActiveInstructors();
        $result = [];

        foreach ($subjects as $subject) {
            $grades = Subject::getSubjectCodeById($subject['id']);
            if ($grades) {
                foreach ($grades as $gradeEntry) {
                    $result[] = [
                        'subject_code'    => $subject['code'],
                        'subject_name'    => $subject['name'],
                        'year_level'      => $subject['year_level'],
                        'semester'        => $subject['semester'],
                        'instructor_name' => $instructorName,
                        'grade'           => $gradeEntry['grade'],
                        'remarks'         => $gradeEntry['remarks'],
                    ];
                }
            } else {
                $result[] = [
                    'subject_code'    => $subject['code'],
                    'subject_name'    => $subject['name'],
                    'year_level'      => $subject['year_level'],
                    'semester'        => $subject['semester'],
                    'instructor_name' => $instructorName,
                    'grade'           => null,
                    'remarks'         => null,
                ];
            }
        }

        return $result;
    }

    // ======== Student Records View =========
    public static function getAllStudents(): array
    {
        try {
            $sql = "SELECT * FROM students ORDER BY name ASC";
            $stmt = self::$conn->prepare($sql);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($students as &$student) {
                $student['course_name'] = self::getCourseNameById($student['course_id']);
            }

            return $students;
        } catch (Exception $e) {
            echo '(!) Error fetching students: ' . $e->getMessage();
            return [];
        }
    }

    public static function getCourseNameById(int $courseId): ?string
    {
        try {
            $sql = "SELECT name FROM courses WHERE course_id = ?";
            $stmt = self::$conn->prepare($sql);
            $stmt->execute([$courseId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['name'] ?? null;
        } catch (Exception $e) {
            echo '(!) Error fetching course name: ' . $e->getMessage();
            return null;
        }
    }

    public function getStudentProfile(int $studentId): ?array
    {
        try {
            $sql = "SELECT * FROM students WHERE id = ?";
            $stmt = self::$conn->prepare($sql);
            $stmt->execute([$studentId]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$student) return null;

            $student['course_name'] = $this->getCourseNameById($student['course_id']);
            return $student;
        } catch (Exception $e) {
            echo '(!) Error fetching student profile: ' . $e->getMessage();
            return null;
        }
    }

    // ======== Dashboard Logic =========
    public static function getAllStudentsWithYearLevel(): array
    {
      try {
          $sql = "SELECT student_id, course_id, year_level FROM students";
          $stmt = self::$conn->prepare($sql);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (Exception $e) {
          echo '(!) Error fetching student data: ' . $e->getMessage();
          return [];
      }
    }

    public static function getStudentInfoById(int $student_id): ?array
    {
        try {
            $sql = "SELECT id, student_id, name, year_level, course_id FROM students WHERE id = ?";
            $stmt = self::$conn->prepare($sql);
            $stmt->execute([$student_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo '(!) Error fetching student info: ' . $e->getMessage();
            return null;
        }
    }

    public static function getStudentsPerYearLevel(): array
    {
        if (self::$conn === null) {
            throw new Exception("Database connection not set.");
        }

        $stmt = self::$conn->query("SELECT course_id, year_level FROM students");
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $courseModel = new Course();
        $courseMap = $courseModel->getAllCourses();
        $yearLabels = [
            1 => '1st Year',
            2 => '2nd Year',
            3 => '3rd Year',
            4 => '4th Year',
        ];

        $studentsPerYearLevel = [];

        foreach ($students as $student) {
            $courseId = $student['course_id'] ?? null;
            $yearLevel = (int)($student['year_level'] ?? 0);

            $courseName = $courseMap[$courseId]['course_name'] ?? 'Unknown Course';
            $yearLabel = $yearLabels[$yearLevel] ?? "Year $yearLevel";

            if (!isset($studentsPerYearLevel[$courseName])) {
                foreach ($yearLabels as $label) {
                    $studentsPerYearLevel[$courseName][$label] = 0;
                }
            }

            $studentsPerYearLevel[$courseName][$yearLabel]++;
        }

        return $studentsPerYearLevel;
    }

    public function getAllStudentCourseIds(): array
    {
        try {
            $sql = "SELECT course_id FROM students";
            $stmt = static::$conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            echo '(!) Error fetching student course IDs: ' . $e->getMessage();
            return [];
        }
    }
  }
