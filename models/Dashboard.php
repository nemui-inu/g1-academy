<?php
    class Dashboard {
        private $conn;

        public $total_students;
        public $total_instructors;
        public $total_courses;
        public $total_subjects;
        public $total_admins;
        public $instructors;
        public $students_per_year_level;
        public $top_courses;
        public $subjects;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function getTotal($table, $condition = '') {
            $query = "SELECT COUNT(*) AS total FROM $table $condition";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        }

        public function getActiveInstructors() {
            $query = "SELECT * FROM users WHERE role = 'instructor' AND status = 'active'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getStudentsPerYearLevel() {
            $query = "SELECT c.name AS course_name, s.year_level, COUNT(s.student_id) AS student_count
                    FROM students s
                    JOIN courses c ON s.course_id = c.course_id
                    GROUP BY c.name, s.year_level
                    ORDER BY c.name, s.year_level";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $students_per_year_level = [];

            $yearLabels = [
                1 => '1st Year',
                2 => '2nd Year',
                3 => '3rd Year',
                4 => '4th Year'
            ];

            // Initialize all year levels to 0 for each course
            foreach ($result as $row) {
                $course = $row['course_name'];
                if (!isset($students_per_year_level[$course])) {
                    foreach ($yearLabels as $level => $label) {
                        $students_per_year_level[$course][$label] = 0;
                    }
                }

                $formattedYear = $yearLabels[$row['year_level']] ?? "Year {$row['year_level']}";
                $students_per_year_level[$course][$formattedYear] = $row['student_count'];
            }

            return $students_per_year_level;
        }

        public function getTopCourses($limit = 3) { 
            $query = "SELECT c.code AS course_code, c.name AS course_name, COUNT(s.student_id) AS student_count
                    FROM students s
                    JOIN courses c ON s.course_id = c.course_id
                    GROUP BY c.code, c.name
                    ORDER BY student_count DESC
                    LIMIT :limit";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getAllSubjects() {
            $query = "SELECT code, name FROM subjects ORDER BY name ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function loadDashboardData($user_role) {
            $this->total_students = $this->getTotal('students');
            $this->total_instructors = $this->getTotal('users', "WHERE role = 'instructor'");
            $this->total_courses = $this->getTotal('courses');
            $this->total_subjects = $this->getTotal('subjects');
            $this->instructors = $this->getActiveInstructors();
            $this->students_per_year_level = $this->getStudentsPerYearLevel();
            $this->top_courses = $this->getTopCourses();
            $this->subjects = $this->getAllSubjects();
            
            // Only if Super Admin
            if ($user_role === 'super-admin') {
                $this->total_admins = $this->getTotal('users', "WHERE role = 'admin'");
            }
        }

        public function getInstructorSubjects($instructor_id) {
            $query = "SELECT s.id, s.name, s.code, COUNT(se.subEnrollment_id) AS enrolled_students
                    FROM subjects s
                    LEFT JOIN subject_enrollments se ON s.id = se.subject_id AND se.status = 'enrolled'
                    WHERE s.instructor_id = :instructor_id
                    GROUP BY s.id, s.name, s.code
                    ORDER BY s.name ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getPendingGradingDetails($instructor_id) {
            $query = "
                SELECT 
                    s.student_id, 
                    s.name, 
                    s.year_level, 
                    g.grade, 
                    g.remarks 
                FROM grades g
                JOIN students s ON g.student_id = s.id
                WHERE g.instructor_id = :instructor_id AND (g.remarks = 'Pending' OR g.grade IS NULL)
                ORDER BY s.name ASC
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getEnrolledStudentsCount($subject_id) {
            $query = "SELECT COUNT(*) AS enrolled_count
                    FROM subject_enrollments
                    WHERE subject_id = :subject_id AND status = 'enrolled'";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        }

    }
?>
