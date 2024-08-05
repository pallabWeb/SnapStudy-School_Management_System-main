<?php
session_start();

// Database connection
include_once 'db.php';

// Check if student ID is set in the URL parameter
if (isset($_GET['student_id'])) {
    // Retrieve student ID from URL parameter
    $student_id = $_GET['student_id'];

    // Fetch student information from the database
    $sql = "SELECT * FROM students WHERE id = $student_id";
    $result = $data->query($sql);

    // Check if student exists
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Fees for Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecef;
        }

        .container {
            margin-top: 50px;
        }

        .content {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .board {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: absolute;
            top: 150px;
            width: 350px;
        }

        .board.left {
            left: 25px;
        }

        .board.right {
            right: 25px;
        }

        .card {
            border: none;
        }

        .card-body {
            background: linear-gradient(135deg, #6b73ff, #000dff);
            color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            transition: transform 0.3s;
        }

        .card-body:hover {
            transform: translateY(-10px);
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Assign Fees for Student</h2>
        <div class="d-flex justify-content-between">
            <p><strong>Student Name:</strong> <?= $student['name'] ?></p>
            <p><strong>Student Class:</strong> <?= $student['class'] ?></p>
        </div>
        <?php

        // Check the payment option of the student
        if ($student['payment_option'] == 'yearly') {
            // Check if yearly fees already paid this year
            $current_year = date('Y');
            $check_yearly_payment_sql = "SELECT COUNT(*) AS payments FROM yearly_fees WHERE student_id = $student_id AND YEAR(created_at) = $current_year";
            $check_yearly_payment_result = $data->query($check_yearly_payment_sql);
            $row = $check_yearly_payment_result->fetch_assoc();
            $yearly_payments_count = $row['payments'];

            if ($yearly_payments_count == 0) {
                // Display form for yearly payment
                $total_yearly_fees = 80000; // Example amount
        ?>
                <div class="content">
                    <h3 class="text-center mb-5">Yearly Payment</h3>
                    <form action="process_yearly_payment.php" method="post">
                        <input type="hidden" name="student_id" value="<?= $student_id ?>">
                        <div class="form-group">
                            <label for="yearly_fees_amount">Total Yearly Fees Amount:</label>
                            <input type="text" class="form-control" name="yearly_fees_amount" id="yearly_fees_amount" value="<?= $total_yearly_fees ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="library_fees_amount">Library Fees Amount:</label>
                            <input type="text" class="form-control" name="library_fees_amount" id="library_fees_amount" required>
                        </div>
                        <div class="form-group">
                            <label for="tuition_fees_amount">Tuition Fees Amount:</label>
                            <input type="text" class="form-control" name="tuition_fees_amount" id="tuition_fees_amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Pay Yearly Fees</button>
                    </form>
                </div>
            <?php
            } else {
                echo "<div class='alert alert-info'>Yearly fees already paid for this year.</div>";
            }
        } elseif ($student['payment_option'] == 'after_6_months') {
            // Check if after_6_months fees already paid twice this year
            $current_year = date('Y');
            $check_after_6_months_payment_sql = "SELECT COUNT(*) AS payments FROM after_6_months_fees WHERE student_id = $student_id AND YEAR(created_at) = $current_year";
            $check_after_6_months_payment_result = $data->query($check_after_6_months_payment_sql);
            $row = $check_after_6_months_payment_result->fetch_assoc();
            $after_6_months_payments_count = $row['payments'];

            // Display form for payment after 6 months
            $total_after_6_months_fees = 80000; // Total amount
            $current_payment_amount = $total_after_6_months_fees / 2; // Amount for each payment

            if ($after_6_months_payments_count < 2) {
                // Calculate the remaining amount based on the number of payments made
                $remaining_payment = $current_payment_amount * (2 - $after_6_months_payments_count);
            ?>
                <div class="content">
                    <h3 class="text-center mb-5">Payment After 6 Months</h3>
                    <form action="process_after_6_months_payment.php" method="post">
                        <input type="hidden" name="student_id" value="<?= $student_id ?>">
                        <div class="form-group">
                            <label for="after_6_months_fees_amount">Total Fees Amount for this Payment:</label>
                            <input type="text" class="form-control" name="after_6_months_fees_amount" id="after_6_months_fees_amount" value="<?= $current_payment_amount ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="library_fees_amount">Library Fees Amount:</label>
                            <input type="text" class="form-control" name="library_fees_amount" id="library_fees_amount" required>
                        </div>
                        <div class="form-group">
                            <label for="tuition_fees_amount">Tuition Fees Amount:</label>
                            <input type="text" class="form-control" name="tuition_fees_amount" id="tuition_fees_amount" required>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Pay Fees After 6 Months</button>
                    </form>
                </div>
        <?php
            } else {
                echo "<div class='alert alert-info'>After 6 months fees already paid twice for this year.</div>";
            }
        } else {
            // Invalid payment option
            echo "<div class='alert alert-danger'>Invalid payment option for the student.</div>";
        }
        ?>

        <div class="board left">
            <h3 class="text-center mb-4">Yearly Payment</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Yearly Fees</h5>
                            <p class="card-text">Total Fees: $80,000</p>
                            <p class="card-text">Library Fees: $20,000</p>
                            <p class="card-text">Tuition Fees: $60,000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="board right">
            <h3 class="text-center mb-4">Payment After 6 Months</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total 6-Month Fees</h5>
                            <p class="card-text">Total Fees: $80,000</p>
                            <p class="card-text">Library Fees: $20,000</p>
                            <p class="card-text">Tuition Fees: $60,000</p>
                            <p class="card-text">Payment Split: $40,000 each after 6 months</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
    } else {
        // Student not found in the database
        echo "<div class='alert alert-danger'>Student not found.</div>";
    }
} else {
    // Student ID not set in the URL parameter
    echo "<div class='alert alert-danger'>Student ID not specified.</div>";
}
?>
