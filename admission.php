<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
  header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection

$sql = "SELECT * FROM `admissionform` WHERE `added` = 0";
$result = mysqli_query($data, $sql);
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
  <title>Admin | Pending admission</title>
  <!-- Custom CSS -->
  <link href="css/style2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/course_card.css">
</head>

<body>

  <!-- Preloader - style you can find in spinners.css -->
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>

  <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

    <!-- Topbar header - style you can find in pages.scss -->
    <?php include 'components/admintopbar.php'; ?>


    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <?php include 'components/adminsidebar.php'; ?>

    <!-- Page wrapper  -->
    <div class="page-wrapper">
      <!-- Bread crumb and right sidebar toggle -->
      <div class="page-breadcrumb">
        <div class="row">
          <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Welcome to Dashboard</h3>
            <div class="d-flex align-items-center">
            </div>
          </div>

        </div>
      </div>

      <!-- Container fluid  -->
      <div class="container-fluid">

        <!-- Start DataCards -->
        <?php
        if (mysqli_num_rows($result) > 0) {
          // Display pending admissions
          while ($info = $result->fetch_assoc()) { ?>
            <div class="card" id="card-<?php echo $info['id']; ?>">
              <div class="card-img" style="background-image:url(uploads/<?php echo $info['picture']; ?>);">
                <button class="btn btn-danger btn-on-image btn-sm float-end rounded-6 delete-button" data-id="<?php echo $info['id']; ?>"><i data-feather="trash" class="feather-icon"></i></button>
              </div>
              <div class="card-content1">
                <a href="#!" class="show-details d-flex justify-content-between">
                  <h2><?php echo $info['username']; ?></h2>
                  <h3><i data-feather="chevron-down" class="feather-icon"></i></h3>
                </a>
                <div class="details text-center" style="display: none;">
                  <p>Name: <?php echo $info['name']; ?></p>
                  <p>Date of Birth: <?php echo $info['dob']; ?></p>
                  <p>Mother Name: <?php echo $info['mother_name']; ?></p>
                  <p>Father Name: <?php echo $info['father_name']; ?></p>
                  <p>Contact: <?php echo $info['parent_contact']; ?></p>
                  <p>Email: <?php echo $info['parent_email']; ?></p>
                  <p>Gender: <?php echo $info['gender']; ?></p>
                  <button class="btn btn-success btn-add-student" data-id="<?php echo $info['id']; ?>">Add Student</button>
                </div>
              </div>
            </div>
          <?php }
        } else {
          // No pending admissions message
          echo '<div class="alert alert-info text-center" role="alert">
                  No pending admissions.
                </div>';
        }
        ?>
      </div> <!-- End Container fluid  -->

    </div>
    <!-- End Page wrapper  -->
  </div>
  <!-- End Wrapper -->


  <script>
    // Add click event listener to each add student button
    var addStudentButtons = document.querySelectorAll('.btn-add-student');

    addStudentButtons.forEach(function(button) {
      button.addEventListener('click', function(event) {
        event.stopPropagation(); // Prevent card click event from firing
        var admissionId = button.getAttribute('data-id');
        // Send AJAX request to add_student.php with admissionId
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add1.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Handle success response
              alert('Student added successfully!');
            } else {
              // Handle error response
              alert('Failed to add student. Please try again.');
            }
          }
        };
        xhr.send('id=' + admissionId);
      });
    });
  </script>


  <script>
    // JS for Card Details

    document.addEventListener("DOMContentLoaded", function() {
      // Get all card elements
      var cards = document.querySelectorAll('.card');

      // Add click event listener to each card
      cards.forEach(function(card) {
        var details = card.querySelector('.details');
        card.addEventListener('click', function() {
          // Toggle the visibility of additional details
          details.style.display = (details.style.display === 'none') ? 'block' : 'none';
        });
      });

      // Get the delete button
      var deleteButtons = document.querySelectorAll('.delete-button');

      // Add click event listener to each delete button
      deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
          event.stopPropagation(); // Prevent card click event from firing
          var admissionId = button.getAttribute('data-id');
          // Confirmation prompt
          var confirmation = confirm('Are you sure you want to delete this ?');
          if (confirmation) {
            // Redirect to delete endpoint with course id
            window.location.href = 'deleteadmission.php?id=' + admissionId;
          }
        });
      });
    });
  </script>

  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script src="js/jquery.min.js"></script>
  <!-- apps -->
  <script src="js/app-style-switcher.js"></script>
  <script src="js/feather.min.js"></script>
  <script src="js/perfect-scrollbar.jquery.min.js"></script>
  <script src="js/sidebarmenu.js"></script>
  <!--Custom JavaScript -->
  <script src="js/custom.min.js"></script>
</body>

</html>
