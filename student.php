<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['student_username'])) {
    // Establish a connection to the database
    include_once 'db.php';

    // Check the connection
    if ($data === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    // Retrieve user details from the database
    $student_username = $_SESSION['student_username'];
    $query = "SELECT * FROM students WHERE student_username = '$student_username'";
    $result = mysqli_query($data, $query);

    // Check if query executed successfully
    if ($result) {
        // Fetch user details
        $user_details = mysqli_fetch_assoc($result);
    } else {
        $error_message = "Error: Unable to fetch user details.";
    }

    // Retrieve total number of teachers from the database
    $query_total_teachers = "SELECT COUNT(*) AS total_teachers FROM teacher";
    $result_total_teachers = mysqli_query($data, $query_total_teachers);
    $row_total_teachers = mysqli_fetch_assoc($result_total_teachers);
    $total_teachers = $row_total_teachers['total_teachers'];

    // Retrieve total number of courses from the database
    $query_total_courses = "SELECT COUNT(*) AS total_courses FROM courses";
    $result_total_courses = mysqli_query($data, $query_total_courses);
    $row_total_courses = mysqli_fetch_assoc($result_total_courses);
    $total_courses = $row_total_courses['total_courses'];

    // Close the connection
    mysqli_close($data);
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: loginstu.php");
    exit();
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
    <title>Student | Dashboard </title>
    <!-- Custom CSS -->
    <link href="css/student.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/timeTable.css">
    <style>
        main .timetable {
            margin-top: 2rem;
        }

        main .timetable h2 {
            margin-bottom: 0.8rem;
        }

        main .timetable table {
            background-color: var(--color-white);
            width: 100%;
            border-radius: var(--card-border-radius);
            padding: var(--card-padding);
            text-align: center;
            box-shadow: var(--box-shadow);
            transition: all 300ms ease;
        }

        main .timetable span {
            display: none;
        }

        main .timetable table:hover {
            box-shadow: none;
        }

        main table tbody td {
            height: 2.8rem;
            border-bottom: 1px solid var(--color-light);
            color: var(--color-dark-varient);
        }

        main table tbody tr:last-child td {
            border: none;
        }

        main .timetable.active {
            width: 100%;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        main .timetable.active h2 {
            color: var(--color-dark);
        }

        main .timetable.active table {
            width: 90%;
            max-width: 1000px;
            position: relative;
        }

        main .timetable.active span {
            display: block;
            font-size: 2rem;
            color: var(--color-dark);
            cursor: pointer;
        }

        .timetable div {
            position: relative;
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        main .timetable.active .closeBtn {
            position: absolute;
            top: 5%;
            right: 5%;
        }


        /* MEDIA QUERIES  */
        @media screen and (max-width: 1200px) {
            main .timetable {
                width: 150%;
                position: absolute;
                padding: 4rem 0 0 0;
            }
        }

        @media screen and (max-width: 768px) {
            main .timetable {
                position: relative;
                margin: 3rem 0 0 0;
                width: 100%;
            }

            main .timetable table {
                width: 100%;
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">


        <?php include 'components/user_topbar.php'; ?> <!-- End Topbar header -->


        <?php include 'components/user_sidebar.php'; ?> <!-- End Left Sidebar -->


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
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

            </div> <!-- End Bread crumb and right sidebar toggle -->


            <!-- Container fluid  -->
            <div class="container-fluid">


                <?php
                // Display error message if exists
                if (isset($error_message)) {
                ?>
                    <div class='alert alert-danger' role='alert'><?php echo $error_message; ?></div>
                <?php
                }

                // Display student details if they exist
                if (isset($user_details)) {
                ?>
                    <div id="Alert" class='alert alert-success fade show' role='alert'>Welcome, <?php echo $user_details['name']; ?>!</div>
                <?php
                }
                ?>

                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-end ">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><?php echo $total_teachers; ?></h2>
                                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Teachers
                                        </h6>
                                    </div>
                                    <div class="ms-auto mt-md-3 mt-lg-0">
                                        <span class="opacity-7 text-muted"><i data-feather="briefcase"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-end ">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="d-inline-flex align-items-center">
                                            <h2 class="text-dark mb-1 font-weight-medium"><?php echo $total_courses; ?></h2>
                                        </div>
                                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Courses
                                        </h6>
                                    </div>
                                    <div class="ms-auto mt-md-3 mt-lg-0">
                                        <span class="opacity-7 text-muted"><i data-feather="book"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card border-end ">
                            <div class="card-body" onclick="window.open('view_result.php', '_blank');" style="cursor: pointer;">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="d-inline-flex align-items-center">
                                            <h2 class="text-dark mb-1 font-weight-medium">→</h2>
                                        </div>
                                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">View Result
                                        </h6>
                                    </div>
                                    <div class="ms-auto mt-md-3 mt-lg-0">
                                        <span class="opacity-7 text-muted"><i data-feather="file-text"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- End Container fluid  -->
        </div> <!-- End Page wrapper  -->
    </div> <!-- End Wrapper -->

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

</body>

</html>