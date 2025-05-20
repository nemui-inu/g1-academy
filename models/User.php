<?php
  require_once 'Model.php';
  require_once 'Course.php';
  require_once 'Subject.php';
  require_once 'Enrollment.php';
  require_once 'Grades.php';
  require_once 'Student.php';

  class User extends Model
  {
    protected static $table = 'users';

    public $user_id;
    public $name;
    public $email;
    public $password;
    public $role;
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
      $result = parent::updateById($this->user_id, $data);

      if ($result) {
        foreach ($data as $key => $value) {
          if (property_exists($this, $key)) {
            $this->$key = $value;
          }
        }
        return true;
      }

      return false;
    }

    public function save()
    {
      $data = [
        'name'     => $this->name,
        'email'    => $this->email,
        'password' => $this->password,
        'role'     => $this->role,
        'status'   => $this->status,
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
      }

      return $result;
    }

    public static function findByEmail($email)
    {
      try {
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE email = ?;';
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetchAll();

        return $result ? $result[0] : false;
      } catch (Exception $e) {
        die('(!) Error preparing statement: ' . $e->getMessage());
      }
    }

    public static function getActiveInstructors()
    {
      $query = "SELECT * FROM users WHERE role = 'instructor' AND status = 'active'";
      $stmt = self::$conn->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }
