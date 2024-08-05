<?php
session_start();
if (!isset($_SESSION['fees_username'])) {
    header("location: ./home/#login");
    exit();
}

// Include database connection
include_once 'db.php';

// Include FPDF library
require_once('fpdf/fpdf.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set in the form data
    if (
        isset($_POST['student_id']) &&
        isset($_POST['after_6_months_fees_amount']) &&
        isset($_POST['library_fees_amount']) &&
        isset($_POST['tuition_fees_amount']) &&
        isset($_POST['development_fees_amount']) &&
        isset($_POST['extra_fees_amount']) &&
        isset($_POST['transaction_mode']) &&
        isset($_POST['payment_id']) &&
        isset($_POST['cycle']) // New field to select the cycle
    ) {
        // Retrieve data from form
        $student_id = $_POST['student_id'];
        $after_6_months_fees_amount = $_POST['after_6_months_fees_amount'];
        $library_fees_amount = $_POST['library_fees_amount'];
        $tuition_fees_amount = $_POST['tuition_fees_amount'];
        $development_fees_amount = $_POST['development_fees_amount'];
        $extra_fees_amount = $_POST['extra_fees_amount'];
        $transaction_mode = $_POST['transaction_mode'];
        $transaction_id = $_POST['payment_id'];
        $cycle = $_POST['cycle']; // Retrieve the cycle (1st 6 Months or 2nd 6 Months)

        // Validate fees amounts
        if (
            !is_numeric($after_6_months_fees_amount) || $after_6_months_fees_amount <= 0 ||
            !is_numeric($library_fees_amount) || $library_fees_amount <= 0 ||
            !is_numeric($tuition_fees_amount) || $tuition_fees_amount <= 0 ||
            !is_numeric($development_fees_amount) || $development_fees_amount <= 0 ||
            !is_numeric($extra_fees_amount) || $extra_fees_amount <= 0
        ) {
            echo "Invalid fees amounts.";
            exit;
        }

        // Retrieve student's username, class, and payment status from the students table
        $student_query = "SELECT student_username, class, payment_status FROM students WHERE id = $student_id";
        $student_result = $data->query($student_query);
        if ($student_result->num_rows > 0) {
            $student_row = $student_result->fetch_assoc();
            $student_username = $student_row['student_username'];
            $student_class = $student_row['class'];
            $payment_status = $student_row['payment_status'];

            // Insert or update fees record in the after_6_months_fees table
            $sql = "INSERT INTO after_6_months_fees (student_id, after_6_months_fees_amount, library_fees_amount, tuition_fees_amount, development_fees_amount, extra_fees_amount, transaction_mode, payment_id) 
                    VALUES ($student_id, $after_6_months_fees_amount, $library_fees_amount, $tuition_fees_amount, $development_fees_amount, $extra_fees_amount, '$transaction_mode', '$transaction_id')
                    ON DUPLICATE KEY UPDATE 
                        after_6_months_fees_amount = VALUES(after_6_months_fees_amount),
                        library_fees_amount = VALUES(library_fees_amount),
                        tuition_fees_amount = VALUES(tuition_fees_amount),
                        development_fees_amount = VALUES(development_fees_amount),
                        extra_fees_amount = VALUES(extra_fees_amount),
                        transaction_mode = VALUES(transaction_mode),
                        payment_id = VALUES(payment_id)";
            if ($data->query($sql) === TRUE) {
                // Update payment status in the students table
                if ($payment_status == 'Not Paid') {
                    $update_sql = "UPDATE students SET payment_status = '50% Paid' WHERE id = $student_id";
                } else {
                    $update_sql = "UPDATE students SET payment_status = 'Paid' WHERE id = $student_id";
                }
                if ($data->query($update_sql) === TRUE) {
                    // Generate the selected PDF cycle
                    $pdf = new FPDF();
                    generate_pdf($pdf, $student_id, $student_username, $student_class, $after_6_months_fees_amount, $library_fees_amount, $tuition_fees_amount, $development_fees_amount, $extra_fees_amount, $transaction_mode, $transaction_id, $cycle);

                    $pdf_content = $pdf->Output("{$cycle}_fees_of_$student_username.pdf", "I");
                    if (file_put_contents($pdf_path, $pdf_content) !== false) {
                        // Save the PDF path to the database
                        $column_name = ($cycle == "1st 6 Months") ? 'pdf_path_1' : 'pdf_path_2';
                        $insert_pdf_sql = "UPDATE after_6_months_fees SET $column_name = '$pdf_path' WHERE student_id = $student_id";
                        if ($data->query($insert_pdf_sql) === TRUE) {
                            echo "<script>alert('PDF and Payment status updated successfully.')</script>";
                            echo "<script>window.location.href = 'updatestu.php';</script>"; // Redirect to payment page
                        } else {
                            echo "Error saving PDF path in the database: " . $data->error;
                        }
                    } else {
                        echo "Error saving PDF to the folder.";
                    }
                } else {
                    echo "Error updating payment status: " . $data->error;
                }
            } else {
                echo "Error: " . $sql . "<br>" . $data->error;
            }
        } else {
            echo "Student not found in the database.";
        }
    } else {
        // Student ID or fees amounts not set in the form data
        echo "Student ID or fees amounts not specified.";
    }
} else {
    // Form not submitted using POST method
    echo "Form not submitted using POST method.";
}

// Function to generate PDF
function generate_pdf($pdf, $student_id, $student_username, $student_class, $fees_amount, $library_amount, $tuition_amount, $development_fees_amount, $extra_fees_amount, $transaction_mode, $transaction_id, $cycle)
{
    // PDF content
    $pdf->AddPage();
    $pdf->SetFont("Arial", "", 14);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 10, 'Fees Collection', 0, 0, 'L');
    $pdf->Cell(0, 10, $cycle, 0, 1, 'R');
    $pdf->SetFont('Arial', 'B', 19);
    $pdf->Cell(0, 10, 'SUNSHINE ACADEMY', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Main Office:- P.O.-Madhyamgram,Bus Stop:New Barrakpur,Kolkata-700129', 0, 1, 'C');
    $pdf->Cell(0, 10, 'School Campus:- P.O.-Barasat,Kolkata-700129', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Phone:- 7896584578 ,+91 8569874859', 0, 1, 'C');

    $pdf->Ln();
    $pdf->Ln();

    $pdf->Cell(0, 10, "Student Details", 1, 1, 'C');

    // Add student details to the PDF
    $pdf->Cell(40, 10, "Student ID", 1, 0, 'C');
    $pdf->Cell(80, 10, "Student Name", 1, 0, 'C');
    $pdf->Cell(40, 10, "Fees Amount", 1, 0, 'C');
    $pdf->Cell(30, 10, "Date", 1, 1, 'C');

    $pdf->Cell(40, 10, "$student_id", 1, 0, 'C');
    $pdf->Cell(80, 10, "$student_username", 1, 0, 'C');
    $pdf->Cell(40, 10, "$fees_amount", 1, 0, 'C');
    $pdf->Cell(30, 10, date('Y-m-d'), 1, 1, 'C');

    $pdf->Cell(40, 10, "Class", 1, 0, 'C');
    $pdf->Cell(80, 10, "Mode Of Payment", 1, 0, 'C');
    $pdf->Cell(40, 10, "Transaction ID", 1, 0, 'C');
    $pdf->Cell(30, 10, "Payment Type", 1, 1, 'C');

    $pdf->Cell(40, 10, "$student_class", 1, 0, 'C');
    $pdf->Cell(80, 10, "$transaction_mode", 1, 0, 'C');
    $pdf->Cell(40, 10, "$transaction_id", 1, 0, 'C');
    $pdf->Cell(30, 10, "$cycle", 1, 1, 'C');

    $pdf->Ln();

    $pdf->Cell(0, 10, "Payment Details", 1, 1, 'C');

    // Add payment details to the PDF
    $pdf->Cell(20, 10, "Sl NO.", 1, 0, 'C');
    $pdf->Cell(50, 10, "FEES FOR", 1, 0, 'C');
    $pdf->Cell(45, 10, "ANNUAL FEES", 1, 0, 'C');
    $pdf->Cell(45, 10, "AMOUNT PAID", 1, 0, 'C');
    $pdf->Cell(30, 10, "BALANCE", 1, 1, 'C');

    $pdf->Cell(20, 10, "1", 1, 0, 'C');
    $pdf->Cell(50, 10, "DEVELOPMENT FEES", 1, 0, 'C');
    $pdf->Cell(45, 10, "20000", 1, 0, 'C');
    $pdf->Cell(45, 10, "$development_fees_amount", 1, 0, 'C');
    $pdf->Cell(30, 10, "0", 1, 1, 'C');

    $pdf->Cell(20, 10, "2", 1, 0, 'C');
    $pdf->Cell(50, 10, "LIBRARY FEES", 1, 0, 'C');
    $pdf->Cell(45, 10, "10000", 1, 0, 'C');
    $pdf->Cell(45, 10, "$library_amount", 1, 0, 'C');
    $pdf->Cell(30, 10, "0", 1, 1, 'C');

    $pdf->Cell(20, 10, "3", 1, 0, 'C');
    $pdf->Cell(50, 10, "EXTRA FEES", 1, 0, 'C');
    $pdf->Cell(45, 10, "6000", 1, 0, 'C');
    $pdf->Cell(45, 10, "$extra_fees_amount", 1, 0, 'C');
    $pdf->Cell(30, 10, "0", 1, 1, 'C');

    $pdf->Cell(20, 10, "4", 1, 0, 'C');
    $pdf->Cell(50, 10, "TUITION FEES", 1, 0, 'C');
    $pdf->Cell(45, 10, "10000", 1, 0, 'C');
    $pdf->Cell(45, 10, "$tuition_amount", 1, 0, 'C');
    $pdf->Cell(30, 10, "0", 1, 1, 'C');

    $pdf->Cell(20, 10, "5", 1, 0, 'C');
    $pdf->Cell(50, 10, "TOTAL", 1, 0, 'C');
    $pdf->Cell(45, 10, "40000", 1, 0, 'C');
    $pdf->Cell(45, 10, $library_amount + $tuition_amount + $extra_fees_amount + $development_fees_amount, 1, 0, 'C');
    $pdf->Cell(30, 10, "0", 1, 1, 'C');

    $pdf->Ln();
    $pdf->Ln();

    // Print date
    $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 0, 'L');
    // Signature section
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, '_________________________', 0, 1, 'R');
    $pdf->Cell(0, 5, 'Signature                 ', 0, 0, 'R');
}
?>