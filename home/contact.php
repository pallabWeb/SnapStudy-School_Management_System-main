<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Sunshine | Contact Us</title>

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
</head>

<body>

	<!-- Navbar -->
	<nav>
		<div class="wrapper">
			<div class="logo"><a href="/"><img src="../img/Sunshine Academy White Logo (1).png" alt="" width="250"></a></div>
			<input type="radio" name="slider" id="menu-btn">
			<input type="radio" name="slider" id="close-btn">
			<ul class="nav-links">
				<label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
				<li><a href="../home/">Home</a></li>
				<li><a href="../home/#courses">Courses</a></li>
				<li><a href="../home/#booking">Book Seat</a></li>
				<li><a href="../home/#teacher">Teachers</a></li>
				<li><a href="../home/#codeForm" target="_blank">Apply</a></li>
				<li><a href="../home/#login">Login</a></li>
			</ul>

			<label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
		</div>
	</nav>



	<!-- Hero-area -->
	<div class="hero-area section">

		<!-- Backgound Image -->
		<div class="bg-image bg-parallax overlay" style="background-image:url(./img/page-background.jpg)"></div>
		<!-- /Backgound Image -->

		<div class="container">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 text-center">
					<ul class="hero-area-tree">
						<li><a href="index.html">Home</a></li>
						<li>Contact</li>
					</ul>
					<h1 class="white-text">Get In Touch</h1>

				</div>
			</div>
		</div>

	</div>
	<!-- /Hero-area -->

	<!-- Contact -->
	<div id="contact" class="section">

		<!-- container -->
		<div class="container">

			<div id="alertMessage"></div>

			<!-- row -->
			<div class="row">

				<!-- contact form -->
				<div class="col-md-6">
					<div class="contact-form">
						<h4>Send A Message</h4>
						<form id="contactForm" method="post">
							<input class="input" type="text" name="name" placeholder="Name">
							<input class="input" type="email" name="email" placeholder="Email">
							<input class="input" type="text" name="subject" placeholder="Subject">
							<textarea class="input" name="message" placeholder="Enter your Message"></textarea>
							<button id="submitBtn" class="main-button icon-button pull-right">Send Message</button>
						</form>
					</div>
				</div>
				<!-- /contact form -->

				<!-- contact information -->
				<div class="col-md-5 col-md-offset-1">
					<h4>Contact Information</h4>
					<ul class="contact-details">
						<li><i class="fa fa-envelope"></i>Sunshine@info.com</li>
						<li><i class="fa fa-phone"></i>122-547-223-45</li>
						<li><i class="fa fa-map-marker"></i>700034 Park Street</li>
					</ul>

					<!-- contact map -->
					<div id="contact-map"></div>
					<!-- /contact map -->

				</div>
				<!-- contact information -->

			</div>
			<!-- /row -->

		</div>
		<!-- /container -->

	</div>
	<!-- /Contact -->

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
						<li><a href="#">Admission status</a></li>
						<li><a href="#">Payment options</a></li>
						<li><a href="../home/#contact">Contact Us</a></li>
					</ul>
				</div>
				<div class="footer-col">
					<h4>Quick Links</h4>
					<ul>
						<li><a href="../home/">Home</a></li>
						<li><a href="../home/admission.php">Admissions</a></li>
						<li><a href="#">Academics</a></li>
						<li><a href="../home/#courses">Courses</a></li>
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#submitBtn').click(function(event) {
				// Prevent default form submission
				event.preventDefault();

				// Get form data
				var formData = $('#contactForm').serialize();

				// Send AJAX request
				$.ajax({
					type: 'POST',
					url: '../contact_process.php',
					data: formData,
					success: function(response) {
						// Display success message
						$('#alertMessage').html('<div class="alert alert-success">Message sent successfully!</div>');
						// Clear form fields
						$('#contactForm')[0].reset();
					},
					error: function(xhr, status, error) {
						// Display error message
						$('#alertMessage').html('<div class="alert alert-danger">Error: ' + xhr.responseText + '</div>');
					}
				});
			});
		});
	</script>

	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script type="text/javascript" src="js/google-map.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script src="js/main.js"></script>
	<script src="js/navbar.js"></script>

</body>

</html>