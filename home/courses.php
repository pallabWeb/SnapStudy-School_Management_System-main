<?php
include_once '../db.php';

// Fetch all courses
$sql_courses = "SELECT id, name, category, image FROM courses";
$result_courses = $data->query($sql_courses);

$courses = [];
if ($result_courses->num_rows > 0) {
    while ($row = $result_courses->fetch_assoc()) {
        $courses[] = $row;
    }
}

$data->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sunshine | Teachers</title>

    <!-- Favicon -->
    <link rel="icon" href="../img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/navbar.css" />
</head>

<body>

    <!-- Navbar -->
    <nav>
        <div class="wrapper">
            <div class="logo"><a href="index.php"><img src="../img/Sunshine Academy White Logo (1).png" alt="" width="250"></a></div>
            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="./#home">Home</a></li>
                <li><a href="./#courses">Courses</a></li>
                <li><a href="./#booking">Book Seat</a></li>
                <li><a href="teacher.php">Teachers</a></li>
                <li><a href="./#codeForm">Apply</a></li>
                <li><a href="./#login">Login</a></li>
            </ul>
            <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
        </div>
    </nav>

    <!-- Login Form -->

    <div class="popup" id="login">
        <div class="popup__content">
            <a href="#" class="popup__close" id="popupClose"><i class="fa-solid fa-xmark"></i></a>
            <h2 class="heading-secondary text-center">Login</h2>
            <div id="error-message" class="error-message"></div>
            <div class="heading-tertiary m-3">
                <form id="login-form" method="post">
                    <input type="text" id="username" class="l-btn" name="username" placeholder="Enter your Username" required>
                    <input type="password" id="password" class="l-btn" name="password" placeholder="Enter your Password" required>
                    <div class="col-md-12 l-btn text-center">
                        <button type="submit" class="main-button submit btn-sm btn-block">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Show the popup
            $('#popup').show();

            // Handle form submission using AJAX
            $('#login-form').submit(function(event) {
                // Prevent default form submission
                event.preventDefault();

                // Get form data
                var formData = $(this).serialize();

                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: '../in.php', // Update the URL to match your file path
                    data: formData,
                    success: function(response) {
                        // Check the response from the server
                        if (response.status === 'success') {
                            // Redirect to appropriate page based on role
                            window.location.href = response.redirect;
                        } else {
                            // Display error message
                            $('#error-message').text(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Close the popup when the close button is clicked
            $('#popupClose').on('click', function() {
                $('#popup').hide();
            });
        });
    </script>

    <!-- Hero-area -->
    <div class="hero-area section">
        <!-- Backgound Image -->
        <div class="bg-image bg-parallax overlay" style="background-image:url(./img/home_background2.jpg)"></div>
        <!-- /Backgound Image -->
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                    <ul class="hero-area-tree">
                        <li><a href="index.html">Home</a></li>
                        <li>Courses</li>
                    </ul>
                    <h1 class="white-text">Explore Additional Courses</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- /Hero-area -->

    <!-- Courses -->
    <div id="courses" class="section">
        <!-- container -->
        <div class="container">
            <!-- courses -->
            <div id="courses-wrapper">
                <!-- row -->
                <div class="row">
                    <!-- single course -->
                    <?php foreach ($courses as $course) : ?>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="course">
                                <a href="#" class="course-img">
                                    <img src="../<?php echo $course['image']; ?>" style="width: 100%; height: 170px;">
                                    <i class="course-link-icon fa fa-link"></i>
                                </a>
                                <a class="course-title" href="#"><?php echo $course['name']; ?></a>
                                <div class="course-details">
                                    <span class="course-category"><?php echo $course['category']; ?></span>
                                    <span class="course-price course-free">Free</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- /courses -->
        </div>
        <!-- /container -->
    </div>
    <!-- /Courses -->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row-footer">
                <div class="footer-col">
                    <h4>company</h4>
                    <ul>
                        <li><a href="../home/#why-us">About us</a></li>
                        <li><a href="../home/#why-us">Our services</a></li>
                        <li><a href="#">Privacy policy</a></li>
                        <li><a href="#">Affiliate program</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>get help</h4>
                    <ul>
                        <li><a href="#">Events</a></li>
                        <li><a href="booking_status.php">Booking status</a></li>
                        <li><a href="#">Payment options</a></li>
                        <li><a href="../home/#contact">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="../home/">Home</a></li>
                        <li><a href="./#codeForm">Admissions</a></li>
                        <li><a href="#">Academics</a></li>
                        <li><a href="../home/#courses">Courses</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- /Footer -->

    <!-- preloader -->
    <div id='preloader'>
        <div class='preloader'></div>
    </div>
    <!-- /preloader -->

    <!-- jQuery Plugins -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script type="text/javascript" src="js/google-map.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script src="js/main.js"></script>
    <script src="js/navbar.js"></script>
</body>

</html>
