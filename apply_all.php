<?php
include 'db.php';

// Fetch all students from the 'subject' table
$SQLSELECT = "SELECT * FROM excel_data";
$result_set = mysqli_query($data, $SQLSELECT);

// Check if there are any students to add
if (mysqli_num_rows($result_set) > 0) {
    // Loop through each student and insert into the 'admissionForm' table
    while ($row = mysqli_fetch_array($result_set)) {
        $id = $row['id'];
        $username = $row['username'];
        $password = $row['password'];
        $name = $row['name'];
        $dob = $row['dob'];
        $class = $row['class'];
        $mother_name = $row['mother_name'];
        $father_name = $row['father_name'];
        $parent_contact = $row['parent_contact'];
        $parent_email = $row['parent_email'];
        $blood_group = $row['blood_group'];
        $address = $row['address'];
        $gender = $row['gender'];

        $SQLINSERT = "INSERT INTO admissionForm (id, username, password, name, dob, class, mother_name, father_name, parent_contact, parent_email, blood_group, address, gender) 
                      VALUES ('$id', '$username', '$password', '$name', '$dob', '$class', '$mother_name', '$father_name', '$parent_contact', '$parent_email', '$blood_group', '$address', '$gender')";

        mysqli_query($data, $SQLINSERT);
    }

    // Display a success message and redirect to the confirmation page
    echo '<script>
            alert("All students have been added successfully!");
            window.location.href = "excel_upload.php";
          </script>';

} else {
    echo '<script>
    alert("No students found!");
    window.location.href = "excel_upload.php";
  </script>';
}
