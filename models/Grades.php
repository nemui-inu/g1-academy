<?php
    require_once 'Model.php';
    require_once 'User.php';
    require_once 'Course.php';
    require_once 'Subject.php';
    require_once 'Enrollment.php';
    require_once 'Student.php';

class Grades extends Model
{
  protected static $table = 'grades';

  public $grade_id;
  public $student_id;
  public $subject_id;
  public $instructor_id;
  public $grade;
  public $remarks;
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
    $result = parent::updateById($this->grade_id, $data);

    if ($result) {
      foreach ($data as $key => $value) {
        if (property_exists($this, $key)) {
          $this->$key = $value;
        }
      }
      return true;
    } else {
      return false;
    }
  }

  public function save()
  {
    $data = [
      'student_id' => $this->student_id,
      'subject_id' => $this->subject_id,
      'instructor_id' => $this->instructor_id,
      'grade' => $this->grade,
      'remarks' => $this->remarks,
    ];

    if ($this->grade_id) {
      return $this->update($data);
    } else {
      $newGrade = self::create($data);
      if ($newGrade) {
        foreach ($data as $key => $value) {
          $this->$key = $value;
        }
        $this->grade_id = $newGrade->grade_id;
        return true;
      }
      return false;
    }
  }

  public function delete()
  {
    $result = parent::deleteById($this->grade_id);

    if ($result) {
      foreach ($this as $key => $value) {
        if (property_exists($this, $key)) {
          unset($this->$key);
        }
      }
      return true;
    } else {
      return false;
    }
  }

  public static function getPendingGradingDetails($instructor_id)
  {
    $query = "SELECT * FROM grades WHERE instructor_id = :instructor_id AND (remarks = 'Passed' OR grade IS NULL) ORDER BY created_at DESC";
    $stmt = static::$conn->prepare($query);
    $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
    $stmt->execute();
    $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $details = [];
    foreach ($grades as $grade) {
      $student = Student::getStudentInfoById($grade['student_id']);
      if (!$student) {
        continue;
      }
      $details[] = [
        'student_id'   => $grade['student_id'],
        'name'         => $student['name'],
        'year_level'   => $student['year_level'],
        'course_code'  => Course::getCourseCode($student['course_id']),
        'grade'        => $grade['grade'],
        'remarks'      => $grade['remarks'],
        'subject_code' => Subject::getSubjectCodeById($grade['subject_id']),
      ];
    }
    return $details;
  }
}
