<?php

class Model
{
  protected static $conn;
  protected static $table;

  public static function setConnection($conn)
  {
    self::$conn = $conn;
  }

  public static function all()
  {
    try {
      $sql = 'select * from ' . static::$table . ';';
      $stmt = self::$conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();

      return count($result) > 0 ? $result : null;
    } catch (Exception $e) {
      echo '(!) Error preparing statement: ' . $e->getMessage();
    }
  }

  public static function find($id)
  {
    try {
      $sql = 'select * from ' . static::$table . ' where id = ?;';
      $stmt = self::$conn->prepare($sql);
      $stmt->execute([$id]);
      $result = $stmt->fetchAll();

      return count($result) > 0 ? $result[0] : false;
    } catch (Exception $e) {
      echo '(!) Error preparing statement: ' . $e->getMessage();
    }
  }

  public static function create(array $data)
  {
    try {
      $columns = implode(', ', array_keys($data));
      $values = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));
      $sql = 'insert into ' . static::$table . " ($columns) values ($values);";
      $stmt = self::$conn->prepare($sql);

      foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
      }

      $stmt->execute();
      $id = self::$conn->lastInsertId();

      return self::find($id);
    } catch (PDOException $e) {
      echo '(!) Error preparing statement: ' . $e->getMessage();
    }
  }

  public static function updateById($id, array $data)
  {
    try {
      $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
      $sql = 'update ' . static::$table . " set $set where id = :id;";

      $stmt = self::$conn->prepare($sql);

      foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
      }

      $stmt->bindValue(':id', $id);
      $stmt->execute();

      return self::find($id);
    } catch (PDOException $e) {
      echo '(!) Error preparing statement: ' . $e->getMessage();
    }
  }

  public static function deleteById($id)
  {
    try {
      $sql = 'delete from ' . static::$table . ' where id = :id;';
      $stmt = self::$conn->prepare($sql);

      $stmt->bindValue(':id', $id);

      return $stmt->execute();
    } catch (PDOException $e) {
      echo '(!) Error preparing statement: ' . $e->getMessage();
    }
  }
}
