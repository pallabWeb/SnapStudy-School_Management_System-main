<?php
session_start();
if (!isset($_SESSION['teacher_username'])) {
    header("location:teacher_login.php");
    exit();
}

include_once 'db.php';  // Database Connection

// Fetch teacher's image path from the database
$teacher_username = $_SESSION['teacher_username'];
$sql = "SELECT image FROM teacher WHERE teacher_username = '$teacher_username'";
$result = mysqli_query($data, $sql);
$row = mysqli_fetch_assoc($result);
$teacher_image = $row['image'];

// Check if a student is selected
if (isset($_POST['student_username'])) {
    $student_selected = $_POST['student_username'];
    $_SESSION['selected_student'] = $student_selected;
} elseif (isset($_SESSION['selected_student'])) {
    $student_selected = $_SESSION['selected_student'];
} else {
    $student_selected = null;
}

// Check if form is submitted to add marks
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bengali_marks'])) {
    // Validate input data
    if (isset($_SESSION['selected_student'])) {
        $student_username = $_SESSION['selected_student'];

        // Check connection
        if ($data->connect_error) {
            die("Connection failed: " . $data->connect_error);
        }

        // Check if marks for this student already exist
        $check_sql = "SELECT * FROM marks WHERE student_username = '$student_username'";
        $check_result = $data->query($check_sql);

        if ($check_result->num_rows > 0) {
            // Marks for this student already exist, prevent duplicate submission
            echo "<script>alert('Marks for this student already exist.')</script>";
            exit();
        }

        // Check if the student exists in the students table
        $student_check_sql = "SELECT * FROM students WHERE student_username = '$student_username'";
        $student_check_result = $data->query($student_check_sql);
        if ($student_check_result->num_rows == 0) {
            // Student does not exist, cannot insert marks
            echo "<script>alert('Selected student does not exist.')</script>";
            exit();
        }

        // Proceed to insert marks if not already submitted
        $bengali_marks = $_POST["bengali_marks"];
        $english_marks = $_POST["english_marks"];
        $mathematics_marks = $_POST["mathematics_marks"];
        $life_science_marks = $_POST["life_science_marks"];
        $physical_science_marks = $_POST["physical_science_marks"];
        $history_marks = $_POST["history_marks"];
        $geography_marks = $_POST["geography_marks"];
        $extracurricular_marks = $_POST["extracurricular_marks"];

        // Prepare SQL statement to insert marks into database
        $sql = "INSERT INTO marks (student_username, bengali_marks, english_marks, mathematics_marks, 
                life_science_marks, physical_science_marks, history_marks, geography_marks, 
                extracurricular_marks) VALUES ('$student_username', '$bengali_marks', '$english_marks', 
                '$mathematics_marks', '$life_science_marks', '$physical_science_marks', '$history_marks', 
                '$geography_marks', '$extracurricular_marks')";

        if ($data->query($sql) === TRUE) {
            echo "<script>alert('Marks added successfully!')</script>";
            unset($_SESSION['selected_student']);  // Clear selected student after submission
            header("Location: add_marks.php");  // Redirect to the same page
            exit();  // Ensure no further code is executed
        } else {
            echo "Error: " . $sql . "<br>" . $data->error;
        }


        // Close connection
        $data->close();
        exit(); // Exit after processing the form data
    } else {
        echo "<script>alert('No student selected.')</script>";
    }
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" href="./img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
    <title>Teacher | Add Marks</title>
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="assets/datatables/css/style.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />
    <!-- Custom CSS -->
    <link href="css/teacher.min.css" rel="stylesheet">
</head>

<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


        <?php include 'components/t_topbar.php'; ?> <!-- End Topbar header -->


        <?php include 'components/t_sidebar.php'; ?> <!-- End Left Sidebar -->

        <!-- Page wrapper  -->
        <div class="page-wrapper">

            <!-- Bread crumb and right sidebar toggle -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="student.php">Dashboard</a></li>
                                    <li class="breadcrumb-item">Add Marks</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div> <!-- End Bread crumb and right sidebar toggle -->

            <div class="container-fluid">
                <div class="container">
                    <?php if ($student_selected) : ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <h2 class="text-center">Assign Marks for <strong class="text-success"><?php echo htmlspecialchars($student_selected); ?></strong></h2>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="bengali_marks">Bengali Marks:</label>
                                    <input type="number" class="form-control" id="bengali_marks" name="bengali_marks" min="0" max="100" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="english_marks">English Marks:</label>
                                    <input type="number" class="form-control" id="english_marks" name="english_marks" min="0" max="100" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="mathematics_marks">Mathematics Marks:</label>
                                    <input type="number" class="form-control" id="mathematics_marks" name="mathematics_marks" min="0" max="100" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="life_science_marks">Life Science Marks:</label>
                                    <input type="number" class="form-control" id="life_science_marks" name="life_science_marks" min="0" max="100" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="physical_science_marks">Physical Science Marks:</label>
                                    <input type="number" class="form-control" id="physical_science_marks" name="physical_science_marks" min="0" max="100" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="history_marks">History Marks:</label>
                                    <input type="number" class="form-control" id="history_marks" name="history_marks" min="0" max="100" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="geography_marks">Geography Marks:</label>
                                    <input type="number" class="form-control" id="geography_marks" name="geography_marks" min="0" max="100" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="extracurricular_marks">Extracurricular Activities Marks:</label>
                                    <input type="number" class="form-control" id="extracurricular_marks" name="extracurricular_marks" min="0" max="100" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-success mt-4" value="Add Marks">
                                    <button type="button" class="btn btn-danger mt-4" onclick="cancelAddingMarks()">Cancel</button>
                                </div>
                            </div>
                        </form>

                        <script>
                            function cancelAddingMarks() {
                                window.location.href = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?cancel=true";
                            }
                        </script>
                    <?php else : ?>
                        <table id="example" class="table w-100">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="30%">Username</th>
                                    <th width="40%">Name</th>
                                    <th width="20%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-info">
                                <?php
                                // Database connection
                                include_once 'db.php';

                                // Check connection
                                if ($data->connect_error) {
                                    die("Connection failed: " . $data->connect_error);
                                }

                                // SQL to fetch student usernames who do not have marks
                                $sql = "SELECT student_username , name FROM students 
                                        WHERE student_username NOT IN (SELECT student_username FROM marks)";

                                $result = $data->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["student_username"] . "</td>";
                                        echo "<td>" . $row["name"] . "</td>";
                                        echo "<td class='text-center'><form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'><input type='hidden' name='student_username' value='" . $row["student_username"] . "'><input type='submit' class='btn btn-success btn-sm' value='Add Marks'></form></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='2'>No students found</td></tr>";
                                }
                                // Close connection
                                $data->close();
                                ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div> <!-- End Container fluid  -->
    </div> <!-- End Page wrapper  -->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- apps -->
    <script src="js/app-style-switcher.js"></script>
    <script src="js/feather.min.js"></script>
    <script src="js/perfect-scrollbar.jquery.min.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

    <!-- Data Table JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Datatables Custom JS -->
    <script src="assets/datatables/js/script.js"></script>
</body>

</html>