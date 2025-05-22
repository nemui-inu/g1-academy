<?php
session_start();

require '../plugins/fpdf/fpdf.php';
require_once '../models/Database.php';
require_once '../models/Student.php';

$database = new Database();
$conn = $database->getConnection();
Student::setConnection($conn);

    $year = $_GET['year'] ?? null;
    $title = $year ? "Inactive Students - Year $year" : "All Inactive Students Report";

// Fetch inactive students
$sql = "
    SELECT s.student_id, s.name AS student_name, s.gender, s.birthdate, s.year_level, c.name AS course_name
    FROM students s
    JOIN courses c ON s.course_id = c.course_id
    WHERE s.status = 'inactive'
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_OBJ);

// Helper
function getYearLabel($year) {
    $labels = ['1' => '1st Year', '2' => '2nd Year', '3' => '3rd Year', '4' => '4th Year'];
    return $labels[$year] ?? $year;
}

// Initialize PDF
$pdf = new FPDF('L', 'mm', 'Legal');
$pdf->AddPage();

// Title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, $title, 0, 1, 'C');
$pdf->Ln(2);

// Table Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No.', 1, 0, 'C');
$pdf->Cell(30, 10, 'Student ID', 1, 0, 'C');
$pdf->Cell(80, 10, 'Name', 1, 0, 'C');
$pdf->Cell(25, 10, 'Gender', 1, 0, 'C');
$pdf->Cell(35, 10, 'Birthdate', 1, 0, 'C');
$pdf->Cell(120, 10, 'Course', 1, 0, 'C');
$pdf->Cell(30, 10, 'Year Level', 1, 1, 'C');

// Table Data
$pdf->SetFont('Arial', '', 12);
if (!empty($students)) {
    $i = 1;
    foreach ($students as $student) {
        $pdf->Cell(10, 10, $i++, 1, 0, 'C');
        $pdf->Cell(30, 10, $student->student_id, 1, 0, 'C');
        $pdf->Cell(80, 10, utf8_decode($student->student_name), 1, 0, 'L');
        $pdf->Cell(25, 10, ucfirst($student->gender), 1, 0, 'C');
        $pdf->Cell(35, 10, $student->birthdate, 1, 0, 'C');
        $pdf->Cell(120, 10, utf8_decode($student->course_name), 1, 0, 'L');
        $pdf->Cell(30, 10, getYearLabel($student->year_level), 1, 1, 'C');
    }
} else {
    $pdf->Cell(0, 10, 'No inactive students found.', 1, 1, 'C');
}

$pdf->Output('I', 'Inactive_Students_Report.pdf');
exit;
