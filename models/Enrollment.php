<?php

require_once 'Model.php';

class Enrollment extends Model
{
  protected static $table = 'subject_enrollments';

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
      'subEnrollment_id' => $this->subEnrollment_id,
      'student_id' => $this->student_id,
      'subject_id' => $this->subject_id,
      'status' => $this->status,
    ];
    $this->update($data);
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
}
