<?php
    require_once 'Model.php';
    require_once 'User.php';
    require_once 'Course.php';
    require_once 'Subject.php';
    require_once 'Enrollment.php';
    require_once 'Grades.php';
    require_once 'Student.php';

    class Dashboard 
    {
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
            return User::getActiveInstructors();
        }

        public function getStudentsPerYearLevel() {
            return Student::getStudentsPerYearLevel();
        }

        public function getTopCourses($limit = 3) {
            return Course::getTopEnrolledCourses($limit);
        }

        public function getAllSubjects() {
            return Enrollment::getAllSubjectsWithEnrolledCounts();
        }

        public function getEnrolledStudentsCount($subject_id) {
            return Enrollment::getEnrolledStudentsCountBySubjectId($subject_id);
        }

        public function getInstructorSubjects($instructor_id) {
            return Subject::getInstructorSubjects($instructor_id);
        }

        public function getStudentDetails($student_id) {
            return Student::getStudentInfoById($student_id);
        }

        public function getSubjectCode($subject_id) {
            return Subject::getSubjectCodeById($subject_id);
        }

        public function getPendingGradingDetails($instructor_id)
        {
            Grades::setConnection($this->conn);
            return Grades::getPendingGradingDetails($instructor_id);
        }


        public function getInstructorSchedules($instructor_id) {
            return Subject::getInstructorSchedules($instructor_id);
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

            if ($user_role === 'super-admin') {
                $this->total_admins = $this->getTotal('users', "WHERE role = 'admin'");
            }
        }
    }
?>