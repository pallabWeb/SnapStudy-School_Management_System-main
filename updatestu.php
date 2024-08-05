<?php
session_start();

if (!isset($_SESSION['fees_username'])) {
    header("location: ./home/#login");
    exit;
}

// Database connection
include_once 'db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if student ID is set
    if (isset($_POST['student_id'])) {
        // Retrieve student ID from form
        $student_id = $_POST['student_id'];

        // Redirect to a page to handle form submission
        header("Location: handle_form.php?student_id=$student_id");
        exit;
    } else {
        // Student ID not set
        // echo "Please select a student.";
    }
}
?>


<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Favicon -->
    <link rel="icon" href="./img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Make Payment | Fees</title>
    <link href="css/fees.min.css" rel="stylesheet">
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
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="filter-form d-flex">
                                <select name="class_filter" class="form-select mr-2" id="class_filter">
                                    <option value="">All Classes</option>
                                    <option value="Class1">Class 1</option>
                                    <option value="Class2">Class 2</option>
                                    <option value="Class3">Class 3</option>
                                    <option value="Class4">Class 4</option>
                                </select>
                                <button type="submit" class="btn btn-success">Apply</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">

                <table id="example" class="table">
                    <thead class="text-center">
                        <tr>
                            <th width='20%'>Student ID</th>
                            <th width='20%'>Student Username</th>
                            <th width='20%'>Payment Status</th>
                            <th width='20%'>Payment Option</th>
                            <th width='20%'>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        // Fetch student information from the database based on the class filter and payment status filter
                        $sql = "SELECT id, student_username, payment_status, payment_option FROM students WHERE 1";

                        // Exclude students with 'Paid' payment status by default
                        $sql .= " AND payment_status != 'Paid'";

                        // Check if class filter is set
                        if (isset($_POST['class_filter']) && !empty($_POST['class_filter'])) {
                            $class_filter = $_POST['class_filter'];
                            $sql .= " AND class = '$class_filter'";
                        }

                        // Check if payment status filter is set
                        if (isset($_POST['payment_status_filter']) && !empty($_POST['payment_status_filter'])) {
                            $payment_status_filter = $_POST['payment_status_filter'];
                            $sql .= " AND payment_status = '$payment_status_filter'";
                        }

                        $result = $data->query($sql);

                        // Check if there are any students in the database
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['student_username']; ?></td>
                                    <td><?php echo $row['payment_status']; ?></td>
                                    <td><?php echo $row['payment_option']; ?></td>
                                    <td>
                                        <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='post'>
                                            <input type='hidden' name='student_id' value='<?php echo $row['id']; ?>'>
                                            <button type='submit' class='btn btn-success btn-sm'>Make Payment</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            // No students found in the database
                            ?>
                            <tr>
                                <td colspan='3'>No students found.</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>


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