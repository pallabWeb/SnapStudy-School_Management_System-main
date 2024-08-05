<?php
// Function to generate PDF invoice
// function generateInvoice($student_username, $payment_system, $fees_structure)
// {
//     require("fpdf/fpdf.php");

//     $pdf = new FPDF();
//     $pdf->AddPage();
//     $pdf->SetFont("Arial", "", 14);
//     $pdf->SetFont('Arial', 'B', 10);
//     $pdf->Cell(0, 10, 'Fees Collection', 0, 0, 'L');
//     $pdf->Cell(0, 10, "Payment System: $payment_system", 0, 1, 'R');
//     $pdf->Ln();
//     $pdf->SetFont('Arial', 'B', 19);
//     $pdf->Cell(0, 10, 'SUNSHINE ACADEMY', 0, 1, 'C');
//     $pdf->SetFont('Arial', '', 12);
//     $pdf->Cell(0, 10, 'Main Office:- P.O.-Madhyamgram,Bus Stop:New Barrakpur,Kolkata-700129', 0, 1, 'C');
//     $pdf->Cell(0, 10, 'School Campus:- P.O.-Barasat,Kolkata-700129', 0, 1, 'C');
//     $pdf->Cell(0, 10, 'Phone:- 7896584578 ,+91 8569874859', 0, 1, 'C');

//     // Student Details section
//     $pdf->Ln();
//     $pdf->Ln();
//     $pdf->Cell(0, 10, "Student Details", 1, 1, 'C');
//     // Add student details to the PDF
//     $pdf->Cell(40, 10, "Student ID", 1, 0, 'C');
//     $pdf->Cell(80, 10, "Student Name", 1, 0, 'C');
//     $pdf->Cell(40, 10, "Fees Amount", 1, 0, 'C');
//     $pdf->Cell(30, 10, "Date", 1, 1, 'C');
//     $pdf->Cell(40, 10, "", 1, 0, 'C');
//     $pdf->Cell(80, 10, "$student_username", 1, 0, 'C');
//     $pdf->Cell(40, 10, "6757", 1, 0, 'C');
//     $pdf->Cell(30, 10, "4564", 1, 1, 'C');
//     $pdf->Cell(40, 10, "Class", 1, 0, 'C');
//     $pdf->Cell(80, 10, "Mode Of Payment (Transaction ID)", 1, 0, 'C');
//     $pdf->Cell(40, 10, "Standard", 1, 0, 'C');
//     $pdf->Cell(30, 10, "Payment No.", 1, 1, 'C');
//     $pdf->Cell(40, 10, "46456", 1, 0, 'C');
//     $pdf->Cell(80, 10, "644", 1, 0, 'C');
//     $pdf->Cell(40, 10, "64564", 1, 0, 'C');
//     $pdf->Cell(30, 10, "6456", 1, 1, 'C');

//     // Payment Details section
//     $pdf->Ln();
//     $pdf->Cell(0, 10, "Payment Details", 1, 1, 'C');
//     // Add payment details to the PDF based on the payment system
//     if ($payment_system == "monthly") {
//         // Monthly payment system
//         $pdf->Cell(20, 10, "Sl NO.", 1, 0, 'C');
//         // Add your monthly payment details here
//     } elseif ($payment_system == "after_6_months") {
//         // Payment after 6 months system
//         $pdf->Cell(20, 10, "Sl NO.", 1, 0, 'C');
//         // Add your payment after 6 months details here
//     }

//     // Print date
//     $pdf->Ln();
//     $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 0, 'L');
//     // Signature section
//     $pdf->SetFont('Arial', '', 12);
//     $pdf->Cell(0, 10, '_________________________', 0, 1, 'R');
//     $pdf->Cell(0, 5, 'Signature                 ', 0, 0, 'R');

//     // Define the folder where the PDF should be saved
//     $folder_path = "uploads/";

//     // Generate a unique file name based on payment system
//     $file_name = $student_username . "_" . strtolower(str_replace(" ", "_", $payment_system)) . "_invoice.pdf";

//     // Combine folder path and file name
//     $file_path = $folder_path . $file_name;

//     // Save the PDF file to the specified path
//     $pdf->Output($file_path, 'F');

//     // Display the PDF directly
//     header('Content-type: application/pdf');
//     header('Content-Disposition: inline; filename="' . $file_name . '"');
//     header('Content-Transfer-Encoding: binary');
//     header('Accept-Ranges: bytes');
//     @readfile($file_path);
// }

// // Check if form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Retrieve selected student and payment system
//     $student_username = $_POST["student_username"];
//     $payment_system = $_POST["payment_system"];

//     // Database connection
//     include_once 'db.php';

//     // Check connection
//     if ($data->connect_error) {
//         die("Connection failed: " . $data->connect_error);
//     }

//     // Retrieve fees structure based on the selected payment system
//     $fees_structure = "";

//     if ($payment_system == "monthly") {
//         // Fetch monthly fees structure from database
//         $sql = "SELECT monthly_fees FROM students WHERE student_username = '$student_username'";
//     } elseif ($payment_system == "after_6_months") {
//         // Fetch fees structure for payments after 6 months from database
//         $sql = "SELECT after_6_months_fees FROM students WHERE student_username = '$student_username'";
//     }

//     $result = $data->query($sql);

//     if ($result->num_rows > 0) {
//         // Fetch the fees structure from the result
//         $row = $result->fetch_assoc();
//         $fees_structure = $row["monthly_fees"]; // Assuming the column name is 'monthly_fees'

//         // Call the function to generate PDF invoice
//         generateInvoice($student_username, $payment_system, $fees_structure);
//     } else {
//         echo "No fees structure found for $student_username (Payment System: $payment_system)";
//     }

//     // Close connection
//     $data->close();
// } else {
//     // Redirect back to the form if accessed directly
//     header("Location: fees_management_form.html");
//     exit();
// }
?>
