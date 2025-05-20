<?php
  class Model
  {
    protected static $conn;
    protected static $table;

    public static function setConnection(PDO $conn) {
      self::$conn = $conn;
    }
    
    public static function getConnection() 
    {
      return self::$conn;
    }

    public static function all()
    {
      try {
        $sql = 'SELECT * FROM ' . static::$table . ';';
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return count($result) > 0 ? $result : null;
      } catch (Exception $e) {
        echo '(!) Error preparing statement: ' . $e->getMessage();
        return null;
      }
    }

    public static function find($id)
    {
      try {
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE id = ?;';
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchAll();

        return count($result) > 0 ? $result[0] : false;
      } catch (Exception $e) {
        echo '(!) Error preparing statement: ' . $e->getMessage();
        return false;
      }
    }

    public static function create(array $data)
    {
      try {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_map(fn($key) => ":$key", array_keys($data)));
        $sql = 'INSERT INTO ' . static::$table . " ($columns) VALUES ($values);";
        $stmt = self::$conn->prepare($sql);

        foreach ($data as $key => $value) {
          $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        $id = self::$conn->lastInsertId();

        return self::find($id);
      } catch (PDOException $e) {
        echo '(!) Error preparing statement: ' . $e->getMessage();
        return null;
      }
    }

    public static function updateById($id, array $data)
    {
      try {
        $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = 'UPDATE ' . static::$table . " SET $set WHERE id = :id;";

        $stmt = self::$conn->prepare($sql);

        foreach ($data as $key => $value) {
          $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return self::find($id);
      } catch (PDOException $e) {
        echo '(!) Error preparing statement: ' . $e->getMessage();
        return false;
      }
    }

    public static function deleteById($id)
    {
      try {
        $sql = 'DELETE FROM ' . static::$table . ' WHERE id = :id;';
        $stmt = self::$conn->prepare($sql);

        $stmt->bindValue(':id', $id);

        return $stmt->execute();
      } catch (PDOException $e) {
        echo '(!) Error preparing statement: ' . $e->getMessage();
        return false;
      }
    }
  }
