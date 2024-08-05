<?php
session_start();

if (!isset($_SESSION['fees_username'])) {
    header("location: ./home/#login");
    exit; 
}

// Include database connection
include_once 'db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if payment option is selected
    if (isset($_POST['payment_option'])) {
        $payment_option = mysqli_real_escape_string($data, $_POST['payment_option']);

        // Check if any student is selected
        if (isset($_POST['selected_students'])) {
            $selected_students = $_POST['selected_students'];

            // Loop through selected students and update their payment option
            foreach ($selected_students as $student_id) {
                $student_id = mysqli_real_escape_string($data, $student_id);
                $sql = "UPDATE students SET payment_option = '$payment_option' WHERE id = '$student_id'";

                if ($data->query($sql) !== TRUE) {
                    // Error message
                    echo "<script>alert('Error updating payment system for student ID: $student_id');</script>";
                }
            }

            // Success message
            echo "<script>alert('Payment system assigned successfully for selected students');</script>";
            // Redirect to another page
            echo "<script>window.location.href = 'payment_option.php';</script>";
            exit; // Terminate script execution
        } else {
            echo "<script>alert('No students selected.');</script>";
        }
    } else {
        echo "<script>alert('Please select a payment option.');</script>";
    }
}

// Fetch student information from the database where payment_option is blank
$sql = "SELECT id, student_username FROM students WHERE payment_option = ''";
$result = $data->query($sql);
?>




<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Favicon -->
    <link rel="icon" href="./img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assign Payment | Fees</title>
    <link href="css/fees.min.css" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        <?php include_once 'components/f_topbar.php'; ?>

        <?php include_once 'components/f_sidebar.php'; ?>

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item">Make Payment</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Display current date -->
                    <div class="col-5 align-self-center">
                        <div class="d-flex justify-content-end">

                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="payment_option">Select Payment Option:</label>
                    <select name="payment_option" class="form-select" id="payment_option">
                        <option value="">Select Payment Option</option>
                        <option value="yearly">Yearly</option>
                        <option value="after_6_months">After 6 Months</option>
                    </select>
                    <br>
                    <table>
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Student Username</th>
                                <th>Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td width='20%'>" . $row['id'] . "</td>";
                                    echo "<td width='70%'>" . $row['student_username'] . "</td>";
                                    echo "<td width='10%'><input type='checkbox' name='selected_students[]' value='" . $row['id'] . "'></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No students found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary w-25">Assign</button>
                    </div>
                </form>

            </div>

            <!-- JavaScript files -->
            <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap.bundle.min.js"></script>
            <script src="js/app-style-switcher.js"></script>
            <script src="js/feather.min.js"></script>
            <script src="js/perfect-scrollbar.jquery.min.js"></script>
            <script src="js/sidebarmenu.js"></script>
            <script src="js/custom.min.js"></script>

        </div>
    </div>

</body>

</html>