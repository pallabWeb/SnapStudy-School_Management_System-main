<?php
// Database connection parameters
include_once '../db.php';

// Fetching courses
try {
    // Prepare and execute query to fetch courses
    $coursesQuery = mysqli_query($data, "SELECT * FROM courses");
    if ($coursesQuery) {
        // Fetch all courses
        $courses = mysqli_fetch_all($coursesQuery, MYSQLI_ASSOC);
    } else {
        // Output error message if fetching courses fails
        echo "Error fetching courses: " . mysqli_error($data);
    }
} catch (Exception $e) {
    // Output error message if an exception occurs
    echo "Error fetching courses: " . $e->getMessage();
}

// Querying to fetch teachers
$teachersQuery = mysqli_query($data, "SELECT * FROM teacher");
if ($teachersQuery) {
    // Fetch all teachers
    $teachers = mysqli_fetch_all($teachersQuery, MYSQLI_ASSOC);
} else {
    // Output error message if fetching teachers fails
    echo "Error fetching teachers: " . mysqli_error($data);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Sunshine | Home</title>

    <!-- Favicon -->
    <link rel="icon" href="../img/favicon_logoai/favicon-16x16.png" type="image/x-icon">

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
    <link rel="stylesheet" href="css/navbar.css" />
    <style>
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
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
                <li><a href="#home">Home</a></li>
                <li><a href="#courses">Courses</a></li>
                <li><a href="#booking">Book Seat</a></li>
                <li><a href="#teacher">Teachers</a></li>
                <li><a href="#codeForm">Apply</a></li>
                <li><a href="#login">Login</a></li>
            </ul>

            <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
        </div>
    </nav>

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
                    include_once '../db.php';

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

    <!-- Home -->
    <div id="home" class="hero-area">

        <!-- Backgound Image -->
        <div class="bg-image bg-parallax overlay mbg" style="background-image:url(./img/home_background2.jpg)"></div>
        <!-- /Backgound Image -->

        <div class="home-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <h1 class="white-text">Empowering Students to Reach New Heights</h1>
                        <p class="lead white-text">We provide a nurturing and supportive learning environment for every students.</p>
                        <a class="main-button icon-button" href="#about">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Home -->
    <!-- AJAX Cdn Link  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <div class="popup" id="codeForm">
        <div class="popup__content">
            <a href="#" class="popup__close"><i class="fa-solid fa-xmark"></i></a>
            <h2>Enter Unique Code</h2>
            <div id="error-message" class="error-message"></div>
            <div class="heading-tertiary m-3">
                <form id="uniqueCodeForm">
                    <input type="text" id="unique_code" name="unique_code" placeholder="Enter Unique Code" required>
                    <div class="col-md-12 l-btn text-center">
                        <button type="submit" class="main-button submit btn-sm">Verify</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#uniqueCodeForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: '../verify_code.php',
                    type: 'post',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = response.redirect;
                        } else {
                            $('#error-message').text(response.message);
                        }
                    },
                    error: function() {
                        $('#error-message').text('An error occurred while verifying the code.');
                    }
                });
            });
        });
    </script>

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


    <!-- About -->
    <div id="about" class="section">

        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">

                <div class="col-md-6">
                    <div class="section-header">
                        <h2>Welcome to Sunshine Academy</h2>
                        <p class="lead">Libris vivendo eloquentiam ex ius, nec id splendide abhorreant.</p>
                    </div>

                    <!-- feature -->
                    <div class="feature">
                        <i class="feature-icon fa fa-flask"></i>
                        <div class="feature-content">
                            <h4>Additional Courses </h4>
                            <p>Browse our diverse selection of additional courses, each accompanied by detailed descriptions, prerequisites, and credit information.</p>
                        </div>
                    </div>
                    <!-- /feature -->

                    <!-- feature -->
                    <div class="feature">
                        <i class="feature-icon fa fa-users"></i>
                        <div class="feature-content">
                            <h4>Expert Teachers</h4>
                            <p>With years of teaching experience, our educators have honed their instructional skills and are adept at engaging students in meaningful learning experiences.</p>
                        </div>
                    </div>
                    <!-- /feature -->

                    <!-- feature -->
                    <div class="feature">
                        <i class="feature-icon fa fa-comments"></i>
                        <div class="feature-content">
                            <h4>Community</h4>
                            <p>We serves as a central hub for communication within our community, providing updates, announcements, and resources to keep everyone informed and connected.</p>
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
                    <?php
                    // Counter to track the number of displayed courses
                    $courseCount = 0;
                    foreach ($courses as $course) :
                        // Display only the first four courses
                        if ($courseCount < 4) :
                    ?>
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
                    <?php
                            // Increment the counter after displaying a course
                            $courseCount++;
                        endif;
                    endforeach;
                    ?>
                </div>
                <?php
                // Check if there are more than four courses
                if (count($courses) > 4) :
                ?>
                    <!-- Button to show more courses -->
                    <div class="col-md-8 col-md-offset-2 text-center" style="margin-top: 40px;">
                        <a class="main-button icon-button" href="courses.php">More Courses</a>
                    </div>
                <?php endif; ?>


            </div>
            <!-- /row -->

        </div>
        <!-- /courses -->

    </div>
    <!-- container -->

    </div>
    <!-- /Courses -->

    <!-- Call To Action -->
    <div id="booking" class="section">

        <!-- Backgound Image -->
        <div class="bg-image bg-parallax overlay" style="background-image:url(./img/pexels-pixabay-356065.jpg)"></div>
        <!-- /Backgound Image -->

        <!-- container -->
        <div class="container">

            <!-- row -->
            <div class="row">

                <div class="col-md-5">
                    <h2 class="white-text">Secure your spot now for an unforgettable experience!</h2>
                    <p class="lead white-text">Book your next adventure with ease! Reserve your spot now and embark on a journey filled with unforgettable experiences.</p>
                </div>

                <!-- Seat Booking Form Section -->
                <div class="col-md-6 col-md-offset-1">
                    <form id="admissionForm">
                        <div class="form-group col-md-6">
                            <label for="full-name" class="white-text">Full Name</label>
                            <input type="text" class="form-control" style="background-color: #fff;" id="full-name" name="name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email" class="white-text">Email</label>
                            <input type="email" class="form-control" style="background-color: #fff;" id="email" name="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone" class="white-text">Phone Number</label>
                            <input type="number" class="form-control" style="background-color: #fff;" id="phone" name="phone" maxlength="10" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="class" class="white-text">Select Class</label>
                            <select class="form-control ss dark-text" style="background-color: #fff;" id="class" name="class" required>
                                <option value="">Select Class</option>
                                <option value="class1">Class 1</option>
                                <option value="class2">Class 2</option>
                                <option value="class3">Class 3</option>
                                <option value="class4">Class 4</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="message" class="white-text">Message</label>
                                <textarea name="message" style="background: #fff;" class="form-control" id="message" cols="25" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="main-button submit btn" name="apply">Book Now</button>
                        </div>
                    </form>
                </div>
                <!-- /Seat Booking Form Section -->

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
                    <h2>Why Sunshine Academy</h2>
                    <p class="lead">We provide a nurturing and supportive learning environment for every students.</p>
                </div>

                <!-- feature -->
                <div class="col-md-4">
                    <div class="feature">
                        <i class="feature-icon fa fa-flask"></i>
                        <div class="feature-content">
                            <h4>Additional Courses</h4>
                            <p>Browse our diverse selection of additional courses, each accompanied by detailed descriptions, prerequisites, and credit information.</p>
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
                            <p>With years of teaching experience, our educators have honed their instructional skills and are adept at engaging students in meaningful learning experiences.</p>
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
                            <p>We serves as a central hub for communication within our community, providing updates, announcements, and resources to keep everyone informed and connected.</p>
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
                    <h3>Here are some reasons why you should choose us</h3>
                    <p class="lead">We provide a nurturing and supportive learning environment for every students.</p>
                    <p>At Sunshine Academy, we prioritize academic excellence while nurturing the whole child. Our safe and supportive environment fosters innovation in teaching, ensuring an engaging learning experience. Join our strong community dedicated to student success and future readiness. Illuminate your path with Sunshine Academy!</p>
                </div>

                <div class="col-md-5 col-md-offset-1">
                    <a class="about-video" href="#">
                        <img src="./img/about-video.jpg" alt="">
                        <i class="play-icon fa fa-play"></i>
                    </a>
                </div>

            </div>
            <!-- /row -->

            <div class="video-popup" id="videoPopup">
                <div class="video-popup-content">
                    <span class="video-popup-close">&times;</span>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/2tyt4bPLmpg?si=nO7jilyI_kYi1n22" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>

            <script>
                // JavaScript for Video Popup
                const videoPopup = document.getElementById("videoPopup");
                const videoPopupClose = document.querySelector(".video-popup-close");
                const aboutVideoLink = document.querySelector(".about-video");
                const videoIframe = document.getElementById("videoIframe");

                aboutVideoLink.addEventListener("click", function(e) {
                    e.preventDefault();
                    videoPopup.style.display = "block";
                });

                videoPopupClose.addEventListener("click", function() {
                    videoPopup.style.display = "none";
                    // Reset the src attribute to stop the video
                    videoIframe.src = videoIframe.src;
                });
            </script>




        </div>
        <!-- /container -->

    </div>
    <!-- /Why us -->
    <div id="teacher" class="section2">
        <!-- Teachers container -->
        <div class="container">

            <!-- row -->
            <div class="row">
                <div class="section-header text-center">
                    <h2>Our Expert Teachers</h2>
                    <p class="lead">Here are some Expert Teachers who are always ready to help.</p>
                </div>
            </div>
            <!-- /row -->
            <div class="team section">
                <div class="container">
                    <div class="row">
                        <?php
                        // Counter to track the number of displayed teachers
                        $teacherCount = 0;
                        foreach ($teachers as $teacher) :
                            // Display only the first four teachers
                            if ($teacherCount < 4) :
                        ?>
                                <div class="col-lg-3 col-md-6">
                                    <div class="team-member">
                                        <div class="main-content">
                                            <img src="../<?php echo $teacher['image']; ?>" alt="">
                                            <h4><?php echo $teacher['name']; ?></h4>
                                            <ul class="social-icons">
                                                <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                        <?php
                                // Increment the counter after displaying a teacher
                                $teacherCount++;
                            endif;
                        endforeach;
                        ?>
                    </div>
                    <?php
                    // Check if there are more than four teachers
                    if (count($teachers) > 4) :
                    ?>
                        <!-- Button to show more teachers -->
                        <div class="col-md-8 col-md-offset-2 text-center" style="margin-top: 40px;">
                            <a class="main-button icon-button" href="./teacher.php">More Teachers</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact CTA -->
    <div id="contact-cta" class="section">

        <!-- Backgound Image -->
        <div class="bg-image bg-parallax overlay" style="background-image:url(./img/book.jpg)"></div>
        <!-- Backgound Image -->

        <!-- container -->
        <div class="container" id="contact">

            <!-- row -->
            <div class="row">

                <div class="col-md-8 col-md-offset-2 text-center">
                    <h2 class="white-text">Contact Us</h2>
                    <p class="lead white-text">We're always here to help! If you have any questions, feedback, or inquiries, feel free to reach out to us.</p>
                    <a class="main-button icon-button" target="_blank" href="./contact.php">Contact Us Now</a>
                </div>

            </div>
            <!-- /row -->

        </div>
        <!-- /container -->

    </div>
    <!-- /Contact CTA -->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row-footer">
                <div class="footer-col">
                    <h4>Sunshine Academy</h4>
                    <ul>
                        <li><a href="#why-us">About us</a></li>
                        <li><a href="#">Our services</a></li>
                        <li><a href="#">Privacy policy</a></li>
                        <li><a href="#">Affiliate program</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>get help</h4>
                    <ul>
                        <li><a href="#">Events</a></li>
                        <li><a href="booking_status.php">Seat Booking status</a></li>
                        <li><a href="#">Payment options</a></li>
                        <li><a href="contact.php" target="_blank">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Admissions</a></li>
                        <li><a href="#">Academics</a></li>
                        <li><a href="#">Courses</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>follow us</h4>
                    <div class="social-links">
                        <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.x.com/" target="_blank"><i class="fa-brands fa-square-x-twitter"></i></a>
                        <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@SunshineAcademy_official" target="_blank"><i class="fab fa-youtube"></i></a>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
    <script src="js/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>
    <script>
        $(document).ready(function() {
            // Function to handle form submission for both admission and student addition
            function handleFormSubmission(formSelector, phpUrl, successMessage, errorMessage, redirectUrl) {
                $(formSelector).submit(function(event) {
                    event.preventDefault(); // Prevent default form submission

                    var formData = $(this).serialize(); // Get form data

                    $.ajax({
                        url: phpUrl, // PHP file URL
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            if (response.trim() === "error") {
                                // Show error alert if user already exists
                                alert(errorMessage);
                            } else if (response.trim() === "success") {
                                // Show success alert
                                alert(successMessage);
                                // Redirect if provided
                                if (redirectUrl) {
                                    window.location.href = redirectUrl;
                                }
                            } else {
                                console.error("Unexpected response from server: " + response);
                            }
                            $(formSelector)[0].reset(); // Clear form fields
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log error message
                            // Handle errors appropriately, e.g., display user-friendly error message
                        }
                    });
                });
            }

            // Call the function for admission form
            handleFormSubmission("#admissionForm", "../booking.php", "Thank you for your response. We will get back to you soon!", "We already have your details. We will get back to you soon!");

            // Call the function for student addition form
            handleFormSubmission("#addStudentForm", "../insert.php", "Student added successfully!", "We already have your details. Now you can login!", "./home/");
        });

        ///////////////////////////////////////////
        // Function to handle scroll event//
        ///////////////////////////////////////////


        $(document).ready(function() {
            // Add smooth scrolling to all links
            $("a").on("click", function(event) {
                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    $("html, body").animate({
                            scrollTop: $(hash).offset().top,
                        },
                        800,
                        function() {
                            // Add hash (#) to URL when done scrolling (default click behavior)
                            window.location.hash = hash;
                        }
                    );
                } // End if
            });
        });

        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        }

        // Function to handle scroll event
        window.onscroll = function() {
            scrollFunction();
        };

        // Function to handle scroll event
        window.onscroll = function() {
            var marqueeWrapper = document.getElementById("marqueeWrapper");
            var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

            // Check if the scroll position is greater than a certain threshold (e.g., 750 pixels)
            if (scrollPosition > 750) {
                // If scroll position is greater than the threshold, hide the marquee
                marqueeWrapper.style.display = "block";

                // Remove the event listener after hiding the marquee
                window.onscroll = null;
            } else {
                // If scroll position is less than the threshold, show the marquee
                marqueeWrapper.style.display = "none";
            }
        };

        function closeMarquee() {
            var marqueeWrapper = document.getElementById("marqueeWrapper");
            marqueeWrapper.style.display = "none"; // Hide the marquee wrapper when close button is clicked
        }
    </script>
</body>

</html>