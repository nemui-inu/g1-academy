<?php
    require_once 'User.php';
    require_once 'Subject.php';
    require_once 'Enrollment.php';
    require_once 'Grades.php';
    require_once 'Student.php';

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
      try {
        $sql = 'SELECT * FROM ' . static::$table . ';';
        $stmt = self::$conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results ? array_map(fn($data) => new self($data), $results) : null;
      } catch (Exception $e) {
        echo '(!) Error: ' . $e->getMessage();
        return null;
      }
    }

    public static function find($id)
    {
      try {
        $sql = 'SELECT * FROM ' . static::$table . ' WHERE course_id = ?;';
        $stmt = self::$conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        return $result ? new self($result) : null;
      } catch (Exception $e) {
        echo '(!) Error: ' . $e->getMessage();
        return null;
      }
    }

    public static function create($data)
    {
      $result = parent::create($data);
      return $result ? new self($result) : null;
    }

    public function update($course_id, array $data)
    {
      try {
        $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
        $sql = 'UPDATE ' . static::$table . " SET $set WHERE course_id = :course_id;";

        $stmt = self::$conn->prepare($sql);

        foreach ($data as $key => $value) {
          $stmt->bindValue(":$key", $value);
        }

        $stmt->bindValue(':course_id', $course_id);
        $stmt->execute();

        return self::find($course_id);
      } catch (PDOException $e) {
        echo '(!) Error: ' . $e->getMessage();
        return null;
      }
    }

    public function save()
    {
      $data = [
        'code' => $this->code,
        'name' => $this->name,
      ];
      return $this->update($this->course_id, $data);
    }

    public function delete(): bool
    {
      try {
        $sql = 'DELETE FROM ' . static::$table . ' WHERE course_id = :id;';
        $stmt = self::$conn->prepare($sql);
        $stmt->bindValue(':id', $this->course_id);
        $result = $stmt->execute();

        if ($result) {
          foreach ($this as $key => $value) {
            if (property_exists($this, $key)) {
              unset($this->$key);
            }
          }
        }

        return $result;
      } catch (PDOException $e) {
        echo '(!) Error: ' . $e->getMessage();
        return false;
      }
    }

    public static function getAllCourses(): array
    {
      $stmt = self::$conn->query("SELECT course_id, name FROM courses");
      $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $courseMap = [];
      foreach ($courses as $course) {
          $courseMap[$course['course_id']] = ['course_name' => $course['name']];
      }
      return $courseMap;
    }

    public static function getCourseName($course_id) 
    {
      $query = "SELECT name FROM courses WHERE course_id = :course_id";
      $stmt = self::$conn->prepare($query);
      $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchColumn();
    }

    public static function getCourseCode($course_id) 
    {
      $query = "SELECT code FROM courses WHERE course_id = :course_id";
      $stmt = self::$conn->prepare($query);
      $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchColumn();
    }

    public static function getTopEnrolledCourses($limit = 3)
    {
      $course_ids = self::getTopCourseIdsByEnrollment($limit);
      return self::buildTopCoursesData($course_ids);
    }

    private static function getTopCourseIdsByEnrollment($limit)
    {
      $sql = "SELECT course_id, COUNT(*) AS student_count 
              FROM students 
              GROUP BY course_id 
              ORDER BY student_count DESC 
              LIMIT :limit";

      $stmt = self::$conn->prepare($sql);
      $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC); // returns course_id + student_count
    }

    private static function buildTopCoursesData($courseRows)
    {
      $top_courses = [];

      foreach ($courseRows as $row) {
          $course_id = $row['course_id'];
          $top_courses[] = [
              'course_code' => self::getCourseCode($course_id),
              'course_name' => self::getCourseName($course_id),
              'student_count' => (int) $row['student_count'],
          ];
      }

      return $top_courses;
    }
  }