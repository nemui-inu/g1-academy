<?php

require_once 'Model.php';

class Course extends Model
{
  protected static $table = 'courses';

  public $course_id;
  public $code;
  public $name;
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
    try {
      $sql = 'select * from ' . static::$table . ' where course_id = ?;';
      $stmt = self::$conn->prepare($sql);
      $stmt->execute([$id]);
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

  public function update(array $data)
  {
    try {
      $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
      $sql = 'update ' . static::$table . " set $set where course_id = :course_id;";

      $stmt = self::$conn->prepare($sql);

      foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
      }

      $stmt->bindValue(':course_id', $this->course_id);
      $stmt->execute();

      return self::find($this->course_id);
    } catch (PDOException $e) {
      echo '(!) Error preparing statement: ' . $e->getMessage();
    }
  }

  public function save()
  {
    $data = [
      'code' => $this->code,
      'name' => $this->name,
    ];
    $this->update($data);
  }

  public function delete(): bool
  {
    try {
      $sql = 'delete from ' . static::$table . ' where course_id = :id;';
      $stmt = self::$conn->prepare($sql);

      $stmt->bindValue(':id', $this->course_id);

      $result = $stmt->execute();
    } catch (PDOException $e) {
      echo '(!) Error preparing statement: ' . $e->getMessage();
    }

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

  public static function getCourses(): array
  {
    $db = new Database();
    $conn = $db->getConnection();

    $query = 'SELECT course_id, code FROM courses';
    $stmt = $conn->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll();
  }
}
