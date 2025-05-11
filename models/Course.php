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
    $result = parent::updateById($this->user_id, $data);

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
      'code' => $this->email,
      'name' => $this->password,
    ];
    $this->update($data);
  }

  public function delete()
  {
    $result = parent::deleteById($this->user_id);

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
