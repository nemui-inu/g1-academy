<?php
  require_once 'Model.php';
  require_once 'Course.php';
  require_once 'Enrollment.php';

  class Subject extends Model
  {
    protected static $table = 'subjects';

    public $id;
    public $code;
    public $catalog_no;
    public $name;
    public $day;
    public $time;
    public $room;
    public $course_id;
    public $semester;
    public $year_level;
    public $instructor_id;
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

    public static function all()
    {
      $result = parent::all();
      return $result ? array_map(fn($data) => new self($data), $result) : null;
    }

    public static function find($id)
    {
      $result = parent::find($id);
      return $result ? new self($result) : null;
    }

    public static function create($data)
    {
      $result = parent::create($data);
      return $result ? new self($result) : null;
    }

    public function update($data)
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

    public function save()
    {
      $data = [
        'code' => $this->code,
        'catalog_no' => $this->catalog_no,
        'name' => $this->name,
        'day' => $this->day,
        'time' => $this->time,
        'room' => $this->room,
        'course_id' => $this->course_id,
        'semester' => $this->semester,
        'year_level' => $this->year_level,
        'instructor_id' => $this->instructor_id,
      ];

      return $this->id ? $this->update($data) : self::create($data);
    }

    public function delete()
    {
      return parent::deleteById($this->id);
    }

    public static function getAllSubjects() 
    {
      $query = "SELECT id, code, name FROM subjects ORDER BY name ASC";
      $stmt = self::$conn->prepare($query);
      $stmt->execute();
      $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($subjects as &$subject) {
        $subject['student_count'] = Enrollment::getEnrolledStudentsCountBySubjectId($subject['id']);
      }

      return $subjects;
    }

    public static function getAllSubjectsBasicInfo(): array 
    {
      $conn = self::$conn;
      $sql = "SELECT id, code, name FROM subjects ORDER BY code ASC";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getInstructorSubjects($instructor_id) 
    {
      $query = "SELECT id, name, code FROM subjects WHERE instructor_id = :instructor_id ORDER BY name ASC";
      $stmt = self::$conn->prepare($query);
      $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
      $stmt->execute();
      $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($subjects as &$subject) {
        $subject['enrolled_students'] = Enrollment::getEnrolledStudentsCountBySubjectId($subject['id']);
      }

      return $subjects;
    }

    public static function getSubjectCodeById($subject_id) 
    {
      $query = "SELECT code FROM subjects WHERE id = :subject_id";
      $stmt = self::$conn->prepare($query);
      $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchColumn();
    }

    public static function getInstructorSchedules($instructor_id) 
    {
      $query = "SELECT * FROM subjects WHERE instructor_id = :instructor_id 
                ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), time";
      $stmt = self::$conn->prepare($query);
      $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
      $stmt->execute();
      $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $schedules = [];
      foreach ($subjects as $subj) {
        $schedules[] = [
          'day'           => $subj['day'],
          'time'          => $subj['time'],
          'room'          => $subj['room'],
          'subject_name'  => $subj['name'],
          'subject_code'  => $subj['code'],
          'course_name'   => Course::getCourseName($subj['course_id']),
          'year_level'    => $subj['year_level'],
          'semester'      => $subj['semester']
        ];
      }

      return $schedules;
    }
  }
