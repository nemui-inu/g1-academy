<?php declare(strict_types=1);

require_once 'models/Subject.php';
require_once 'models/Student.php';
require_once 'models/Grades.php';
require_once 'models/Model.php';

class GradesController
{

    
    public function index()
    {
        die("📢 GradesController index() is running");
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }

        $instructor_id = $_SESSION['user_id'];

        $sql = "SELECT * FROM subjects WHERE instructor_id = ?";
        $conn = Model::getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([$instructor_id]);
        $subject_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $subjects = array_map(fn($data) => new Subject($data), $subject_rows);

        include 'views/grades/index.php';
    }

    public function show()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }

        $subject_id = $_GET['subject_id'] ?? null;
        if (!$subject_id) {
            echo "Subject ID is missing.";
            return;
        }

        $sql = "
            SELECT students.*
            FROM students
            JOIN subject_enrollments ON students.id = subject_enrollments.student_id
            WHERE subject_enrollments.subject_id = ?
              AND subject_enrollments.status = 'Enrolled'
              AND students.status = 'active'
        ";
        $conn = Model::getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([$subject_id]);
        $student_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $students = array_map(fn($data) => new Student($data), $student_rows);

        $allGrades = Grades::all();
        $grades = [];

        foreach ($allGrades as $grade) {
            if ($grade->subject_id == $subject_id) {
                $grades[$grade->student_id] = $grade;
            }
        }

        include 'views/grades/show.php';
    }

    public function update()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $instructor_id = $_SESSION['user_id'];
            $subject_id = $_POST['subject_id'];
            $grades_input = $_POST['grades'];

            $existing_grades = Grades::all();

            foreach ($grades_input as $student_id => $data) {
                $grade = $data['grade'];
                $remarks = $data['remarks'];

                $existing = null;
                foreach ($existing_grades as $g) {
                    if ($g->student_id == $student_id && $g->subject_id == $subject_id) {
                        $existing = $g;
                        break;
                    }
                }

                if ($existing) {
                    $existing->update([
                        'grade' => $grade,
                        'remarks' => $remarks,
                    ]);
                } else {
                    Grades::create([
                        'student_id' => $student_id,
                        'subject_id' => $subject_id,
                        'instructor_id' => $instructor_id,
                        'grade' => $grade,
                        'remarks' => $remarks,
                    ]);
                }
            }

            header("Location: ?page=grades&action=show&subject_id=$subject_id&saved=true");
            exit;
        } else {
            echo "Invalid request.";
        }
    }
}


