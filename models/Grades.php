<?php

require_once 'Model.php';

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
      'name' => $this->name,
      'email' => $this->email,
      'password' => $this->password,
      'role' => $this->role,
      'status' => $this->status,
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
}
