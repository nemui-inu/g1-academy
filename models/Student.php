<?php

require_once 'Model.php';

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
    return $result ? (array) array_map(fn($data) => new self($data), $result) : null;
  }

  public static function find($id)
  {
    $result = parent::find($id);
    return $result ? new self($result) : null;
  }

  public static function findByStudentId(string $studentId)
  {
    try {
      $sql = 'select * from students where student_id = ?;';
      $stmt = self::$conn->prepare($sql);
      $stmt->execute([$studentId]);
      $result = $stmt->fetchAll();

      return count($result) > 0 ? $result[0] : false;
    } catch (Exception $e) {
      echo '(!) Error preparing statement: ' . $e->getMessage();
    }
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
      return true;
    } else {
      return false;
    }
  }

  public function save()
  {
    $data = [
      'student_id' => $this->student_id,
      'name' => $this->name,
      'gender' => $this->gender,
      'birthdate' => $this->birthdate,
      'course_id' => $this->course_id,
      'year_level' => $this->year_level,
      'status' => $this->status,
    ];
    $this->update($data);
  }

  public function delete()
  {
    $result = parent::deleteById($this->id);

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
}
