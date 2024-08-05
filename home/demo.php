<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "snapstudy";

try {
    $data = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $data->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Fetch courses
$coursesQuery = $data->prepare("SELECT * FROM courses");
$coursesQuery->execute();
$courses = $coursesQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Sunshine | Home</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css" />
    <style>
        /* Updates Marquee */

        .wire-ticker-wrapper {
            display: none;
            /* Initially hide the marquee */
        }

        .wire-ticker-wrapper {
            /* background-color: #f6f6f6; */
            height: 36px;
            overflow: hidden;
            /* position: fixed; Remove this line */
            /* bottom: 0; Remove this line */
            /* left: 0; Remove this line */
            background-color: #e8f48c;
            width: 100%;
            z-index: 9999;
            position: fixed;
            top: calc(14% - 32px);
        }


        .wire-ticker-wrapper .wire-ticker {
            margin: 0 auto;
            max-width: 1530px;
            display: flex;
            align-items: center;
            height: 36px;
        }

        .wire-ticker-wrapper .wire-ticker .wire-ticker-red-trending {
            display: flex;
            align-items: center;
            border-left: 1px solid #e5decb;
            border-right: 1px solid #e5decb;
            padding: 0 16px 0 8px;
            height: 100%;
            gap: 3px;
        }

        .wire-ticker-wrapper .wire-ticker .wire-ticker-red-trending .wire-ticker-red-ellipse {
            background-color: #525ceb;
            border-radius: 5px;
            height: 10px;
            width: 10px;
            box-shadow: 0 0 5px 0 #0011ff;
            margin-right: 5px;
        }

        .wire-ticker-wrapper .wire-ticker .wire-ticker-red-trending .wire-ticker-trending {
            color: #525ceb;
            font-family: Source Sans\ 3, sans-serif;
            font-size: 16px;
            font-weight: 700;
        }

        .wire-ticker-wrapper .wire-ticker .marquee {
            position: relative;
            display: flex;
            overflow: hidden;
            user-select: none;
            width: 100%;
        }

        .wire-ticker-wrapper .wire-ticker .marquee__content {
            flex-shrink: 0;
            display: flex;
            justify-content: space-around;
            width: max-content;
            animation: scroll 20s linear infinite;
        }

        ul:not(.browser-default) {
            padding-left: 0;
            list-style-type: none;
        }

        .wire-ticker-wrapper .wire-ticker .marquee__content a {
            color: #1c1d1a;
            text-decoration: none;
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
            margin-right: 20px;
            padding-right: 15px;
            display: inline-block;
            white-space: nowrap;
            border-right: 2px solid #525ceb;
        }

        .wire-ticker-wrapper .wire-ticker .marquee__content a:hover {
            color: #525ceb;
        }

        .wire-ticker-wrapper .wire-ticker .marquee__content a:last-child {
            border-right: none;
        }


        .wire-ticker-wrapper .wire-ticker .marquee:hover .marquee__content {
            animation-play-state: paused;
        }

        @keyframes scroll {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* Navbar style */
        nav {
            position: fixed;
            z-index: 99;
            width: 100%;
            background-color: transparent;
            transition: background-color 0.3s ease;
        }

        nav .wrapper {
            position: relative;
            max-width: 1300px;
            padding: 0px 30px;
            height: 70px;
            line-height: 70px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .wrapper .logo a {
            color: #fff;
            font-size: 30px;
            font-weight: 600;
            text-decoration: none;
        }

        .wrapper .nav-links {
            display: inline-flex;
        }

        .nav-links li {
            list-style: none;
        }

        .nav-links li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            padding: 9px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-links li a:hover {
            color: #525ceb;
        }

        .nav-links .mobile-item {
            display: none;
        }

        .nav-links .drop-menu {
            position: absolute;
            background: #18181d;
            width: 180px;
            line-height: 45px;
            top: 85px;
            opacity: 0;
            visibility: hidden;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .nav-links li:hover .drop-menu,
        .nav-links li:hover .mega-box {
            transition: all 0.3s ease;
            top: 70px;
            opacity: 1;
            visibility: visible;
        }

        .drop-menu li a {
            width: 100%;
            display: block;
            padding: 0 0 0 15px;
            font-weight: 400;
            border-radius: 0px;
        }

        .mega-box {
            position: absolute;
            left: 0;
            width: 100%;
            padding: 0 30px;
            top: 85px;
            opacity: 0;
            visibility: hidden;
        }

        .mega-box .content {
            background: #242526;
            padding: 25px 20px;
            display: flex;
            width: 100%;
            justify-content: space-between;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .mega-box .content .row {
            width: calc(25% - 30px);
            line-height: 45px;
        }

        .content .row img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .content .row header {
            color: #f2f2f2;
            font-size: 20px;
            font-weight: 500;
        }

        .content .row .mega-links {
            margin-left: -40px;
            border-left: 1px solid rgba(255, 255, 255, 0.09);
        }

        .row .mega-links li {
            padding: 0 20px;
        }

        .row .mega-links li a {
            padding: 0px;
            padding: 0 20px;
            color: #d9d9d9;
            font-size: 17px;
            display: block;
        }

        .row .mega-links li a:hover {
            color: #525ceb;
        }

        .wrapper .btn {
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            display: none;
        }

        .wrapper .btn.close-btn {
            position: absolute;
            right: 30px;
            top: 10px;
        }

        @media screen and (max-width: 970px) {
            .wrapper .btn {
                display: block;
            }

            .wrapper .nav-links {
                position: fixed;
                height: 100vh;
                width: 100%;
                max-width: 350px;
                top: 0;
                left: -100%;
                background: #18181d;
                display: block;
                padding: 50px 10px;
                line-height: 50px;
                overflow-y: auto;
                box-shadow: 0px 15px 15px rgba(0, 0, 0, 0.18);
                transition: all 0.3s ease;
            }

            #menu-btn:checked~.nav-links {
                left: 0%;
            }

            #menu-btn:checked~.btn.menu-btn {
                display: none;
            }

            #close-btn:checked~.btn.menu-btn {
                display: block;
            }

            .nav-links li {
                margin: 15px 10px;
            }

            .nav-links li a {
                padding: 0 20px;
                display: block;
                font-size: 20px;
            }

            .nav-links .drop-menu {
                position: static;
                opacity: 1;
                top: 65px;
                visibility: visible;
                padding-left: 20px;
                width: 100%;
                max-height: 0px;
                overflow: hidden;
                box-shadow: none;
                transition: all 0.3s ease;
            }

            #showDrop:checked~.drop-menu,
            #showMega:checked~.mega-box {
                max-height: 100%;
            }

            .nav-links .desktop-item {
                display: none;
            }

            .nav-links .mobile-item {
                display: block;
                color: #fff;
                font-size: 20px;
                font-weight: 600;
                padding-left: 20px;
                cursor: pointer;
                border-radius: 5px;
                transition: all 0.3s ease;
            }

            .nav-links .mobile-item:hover {
                color: #fff;
            }

            .drop-menu li {
                margin: 0;
            }

            .drop-menu li a {
                border-radius: 5px;
                font-size: 18px;
            }

            .mega-box {
                position: static;
                top: 65px;
                opacity: 1;
                visibility: visible;
                padding: 0 20px;
                max-height: 0px;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .mega-box .content {
                box-shadow: none;
                flex-direction: column;
                padding: 20px 20px 0 20px;
            }

            .mega-box .content .row {
                width: 100%;
                margin-bottom: 15px;
                border-top: 1px solid rgba(255, 255, 255, 0.08);
            }

            .mega-box .content .row:nth-child(1),
            .mega-box .content .row:nth-child(2) {
                border-top: 0px;
            }

            .content .row .mega-links {
                border-left: 0px;
                padding-left: 15px;
            }

            .row .mega-links li {
                margin: 0;
            }

            .content .row header {
                font-size: 19px;
            }
        }

        nav input {
            display: none;
        }

        .body-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            text-align: center;
            padding: 0 30px;
        }

        .body-text div {
            font-size: 45px;
            font-weight: 600;
        }

        /* CSS SignUp form Modal */

        .popup {
            height: 100vh;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
        }

        .popup:target {
            opacity: 1;
            visibility: visible;
        }

        .popup__content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70%;
            max-width: 400px;
            padding: 50px;
            background-color: white;
            box-shadow: 0 2rem 4rem rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
        }

        .l-btn {
            margin-top: 30px;
        }

        .mtt-3 {
            margin-top: 8px;
        }

        .popup__close {
            position: absolute;
            top: 3rem;
            right: 3rem;
            font-size: 2rem;
            color: red;
            line-height: 1;
            cursor: pointer;
            display: inline-block;
        }

        /* Media query for responsiveness */
        @media screen and (max-width: 768px) {
            .popup__content {
                width: 90%;
                max-width: 90%;
            }

            .heading-secondary {
                font-size: 2rem;
                margin-bottom: 2rem;
            }
        }

        select {
            height: 40px;
            width: 100%;
            border: 1px solid #ebebeb;
            border-radius: 4px;
            background: transparent;
            padding-left: 15px;
            padding-right: 15px;
            -webkit-transition: 0.2s border-color;
            transition: 0.2s border-color;
        }

        .close-marquee-btn {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #e8f48c;
            border: none;
            color: #525ceb;
            font-size: 16px;
            cursor: pointer;
            outline: none;
            padding: 7px 10px;
            z-index: 999;
        }
    </style>
</head>

<body>

    <!-- Marquee -->
    <div class="wire-ticker-wrapper" id="marqueeWrapper">
        <button class="close-marquee-btn" onclick="closeMarquee()"><i class="fas fa-times"></i></button>
        <div class="wire-ticker">
            <div class="wire-ticker-red-trending">
                <div class="wire-ticker-red-ellipse"></div>
                <div class="wire-ticker-trending">Updates</div>
            </div>
            <div class="marquee">
                <ul aria-hidden="true" class="marquee__content">
                    <?php
                    // Connect to your database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "snapstudy";

                    $data = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($data->connect_error) {
                        die("Connection failed: " . $data->connect_error);
                    }

                    // Query to fetch data from your database table
                    $sql = "SELECT * FROM tblupdates";
                    $result = $data->query($sql);

                    // Check if there are any rows returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<a><li>" . $row["descript"] . "</li></a>";
                        }
                    } else {
                        echo "0 results";
                    }

                    // Close database connection
                    $data->close();
                    ?>
                </ul>
            </div>
        </div>

    </div>

    <!-- Navbar -->
    <nav>
        <div class="wrapper">
            <div class="logo"><a href="index.php"><img src="../img/Sunshine Academy White Logo (1).png" alt="" width="250"></a></div>
            <input type="radio" name="slider" id="menu-btn">
            <input type="radio" name="slider" id="close-btn">
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#popup">Login</a></li>
                <!-- <li>
                    <a href="#" class="desktop-item">Login</a>
                    <input type="checkbox" id="showDrop">
                    <label for="showDrop" class="mobile-item">Login</label>
                    <ul class="drop-menu">
                        <li><a href="../login.php">Admin</a></li>
                        <li><a href="../loginstu.php">Student</a></li>
                        <li><a href="../teacher_login.php">Teacher</a></li>
                    </ul>
                </li> -->
            </ul>

            <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
        </div>
    </nav>





    <!-- Home -->
    <div id="home" class="hero-area">

        <!-- Backgound Image -->
        <div class="bg-image bg-parallax overlay mbg" style="background-image:url(./img/home-background.jpg)"></div>
        <!-- /Backgound Image -->

        <div class="home-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="white-text">Edusite Free Online Training Courses</h1>
                        <p class="lead white-text">Libris vivendo eloquentiam ex ius, nec id splendide abhorreant, eu pro alii error homero.</p>
                        <a class="main-button icon-button" href="#">Get Started!</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Home -->

    <!-- <div class="popup" id="popup">
        <div class="popup__content">
            <a href="#" class="popup__close"><i class="fa-solid fa-xmark"></i></a>
            <h2 class="heading-secondary">Student Registration</h2>
            <div class="heading-tertiary m-3">
                <form class="row g-3 mt-5" id="addStudentForm">
                    <div class="col-md-6">
                        <label for="username" class="mtt-3">Username</label>
                        <input type="text" class="form-control" name="student_username" id="username" placeholder="Enter your username" required>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="mtt-3">Student's name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter student's name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="class" class="mtt-3">Select Class</label>
                        <select class="form-control ss" id="class" name="class" required>
                            <option value="">Select Class</option>
                            <option value="class1">Class 1</option>
                            <option value="class2">Class 2</option>
                            <option value="class3">Class 3</option>
                            <option value="class4">Class 4</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="mtt-3">Phone</label>
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter your phone number" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="mtt-3">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="mtt-3">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="col-md-6 l-btn">
                        <p>Already have an account? <a href="../loginstu.php">Login</a></p>
                    </div>
                    <div class="col-md-6 l-btn">
                        <button type="submit" class="main-button pull-right submit btn-sm" name="add_student">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->

    <div class="popup" id="popup">
        <div class="popup__content">
            <a href="#" class="popup__close"><i class="fa-solid fa-xmark"></i></a>
            <h2 class="heading-secondary text-center">Login</h2>
            <!-- Error message container -->
            <div id="error-message" class="error-message"></div>
            <div class="heading-tertiary m-3">
                <form id="login-form" method="post" action="../in.php">
                    <select id="role" name="role" class="l-btn" required>
                        <option value="admin">Admin</option>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
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
            // Handle form submission using AJAX
            $('#login-form').submit(function(event) {
                // Prevent default form submission
                event.preventDefault();

                // Get form data
                var formData = $(this).serialize();

                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: '../in.php', // Update the URL to your PHP script
                    data: formData,
                    success: function(response) {
                        // Check the response from the server
                        if (response.trim() === 'success') {
                            // Redirect to appropriate page based on role
                            window.location.href = response.redirect;
                        } else {
                            // Display error message
                            $('#error-message').html('<p>' + response + '</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>


    <!-- About -->
    <div id="about" class="section">

        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">

                <div class="col-md-6">
                    <div class="section-header">
                        <h2>Welcome to Edusite</h2>
                        <p class="lead">Libris vivendo eloquentiam ex ius, nec id splendide abhorreant.</p>
                    </div>

                    <!-- feature -->
                    <div class="feature">
                        <i class="feature-icon fa fa-flask"></i>
                        <div class="feature-content">
                            <h4>Online Courses </h4>
                            <p>Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>
                        </div>
                    </div>
                    <!-- /feature -->

                    <!-- feature -->
                    <div class="feature">
                        <i class="feature-icon fa fa-users"></i>
                        <div class="feature-content">
                            <h4>Expert Teachers</h4>
                            <p>Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>
                        </div>
                    </div>
                    <!-- /feature -->

                    <!-- feature -->
                    <div class="feature">
                        <i class="feature-icon fa fa-comments"></i>
                        <div class="feature-content">
                            <h4>Community</h4>
                            <p>Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>
                        </div>
                    </div>
                    <!-- /feature -->

                </div>

                <div class="col-md-6">
                    <div class="about-img">
                        <img src="./img/about.png" alt="">
                    </div>
                </div>

            </div>
            <!-- row -->

        </div>
        <!-- container -->
    </div>
    <!-- /About -->

    <!-- Courses -->
    <div id="courses" class="section">

        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">
                <div class="section-header text-center">
                    <h2>Explore Additional Courses</h2>
                    <p class="lead">Here are some courses that we offer for you Free of charges.</p>
                </div>
            </div>
            <!-- /row -->

            <!-- courses -->
            <div id="courses-wrapper">

                <!-- row -->
                <div class="row">

                    <!-- single course -->
                    <?php foreach ($courses as $course) : ?>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <div class="course">
                                <a href="#" class="course-img">
                                    <img src="<?php echo $course['image']; ?>">
                                    <i class="course-link-icon fa fa-link"></i>
                                </a>
                                <a class="course-title" href="#"><?php echo $course['name']; ?></a>
                                <div class="course-details">
                                    <span class="course-category">Business</span>
                                    <span class="course-price course-free">Free</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- /single course -->


                    <!-- single course -->
                    <!-- <div class="col-md-3 col-sm-6 col-xs-6">
						<div class="course">
							<a href="#" class="course-img">
								<img src="./img/course02.jpg" alt="">
								<i class="course-link-icon fa fa-link"></i>
							</a>
							<a class="course-title" href="#">Introduction to CSS </a>
							<div class="course-details">
								<span class="course-category">Web Design</span>
								<span class="course-price course-premium">Premium</span>
							</div>
						</div>
					</div> -->
                    <!-- /single course -->

                    <!-- single course -->
                    <!-- <div class="col-md-3 col-sm-6 col-xs-6">
						<div class="course">
							<a href="#" class="course-img">
								<img src="./img/course03.jpg" alt="">
								<i class="course-link-icon fa fa-link"></i>
							</a>
							<a class="course-title" href="#">The Ultimate Drawing Course | From Beginner To Advanced</a>
							<div class="course-details">
								<span class="course-category">Drawing</span>
								<span class="course-price course-premium">Premium</span>
							</div>
						</div>
					</div> -->
                    <!-- /single course -->

                    <!-- <div class="col-md-3 col-sm-6 col-xs-6">
						<div class="course">
							<a href="#" class="course-img">
								<img src="./img/course04.jpg" alt="">
								<i class="course-link-icon fa fa-link"></i>
							</a>
							<a class="course-title" href="#">The Complete Web Development Course</a>
							<div class="course-details">
								<span class="course-category">Web Development</span>
								<span class="course-price course-free">Free</span>
							</div>
						</div>
					</div> -->
                    <!-- /single course -->

                </div>
                <!-- /row -->

                <!-- row -->
                <div class="row">

                    <!-- single course -->
                    <!-- <div class="col-md-3 col-sm-6 col-xs-6">
						<div class="course">
							<a href="#" class="course-img">
								<img src="./img/course05.jpg" alt="">
								<i class="course-link-icon fa fa-link"></i>
							</a>
							<a class="course-title" href="#">PHP Tips, Tricks, and Techniques</a>
							<div class="course-details">
								<span class="course-category">Web Development</span>
								<span class="course-price course-free">Free</span>
							</div>
						</div>
					</div> -->
                    <!-- /single course -->

                    <!-- single course -->
                    <!-- <div class="col-md-3 col-sm-6 col-xs-6">
						<div class="course">
							<a href="#" class="course-img">
								<img src="./img/course06.jpg" alt="">
								<i class="course-link-icon fa fa-link"></i>
							</a>
							<a class="course-title" href="#">All You Need To Know About Web Design</a>
							<div class="course-details">
								<span class="course-category">Web Design</span>
								<span class="course-price course-free">Free</span>
							</div>
						</div>
					</div> -->
                    <!-- /single course -->

                    <!-- single course -->
                    <!-- <div class="col-md-3 col-sm-6 col-xs-6">
						<div class="course">
							<a href="#" class="course-img">
								<img src="./img/course07.jpg" alt="">
								<i class="course-link-icon fa fa-link"></i>
							</a>
							<a class="course-title" href="#">How to Get Started in Photography</a>
							<div class="course-details">
								<span class="course-category">Photography</span>
								<span class="course-price course-free">Free</span>
							</div>
						</div>
					</div> -->
                    <!-- /single course -->


                    <!-- single course -->
                    <!-- <div class="col-md-3 col-sm-6 col-xs-6">
						<div class="course">
							<a href="#" class="course-img">
								<img src="./img/course08.jpg" alt="">
								<i class="course-link-icon fa fa-link"></i>
							</a>
							<a class="course-title" href="#">Typography From A to Z</a>
							<div class="course-details">
								<span class="course-category">Typography</span>
								<span class="course-price course-free">Free</span>
							</div>
						</div>
					</div> -->
                    <!-- /single course -->

                </div>
                <!-- /row -->

            </div>
            <!-- /courses -->

            <!-- <div class="row">
				<div class="center-btn">
					<a class="main-button icon-button" href="#">More Courses</a>
				</div>
			</div> -->

        </div>
        <!-- container -->

    </div>
    <!-- /Courses -->

    <!-- Call To Action -->
    <div id="cta" class="section">

        <!-- Backgound Image -->
        <div class="bg-image bg-parallax overlay" style="background-image:url(./img/cta1-background.jpg)"></div>
        <!-- /Backgound Image -->

        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">

                <div class="col-md-6">
                    <h2 class="white-text">Ceteros fuisset mei no, soleat epicurei adipiscing ne vis.</h2>
                    <p class="lead white-text">Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>
                    <a class="main-button icon-button" href="#">Get Started!</a>
                </div>

            </div>
            <!-- /row -->

        </div>
        <!-- /container -->

    </div>
    <!-- /Call To Action -->

    <!-- Why us -->
    <div id="why-us" class="section">

        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">
                <div class="section-header text-center">
                    <h2>Why Edusite</h2>
                    <p class="lead">Libris vivendo eloquentiam ex ius, nec id splendide abhorreant.</p>
                </div>

                <!-- feature -->
                <div class="col-md-4">
                    <div class="feature">
                        <i class="feature-icon fa fa-flask"></i>
                        <div class="feature-content">
                            <h4>Online Courses</h4>
                            <p>Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>
                        </div>
                    </div>
                </div>
                <!-- /feature -->

                <!-- feature -->
                <div class="col-md-4">
                    <div class="feature">
                        <i class="feature-icon fa fa-users"></i>
                        <div class="feature-content">
                            <h4>Expert Teachers</h4>
                            <p>Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>
                        </div>
                    </div>
                </div>
                <!-- /feature -->

                <!-- feature -->
                <div class="col-md-4">
                    <div class="feature">
                        <i class="feature-icon fa fa-comments"></i>
                        <div class="feature-content">
                            <h4>Community</h4>
                            <p>Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>
                        </div>
                    </div>
                </div>
                <!-- /feature -->

            </div>
            <!-- /row -->

            <hr class="section-hr">

            <!-- row -->
            <div class="row">

                <div class="col-md-6">
                    <h3>Persius imperdiet incorrupte et qui, munere nusquam et nec.</h3>
                    <p class="lead">Libris vivendo eloquentiam ex ius, nec id splendide abhorreant.</p>
                    <p>No vel facete sententiae, quodsi dolores no quo, pri ex tamquam interesset necessitatibus. Te denique cotidieque delicatissimi sed. Eu doming epicurei duo. Sit ea perfecto deseruisse theophrastus. At sed malis hendrerit, elitr deseruisse in sit, sit ei facilisi mediocrem.</p>
                </div>

                <div class="col-md-5 col-md-offset-1">
                    <a class="about-video" href="#">
                        <img src="./img/about-video.jpg" alt="">
                        <i class="play-icon fa fa-play"></i>
                    </a>
                </div>

            </div>
            <!-- /row -->

        </div>
        <!-- /container -->

    </div>
    <!-- /Why us -->


    <div id="cta" class="section">

        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">

                <div class="col-md-5">
                    <h2 class="dark-text">Ceteros fuisset mei no, soleat epicurei adipiscing ne vis.</h2>
                    <p class="lead dark-text">Ceteros fuisset mei no, soleat epicurei adipiscing ne vis. Et his suas veniam nominati.</p>

                </div>




                <!-- Admission Form Section -->
                <div class="col-md-6 col-md-offset-1">
                    <form id="admissionForm">
                        <div class="form-group col-md-6">
                            <label for="full-name">Full Name</label>
                            <input type="text" class="form-control" id="full-name" name="name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="class">Select Class</label>
                            <select class="form-control ss" id="class" name="class" required>
                                <option value="">Select Class</option>
                                <option value="class1">Class 1</option>
                                <option value="class2">Class 2</option>
                                <option value="class3">Class 3</option>
                                <option value="class4">Class 4</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="label" for="message">Message</label>
                                <textarea name="message" class="form-control" id="message" cols="30" rows="3" placeholder="Message"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="main-button submit btn-sm btn-block" name="apply">Book Now</button>
                        </div>
                    </form>
                </div>
                <!-- /Admission Form Section -->

            </div>
            <!-- /row -->

        </div>
        <!-- /container -->

    </div>


    <!-- Contact CTA -->
    <div id="contact-cta" class="section">

        <!-- Backgound Image -->
        <div class="bg-image bg-parallax overlay" style="background-image:url(./img/cta2-background.jpg)"></div>
        <!-- Backgound Image -->

        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">

                <div class="col-md-8 col-md-offset-2 text-center">
                    <h2 class="white-text">Contact Us</h2>
                    <p class="lead white-text">Libris vivendo eloquentiam ex ius, nec id splendide abhorreant.</p>
                    <a class="main-button icon-button" target="_blank" href="./contact.php">Contact Us Now</a>
                </div>

            </div>
            <!-- /row -->

        </div>
        <!-- /container -->

    </div>
    <!-- /Contact CTA -->

    <!-- Footer -->
    <footer id="footer" class="section">

        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">

                <!-- footer logo -->
                <div class="col-md-6">
                    <div class="footer-logo">
                        <a class="logo" href="index.html">
                            <img src="../img/Sunshine Academy Main Logo (1).png" alt="logo">
                        </a>
                    </div>
                </div>
                <!-- footer logo -->

                <!-- footer nav -->
                <div class="col-md-6">
                    <ul class="footer-nav">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Courses</a></li>
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <!-- /footer nav -->

            </div>
            <!-- /row -->

            <!-- row -->
            <div id="bottom-footer" class="row">

                <!-- social -->
                <div class="col-md-4 col-md-push-8">
                    <ul class="footer-social">
                        <li><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#" class="instagram"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#" class="youtube"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
                <!-- /social -->

            </div>
            <!-- row -->

        </div>
        <!-- /container -->

    </footer>
    <!-- /Footer -->

    <!-- preloader -->
    <!-- <div id='preloader'>
		<div class='preloader'></div>
	</div> -->
    <!-- /preloader -->


    <!-- jQuery Plugins -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script src="js/main.js"></script>
    <script src="js/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>
    <script>
        // $(document).ready(function() {
        //     // Function to handle form submission for both admission and student addition
        //     function handleFormSubmission(formSelector, phpUrl, successMessage, errorMessage, redirectUrl) {
        //         $(formSelector).submit(function(event) {
        //             event.preventDefault(); // Prevent default form submission

        //             var formData = $(this).serialize(); // Get form data

        //             $.ajax({
        //                 url: phpUrl, // PHP file URL
        //                 type: "POST",
        //                 data: formData,
        //                 success: function(response) {
        //                     if (response.trim() === "error") {
        //                         // Show error alert if user already exists
        //                         alert(errorMessage);
        //                     } else if (response.trim() === "success") {
        //                         // Show success alert
        //                         alert(successMessage);
        //                         // Redirect if provided
        //                         if (redirectUrl) {
        //                             window.location.href = redirectUrl;
        //                         }
        //                     } else {
        //                         console.error("Unexpected response from server: " + response);
        //                     }
        //                     $(formSelector)[0].reset(); // Clear form fields
        //                 },
        //                 error: function(xhr, status, error) {
        //                     console.error(xhr.responseText); // Log error message
        //                     // Handle errors appropriately, e.g., display user-friendly error message
        //                 }
        //             });
        //         });
        //     }

        //     // Call the function for admission form
        //     handleFormSubmission("#admissionForm", "../admission.php", "Thank you for your response. We will get back to you soon!", "We already have your details. We will get back to you soon!");

        //     // Call the function for student addition form
        //     handleFormSubmission("#addStudentForm", "../insert.php", "Student added successfully!", "We already have your details. Now you can login!", "../loginstu.php");
        // });

        // Function to handle scroll event
        window.onscroll = function() {
            scrollFunction()
        };

        // Function to handle scroll event
        window.onscroll = function() {
            var marqueeWrapper = document.getElementById('marqueeWrapper');
            var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

            // Check if the scroll position is greater than a certain threshold (e.g., 750 pixels)
            if (scrollPosition > 750) {
                // If scroll position is greater than the threshold, hide the marquee
                marqueeWrapper.style.display = 'block';

                // Remove the event listener after hiding the marquee
                window.onscroll = null;
            } else {
                // If scroll position is less than the threshold, show the marquee
                marqueeWrapper.style.display = 'none';
            }
        };


        function closeMarquee() {
            var marqueeWrapper = document.getElementById('marqueeWrapper');
            marqueeWrapper.style.display = 'none'; // Hide the marquee wrapper when close button is clicked
        }
    </script>
</body>

</html>