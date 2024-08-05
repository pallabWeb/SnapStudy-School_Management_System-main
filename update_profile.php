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

    // Check if form data is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve and sanitize form data
        $name = mysqli_real_escape_string($data, $_POST['name']);
        $email = mysqli_real_escape_string($data, $_POST['email']);
        $phone = mysqli_real_escape_string($data, $_POST['phone']);

        // Image upload handling
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_error = $_FILES['image']['error'];

        // Initialize update query
        $update_query = "UPDATE students SET name='$name', email='$email', phone='$phone'";

        // Check if a new image is uploaded
        if ($file_error === 0) {
            $file_destination = 'uploads/' . $file_name;
            if (move_uploaded_file($file_tmp, $file_destination)) {
                // Add image update to the query
                $update_query .= ", image='$file_destination'";
            } else {
                $error_message = "File upload failed.";
            }
        }

        // Check if password update is requested
        if (!empty($_POST['password'])) {
            // Hash the new password using MD5.
            $password = md5($_POST['password']);
            // Add password update to the query
            $update_query .= ", password='$password'";
        }

        // Complete the update query
        $update_query .= " WHERE student_username='$student_username'";

        // Execute the update query
        if (mysqli_query($data, $update_query)) {
            // Redirect to the student profile with a success message
            $_SESSION['success_message'] = "Profile updated successfully.";
            header("Location: update_profile.php");
            exit();
        } else {
            $error_message = "Error updating record: " . mysqli_error($data);
        }
    }

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student | Update Profile</title>
    <!-- Favicon -->
    <link rel="icon" href="./img/favicon_logoai/favicon-16x16.png" type="image/x-icon">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Add your CSS files here -->
    <link href="css/student.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>

    <!-- Include your preloader here -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- Topbar header -->
        <?php include 'components/user_topbar.php'; ?>
        <!-- End Topbar header -->

        <!-- Left Sidebar -->
        <?php include 'components/user_sidebar.php'; ?>
        <!-- End Left Sidebar -->

        <!-- Page wrapper -->
        <div class="page-wrapper">
            <!-- Bread crumb and right sidebar toggle -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item"><a href="student.php">Dashboard</a></li>
                                    <li class="breadcrumb-item">Update Profile</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Bread crumb and right sidebar toggle -->

            <!-- Container fluid  -->
            <div class="container-fluid">
                <?php
                // Display error message if exists
                if (isset($error_message)) {
                ?>
                    <div class='alert alert-danger' role='alert'><?php echo $error_message; ?></div>
                <?php } ?>

                <!-- Update form -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="row g-3" enctype="multipart/form-data">

                    <!-- Update profile image -->
                    <div class="form-group col-md-6 text-center">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url(<?php echo $user_details['image']; ?>);"></div>
                                <label for="username" class="mt-3"><?php echo $user_details['student_username']; ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">

                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $user_details['name']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_details['email']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Mobile No.</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user_details['phone']; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password" value="">
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success mt-4 float-end">Apply Changes</button>
                    </div>
                </form>

            </div> <!-- End Container fluid -->
        </div>
        <!-- End Page wrapper -->
    </div>
    <!-- End Main wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });

        // Toast notification

        document.addEventListener('DOMContentLoaded', function() {
            var successMessage = "<?php echo isset($_SESSION['success_message']) ? $_SESSION['success_message'] : ''; ?>";

            if (successMessage !== '') {
                // Create a new toast element
                var toast = document.createElement('div');
                toast.classList.add('toast', 'align-items-center', 'text-white', 'bg-success', 'border-0', 'position-fixed', 'top-10', 'start-50', 'translate-middle', 'p-1');
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');

                // Create the toast body
                var toastBody = document.createElement('div');
                toastBody.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'w-100');
                toast.appendChild(toastBody);

                // Create the toast message
                var toastMessage = document.createElement('div');
                toastMessage.classList.add('toast-body');
                toastMessage.textContent = successMessage;
                toastBody.appendChild(toastMessage);

                // Create the close button
                var closeButton = document.createElement('button');
                closeButton.setAttribute('type', 'button');
                closeButton.classList.add('btn-close', 'btn-close-white', 'me-2', 'm-auto');
                closeButton.setAttribute('data-bs-dismiss', 'toast');
                closeButton.setAttribute('aria-label', 'Close');
                toastBody.appendChild(closeButton);

                // Append the toast to the body
                document.body.appendChild(toast);

                // Show the toast
                var toastElement = new bootstrap.Toast(toast);
                toastElement.show();

                // Remove the success message from the session
                <?php unset($_SESSION['success_message']); ?>;
            }
        });
    </script>
    <!-- All Jquery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/app-style-switcher.js"></script>
    <script src="js/feather.min.js"></script>
    <script src="js/perfect-scrollbar.jquery.min.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/custom.min.js"></script>

</body>

</html>