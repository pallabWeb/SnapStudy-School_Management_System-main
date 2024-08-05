<?php
// Start session
session_start();

// Check if student is logged in
if (!isset($_SESSION['student_username'])) {
    // Redirect to login page if not logged in
    header("Location: ./home/#login");
    exit();
}

// Include FPDF library
require('./fpdf/fpdf.php');

// Database connection
include_once 'db.php';

// Student username from session
$student_username = $_SESSION['student_username'];

// Fetch student data from the database
$sql = "SELECT * FROM students WHERE student_username = '$student_username'";
$result = $data->query($sql);

// Fetch marks data from the database
$sql_marks = "SELECT * FROM marks WHERE student_username = '$student_username'";
$result_marks = $data->query($sql_marks);

// Check if there are no results to display
if ($result_marks->num_rows == 0) {
    // If no results, display a message
    echo "<h1 style='text-align: center; margin-top: 50px; font-weight: bold;'>No results found</h1>";
    exit(); // Stop further execution
}

// Initialize PDF object
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont("Arial", "", 14);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'Result', 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 19);
$pdf->Cell(0, 10, 'SUNSHINE ACADEMY', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Main Office:- P.O.-Madhyamgram,Bus Stop:New Barrakpur,Kolkata-700129', 0, 1, 'C');
$pdf->Cell(0, 10, 'School Campus:- P.O.-Barasat,Kolkata-700129', 0, 1, 'C');
$pdf->Cell(0, 10, 'Phone:- 7896584578 ,+91 8569874859', 0, 1, 'C');

$pdf->Ln();

// Reset font size to default
$pdf->SetFont('Arial', '', 12);

// Student information
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(0, 10, 'Name: ' . $row['name'], 0, 0, 'L');
    $pdf->Cell(0, 10, 'Class: ' . $row['class'], 0, 1, 'R');
    $pdf->Cell(0, 10, 'Email: ' . $row['email'], 0, 0, 'L');
    $pdf->Cell(0, 10, 'Roll No: ' . $row['id'], 0, 1, 'R');
}

$pdf->Ln();

// Subject-wise marks and grades
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, 'Subject', 1, 0, 'C'); // Add true as the last parameter to enable background color
$pdf->Cell(50, 10, 'Marks Obtained', 1, 0, 'C');
$pdf->Cell(50, 10, 'Grade', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);
while ($row_marks = $result_marks->fetch_assoc()) {
    // Loop through each subject and output marks and grades
    $subjects = array(
        'Bengali' => $row_marks['bengali_marks'],
        'English' => $row_marks['english_marks'],
        'Mathematics' => $row_marks['mathematics_marks'],
        'Life Science' => $row_marks['life_science_marks'],
        'Physical Science' => $row_marks['physical_science_marks'],
        'History' => $row_marks['history_marks'],
        'Geography' => $row_marks['geography_marks'],
        'Extracurricular' => $row_marks['extracurricular_marks']
    );

    foreach ($subjects as $subject => $marks) {
        // Calculate grade for each subject
        $grade = calculateGrade($marks);

        // Output subject, marks, and grade in the PDF
        $pdf->Cell(90, 10, $subject, 1, 0, 'C');
        $pdf->Cell(50, 10, $marks, 1, 0, 'C');
        $pdf->Cell(50, 10, $grade, 1, 1, 'C');
    }
}

$pdf->Ln();

// Total marks
$total_marks = 0;
$result_marks->data_seek(0); // Reset the result pointer to the beginning
while ($row_marks = $result_marks->fetch_assoc()) {
    $total_marks += array_sum($row_marks);
}
$pdf->Cell(140, 10, 'Total Marks:', 1, 0, 'L');
$pdf->Cell(50, 10, $total_marks, 1, 1, 'C');

// Determine pass or fail
$passOrFail = ($total_marks >= 400) ? 'Pass' : 'Fail';

// Output pass or fail condition
$pdf->Cell(140, 10, 'Result:', 1, 0, 'L');
$pdf->Cell(50, 10, $passOrFail, 1, 1, 'C');

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

// Print date
$pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 0, 'L');

// Signature section
$pdf->Cell(0, 10, '_________________________', 0, 1, 'R');
$pdf->Cell(0, 5, 'Controller of Examinations    ', 0, 0, 'R'); // Added line break

// Close PDF
$pdf->Close();

// Output PDF
// Fetch student data from the database to get the student's name
$sql_student = "SELECT name FROM students WHERE student_username = '$student_username'";
$result_student = $data->query($sql_student);

// Initialize variable to store student's name
$student_name = "";

// Check if the student data is fetched successfully
if ($result_student->num_rows > 0) {
    // Fetch the student's name
    $row_student = $result_student->fetch_assoc();
    $student_name = $row_student['name'];
}

// Generate a filename using the student's name and current date
$filename = $student_name . '_Result_' . date('Y-m-d') . '.pdf';

// Specify the folder path where you want to store the file
$folderPath = 'uploads/';

// Check if the folder exists, if not, create it
if (!file_exists($folderPath)) {
    mkdir($folderPath, 0777, true); // Create the folder recursively
}

// Specify the complete file path including the folder
$filePath = $folderPath . $filename;

$pdf->Output('F', $filePath);

// Function to calculate grade
function calculateGrade($marks)
{
    if ($marks >= 90) {
        return 'A+';
    } elseif ($marks >= 80) {
        return 'A';
    } elseif ($marks >= 70) {
        return 'B+';
    } elseif ($marks >= 60) {
        return 'B';
    } elseif ($marks >= 50) {
        return 'C+';
    } elseif ($marks >= 40) {
        return 'C';
    } elseif ($marks >= 33) {
        return 'D';
    } else {
        return 'F';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <!-- Favicon -->
    <link rel="icon" href="./img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
    <title>View Marksheet</title>

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #pdf-container {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <!-- Display PDF -->
    <div id="pdf-container">
        <embed id="pdf-viewer" src="<?php echo $filePath; ?>" width="100%" height="100%"></embed>
    </div>

    <script>
        // JavaScript code to display PDF in full screen
        const pdfViewer = document.getElementById('pdf-viewer');
        pdfViewer.requestFullscreen();
    </script>
</body>

</html>