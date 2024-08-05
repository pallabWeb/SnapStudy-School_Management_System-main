<?php
session_start();
error_reporting(0);

// Redirect to home page if fees username is not set
if (!isset($_SESSION['fees_username'])) {
  header("location: ./home/#login");
}

if (isset($_POST['add_invoice'])) {
  $t_name = $_POST['name'];
  $t_student_username = $_POST['student_username'];
  $t_studentid = $_POST['studentid'];
  $t_feesamount = $_POST['feesamount'];
  $t_date = $_POST['date'];
  $t_strems = $_POST['strems'];
  $t_tid = $_POST['tid'];
  $t_standered = $_POST['standered'];
  $t_monyer = $_POST['monyer'];
  $t_development_fees = $_POST['development_fees'];
  $t_library_fees = $_POST['library_fees'];
  $t_extra_fees = $_POST['extra_fees'];
  $t_tuition_fees = $_POST['tuition_fees'];

  require("fpdf/fpdf.php");

  $pdf = new FPDF();
  $pdf->AddPage();
  $pdf->SetFont("Arial", "", 14);
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->Cell(0, 10, 'Fees Collection', 0, 1, 'L');
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

  $pdf->Cell(40, 10, $t_studentid, 1, 0, 'C');
  $pdf->Cell(80, 10, "$t_student_username", 1, 0, 'C');
  $pdf->Cell(40, 10, "$t_feesamount", 1, 0, 'C');
  $pdf->Cell(30, 10, "$t_date", 1, 1, 'C');

  $pdf->Cell(40, 10, "Class", 1, 0, 'C');
  $pdf->Cell(80, 10, "Mode Of Payment (Transaction ID)", 1, 0, 'C');
  $pdf->Cell(40, 10, "Standared", 1, 0, 'C');
  $pdf->Cell(30, 10, "Payment No.", 1, 1, 'C');

  $pdf->Cell(40, 10, $t_strems, 1, 0, 'C');
  $pdf->Cell(80, 10, $t_tid, 1, 0, 'C');
  $pdf->Cell(40, 10, $t_standered, 1, 0, 'C');
  $pdf->Cell(30, 10, $t_monyer, 1, 1, 'C');

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
  $pdf->Cell(45, 10, "$t_development_fees", 1, 0, 'C');
  $pdf->Cell(45, 10, "$t_development_fees", 1, 0, 'C');
  $pdf->Cell(30, 10, "0", 1, 1, 'C');

  $pdf->Cell(20, 10, "2", 1, 0, 'C');
  $pdf->Cell(50, 10, "LIBRARY FEES", 1, 0, 'C');
  $pdf->Cell(45, 10, "$t_library_fees", 1, 0, 'C');
  $pdf->Cell(45, 10, "$t_library_fees", 1, 0, 'C');
  $pdf->Cell(30, 10, "0", 1, 1, 'C');

  $pdf->Cell(20, 10, "3", 1, 0, 'C');
  $pdf->Cell(50, 10, "EXTRA FEES", 1, 0, 'C');
  $pdf->Cell(45, 10, "$t_extra_fees", 1, 0, 'C');
  $pdf->Cell(45, 10, "$t_extra_fees", 1, 0, 'C');
  $pdf->Cell(30, 10, "0", 1, 1, 'C');

  $pdf->Cell(20, 10, "4", 1, 0, 'C');
  $pdf->Cell(50, 10, "TUITION FEES", 1, 0, 'C');
  $pdf->Cell(45, 10, "$t_tuition_fees", 1, 0, 'C');
  $pdf->Cell(45, 10, "$t_tuition_fees", 1, 0, 'C');
  $pdf->Cell(30, 10, "0", 1, 1, 'C');

  $total_fees = $t_development_fees + $t_library_fees + $t_extra_fees + $t_tuition_fees;
  $pdf->Cell(20, 10, "5", 1, 0, 'C');
  $pdf->Cell(50, 10, "TOTAL FEES", 1, 0, 'C');
  $pdf->Cell(45, 10, "$total_fees", 1, 0, 'C');
  $pdf->Cell(45, 10, "$total_fees", 1, 0, 'C');
  $pdf->Cell(30, 10, "0", 1, 1, 'C');

  $pdf->Ln();
  $pdf->Ln();
  $pdf->Ln();
  $pdf->Ln();

  // Print date
  $pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 0, 'L');
  // Signature section
  $pdf->SetFont('Arial', '', 12);
  $pdf->Cell(0, 10, '_________________________', 0, 1, 'R');
  $pdf->Cell(0, 5, 'Signature                 ', 0, 0, 'R');

  // Define the folder where the PDF should be saved
  $folder_path = "uploads/";

  // Generate a unique file name
  $file_name = $t_student_username . "_invoice.pdf";

  // Combine folder path and file name
  $file_path = $folder_path . $file_name;

  // Save the PDF file to the specified path
  $pdf->Output($file_path, 'F');

  // Display the PDF directly
  header('Content-type: application/pdf');
  header('Content-Disposition: inline; filename="' . $file_name . '"');
  header('Content-Transfer-Encoding: binary');
  header('Accept-Ranges: bytes');
  @readfile($file_path);
}
?>

<?php
include_once 'db.php';

if (isset($_POST['add_invoice'])) {
  // Retrieve form data
  $t_name = $_POST['name'];
  $t_student_username = $_POST['student_username'];
  $t_studentid = $_POST['studentid'];
  $t_feesamount = $_POST['feesamount'];
  $t_date = $_POST['date'];
  $t_strems = $_POST['strems'];
  $t_tid = $_POST['tid'];
  $t_standered = $_POST['standered'];
  $t_monyer = $_POST['monyer'];
  $t_development_fees = $_POST['development_fees'];
  $t_library_fees = $_POST['library_fees'];
  $t_extra_fees = $_POST['extra_fees'];
  $t_tuition_fees = $_POST['tuition_fees'];

  // Insert form data into fees database
  $sql = "INSERT INTO fees (names, student_username, sid, feesamount, date, strems, transactionid, Standared, paynumber, development_fees, library_fees, extra_fees, tuition_fees) 
          VALUES ('$t_name', '$t_student_username', '$t_studentid', '$t_feesamount', '$t_date', '$t_strems', '$t_tid', '$t_standered', '$t_monyer', '$t_development_fees', '$t_library_fees', '$t_extra_fees', '$t_tuition_fees')";

  if ($data->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Data uploaded successfully');</script>";
  } else {
    echo "<script type='text/javascript'>alert('Error: " . $sql . "<br>" . $data->error . "');</script>";
  }

  // Close database connection
  $data->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding-top: 60px;
    }

    nav {
      position: fixed;
      top: 0;
      width: 100%;
      background-color: #333;
      color: #fff;
      padding: 10px 0;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
    }

    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      display: flex;
    }

    nav ul li {
      margin: 0 10px;
    }

    nav ul li a {
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
      display: inline-block;
    }

    nav ul li a:hover {
      background-color: #555;
    }

    .styled-form {
      max-width: 400px;
      margin: 50px auto;
      /* Center the form horizontally */
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .styled-form label {
      margin-bottom: 5px;
      display: block;
    }

    .styled-form input[type="text"],
    .styled-form input[type="date"],
    .styled-form input[type="submit"],
    .styled-form select {
      width: calc(100% - 12px);
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      box-sizing: border-box;
    }

    .styled-form input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }

    .styled-form input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav>
    <ul>
      <li><img src="img/Sunshine Academy White Logo (1).png" alt="" width="250"></li>
    </ul>

    <ul>
      <li><a href="updatestu.php">Payment</a></li>
      <li><a href="payment_option.php">Assign Payment</a></li>
      <li><a href="invoice.php">Add Invoice</a></li>
      <li><a href="showinvoice.php">Show Invoice</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>

  <form action="invoice.php" method="POST" enctype="multipart/form-data" class="styled-form">
    <label for="student_username">Select Student:</label>
    <select id="student_username" name="student_username" required>
      <?php
      // Database connection
      include_once 'db.php';

      // Check connection
      if ($data->connect_error) {
        die("Connection failed: " . $data->connect_error);
      }

      // SQL to fetch student usernames
      $sql = "SELECT student_username FROM students";

      $result = $data->query($sql);

      if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
          echo "<option value='" . $row["student_username"] . "'>" . $row["student_username"] . "</option>";
        }
      } else {
        echo "<option value=''>No students found</option>";
      }
      // Close connection
      $data->close();
      ?>
    </select>

    <label for="studentid">Enter Student ID:</label>
    <input type="text" id="studentid" name="studentid" placeholder="Student ID" required>

    <label for="feesamount">Enter Fees:</label>
    <input type="text" id="feesamount" name="feesamount" placeholder="Fees Amount" required>

    <label for="date">Date:</label>
    <input type="date" id="date" name="date" placeholder="Date" required>

    <label for="strems">Class:</label>
    <input type="text" id="strems" name="strems" placeholder="Class" required>

    <label for="tid">Mode of Payment (Transaction ID or Cash):</label>
    <input type="text" id="tid" name="tid" placeholder="Transaction ID or Cash" required>

    <label for="development_fees">Development Fees:</label>
    <input type="text" id="development_fees" name="development_fees" placeholder="Development Fees">

    <label for="library_fees">Library Fees:</label>
    <input type="text" id="library_fees" name="library_fees" placeholder="Library Fees">

    <label for="extra_fees">Extra Fees:</label>
    <input type="text" id="extra_fees" name="extra_fees" placeholder="Extra Fees">

    <label for="tuition_fees">Tuition Fees:</label>
    <input type="text" id="tuition_fees" name="tuition_fees" placeholder="Tuition Fees">


    <label for="standered">Enter Standard:</label>
    <input type="text" id="standered" name="standered" placeholder="Standard" required>
    <?php
    $payment_number = mt_rand(100000, 999999);
    ?>
    <label for="monyer">Enter Payment Number:</label>
    <input type="text" id="monyer" name="monyer" placeholder="Payment Number" value="<?php echo $payment_number; ?>" required><br>

    <input type="submit" name="add_invoice" value="Generate PDF">
  </form>
</body>

</html>