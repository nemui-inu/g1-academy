<?php

require_once 'Model.php';

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

    $db = new Database();
    $conn = $db->getConnection();

    self::setConnection($conn);
  }

  public static function all()
  {
    $result = parent::all();
    return $result ? array_map(fn($data) => new self($data), $result) : null;
  }

  public static function find($id)
  {
    try {
      $sql = 'select * from ' . static::$table . ' where user_id = ?;';
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

  public function update(array $dataset): array
  {
    try {
      $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($dataset)));
      $sql = 'update ' . static::$table . " set $set where user_id = :user_id;";

      $stmt = self::$conn->prepare($sql);

      foreach ($dataset as $key => $value) {
        $stmt->bindValue(":$key", $value);
      }

      $stmt->bindValue(':user_id', $this->user_id);
      $stmt->execute();

      return self::find($this->user_id);
    } catch (PDOException $e) {
      echo '(!) Error preparing statement: ' . $e->getMessage();
      return [];
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

  public static function findByEmail($email)
  {
    try {
      $sql = 'select * from ' . static::$table . ' where email = ?;';
      $stmt = self::$conn->prepare($sql);
      $stmt->execute([$email]);
      $result = $stmt->fetchAll();

      return count($result) > 0 ? $result[0] : false;
    } catch (Exception $e) {
      die('(!) Error preparing statement: ' . $e->getMessage());
    }
  }
}
