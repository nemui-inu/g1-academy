<?php
    require_once 'Model.php';
    require_once 'User.php';
    require_once 'Course.php';
    require_once 'Subject.php';
    require_once 'Grades.php';
    require_once 'Student.php';

  class Enrollment extends Model
  {
    protected static $table = 'enrollments';

    public $subEnrollment_id;
    public $student_id;
    public $subject_id;
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
      $result = parent::updateById($this->subEnrollment_id, $data);

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
        'status' => $this->status,
      ];

      if ($this->subEnrollment_id) {
        return $this->update($data);
      } else {
        $newRecord = self::create($data);
        if ($newRecord) {
          foreach ($data as $key => $value) {
            $this->$key = $value;
          }
          $this->subEnrollment_id = $newRecord->subEnrollment_id;
          return true;
        }
        return false;
      }
    }

    public function delete()
    {
      $result = parent::deleteById($this->subEnrollment_id);

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

    public static function getEnrolledStudentsCountBySubjectId(int $subject_id): int {
        $conn = self::$conn;
        $sql = "SELECT COUNT(student_id) FROM subject_enrollments WHERE subject_id = :subject_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public static function getAllSubjectsWithEnrolledCounts(): array {
        $subjects = Subject::getAllSubjectsBasicInfo();
        foreach ($subjects as &$subject) {
            $subject['enrolled_count'] = self::getEnrolledStudentsCountBySubjectId($subject['id']);
        }
        return $subjects;
    }
  }
