<?php
include 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Fetch the student's data
    $query = "SELECT * FROM excel_data WHERE id = '$id'";
    $result = mysqli_query($data, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Insert the data into the admissionForm table
            $insertQuery = "INSERT INTO admissionForm (username, password, name, dob, class, mother_name, father_name, parent_contact, parent_email, blood_group, address, gender) 
                            VALUES ('" . $row['username'] . "', '" . $row['password'] . "', '" . $row['name'] . "', '" . $row['dob'] . "', '" . $row['class'] . "', '" . $row['mother_name'] . "', '" . $row['father_name'] . "', '" . $row['parent_contact'] . "', '" . $row['parent_email'] . "', '" . $row['blood_group'] . "', '" . $row['address'] . "', '" . $row['gender'] . "')";

            if (mysqli_query($data, $insertQuery)) {
                echo "<script type='text/javascript'>
                        alert('Student data added to admission form successfully.');
                        window.location.href = 'excel_upload.php';
                      </script>";
            } else {
                echo "Error: " . $insertQuery . "<br>" . mysqli_error($data);
            }
        } else {
            echo "<script type='text/javascript'>
                    alert('No student data found with the provided ID.');
                    window.location.href = 'admission_page.php';
                  </script>";
        }
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($data);
    }
}
?>