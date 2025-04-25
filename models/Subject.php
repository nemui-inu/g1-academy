<?php

require_once 'Model.php';

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
      return true;
    } else {
      return false;
    }
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
      'instructor_id' => $this->instructor_id
    ];

    if ($this->id) {
      return $this->update($data);
    } else {
      return self::create($data);
    }
  }

  public function delete()
  {
    $result = parent::deleteById($this->id);

    if ($result) {
      foreach ($this as $key => $value) {
        unset($this->$key);
      }
      return true;
    } else {
      return false;
    }
  }
}
