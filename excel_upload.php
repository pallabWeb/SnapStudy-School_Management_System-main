<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
	header("location: ./home/#login");
}

include_once 'db.php';  // Database Connection
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
	<title>Admin | Upload Excel File</title>
	<!-- Data Table CSS -->
	<link rel="stylesheet" href="assets/datatables/css/style.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />
	<!-- Custom CSS -->
	<link href="css/style2.min.css" rel="stylesheet">
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


		<?php include 'components/admintopbar.php'; ?> <!-- Topbar header -->


		<?php include 'components/adminsidebar.php'; ?> <!-- End Left Sidebar -->


		<div class="page-wrapper">

			<div class="page-breadcrumb">
				<div class="row">
					<div class="col-7 align-self-center">
						<div class="d-flex align-items-center">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb m-0 p-0">
									<li class="breadcrumb-item"><a href="adminhome.php">Dashboard</a></li>
									<li class="breadcrumb-item">Excel Upload</li>
								</ol>
							</nav>
						</div>
					</div>
					<div class="col-5 d-flex justify-content-end align-self-center">
						<!-- <a type="button" class="btn btn-outline-success rounded-pill float-start" href="add_student.php">Add Students</a> -->
						<form action="apply_all.php" method="post">
							<button type="submit" class="btn btn-outline-success rounded-pill float-start">Add All Students</button>
						</form>
					</div>
				</div>

			</div> <!-- End Bread crumb and right sidebar toggle -->


			<div class="container-fluid"> <!-- Container fluid  -->

				<h2>Upload Student's Details</h2>
				<form class="mb-5" action="import.php" method="post" name="upload_excel" enctype="multipart/form-data">
					<div class="input-group flex-nowrap">
						<div class="custom-file w-100">
							<input class="form-control" name="file" type="file" id="formFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
						</div>
						<button class="btn btn-outline-secondary" type="submit" id="submit" name="Import">
							Upload
						</button>
					</div>
				</form>


				<table id="example" class="table table-striped w-100">
					<thead class="bg-info text-white">
						<tr>
							<th width="5%">Id</th>
							<th>Username</th>
							<!-- <th>Password</th> -->
							<th>Name</th>
							<th>Date of Birth</th>
							<th>Class</th>
							<!-- <th>Mother's Name</th> -->
							<!-- <th>Father's Name</th> -->
							<th width="15%">Parent's Contact</th>
							<th width="15%">Parent's Email</th>
							<!-- <th>Blood Group</th> -->
							<!-- <th>Address</th> -->
							<!-- <th>Gender</th> -->
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php include 'db.php'; ?>
						<?php
						$SQLSELECT = "SELECT * FROM excel_data";
						$result_set = mysqli_query($data, $SQLSELECT);
						while ($row = mysqli_fetch_array($result_set)) {
						?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['username']; ?></td>
								<!-- <td><?php echo $row['password']; ?></td> -->
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['dob']; ?></td>
								<td><?php echo $row['class']; ?></td>
								<!-- <td><?php echo $row['mother_name']; ?></td> -->
								<!-- <td><?php echo $row['father_name']; ?></td> -->
								<td><?php echo $row['parent_contact']; ?></td>
								<td><?php echo $row['parent_email']; ?></td>
								<!-- <td><?php echo $row['blood_group']; ?></td> -->
								<!-- <td><?php echo $row['address']; ?></td> -->
								<!-- <td><?php echo $row['gender']; ?></td> -->
								<td>
									<form action="apply.php" method="post">
										<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
										<button type="submit" class="btn btn-success">Add</button>
									</form>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>


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
	<!-- Data Table JS -->
	<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
	<!-- Datatables Custom JS -->
	<script src="assets/datatables/js/script.js"></script>

</body>

</html>