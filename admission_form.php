<?php
session_start();

// Include database connection
include_once 'db.php';

// Function to check if the student already exists
function studentExists($data, $username, $email, $phone)
{
    // Check if the student already exists in AdmissionForm table
    $checkQuery = "SELECT * FROM AdmissionForm WHERE username='$username' OR parent_email='$email' OR parent_contact='$phone'";
    $checkResult = $data->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        return true;
    }

    // Check if the student already exists in students table
    $checkQuery = "SELECT * FROM students WHERE student_username='$username' OR email='$email' OR phone='$phone'";
    $checkResult = $data->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        return true;
    }

    return false;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['razorpay_payment_id'])) {
        // Check connection
        if ($data->connect_error) {
            die("Connection failed: " . $data->connect_error);
        }

        // Check if username, email, and phone number already exist
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['contactNumber'];

        if (studentExists($data, $username, $email, $phone)) {
            echo '<script>alert("Student already exists. Please choose different credentials.");</script>';
        } else {
            // Process the form submission and payment
            if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'uploads/';
                $tmp_file = $_FILES['picture']['tmp_name'];
                $file_name = $_FILES['picture']['name'];

                if (move_uploaded_file($tmp_file, $upload_dir . $file_name)) {
                    $stmt = $data->prepare("INSERT INTO AdmissionForm (picture, username, password, name, dob, class, mother_name, father_name, parent_contact, parent_email, blood_group, address, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssssssss", $picture, $username, $password, $name, $dob, $class, $mother_name, $father_name, $parent_contact, $parent_email, $blood_group, $address, $gender);

                    $picture = $file_name;
                    $password = md5($_POST['password']);
                    $name = $_POST['name'];
                    $dob = $_POST['dob'];
                    $class = $_POST['class'];
                    $mother_name = $_POST['motherName'];
                    $father_name = $_POST['fatherName'];
                    $parent_contact = $_POST['contactNumber'];
                    $parent_email = $_POST['email'];
                    $blood_group = $_POST['blood'];
                    $address = $_POST['address'];
                    $gender = $_POST['gender'];

                    if ($stmt->execute()) {
                        echo '<script>alert("Application submitted successfully!");</script>';
                    } else {
                        echo '<script>alert("Error: ' . $data->error . '");</script>';
                    }

                    $stmt->close();
                } else {
                    echo '<script>alert("Sorry, there was an error uploading your file.");</script>';
                }
            } else {
                echo '<script>alert("Sorry, there was an error uploading your file.");</script>';
            }
        }

        $data->close();

        echo '<script>window.location.href = "../home/";</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sunshine | Apply Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css" />
    <style>
        .card {
            width: 100%;
            height: auto;
            border: none;
            padding: 10px 30px 40px;
        }

        .drop_box {
            margin: 10px 0;
            padding: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border: 3px dashed #a3a3a3;
            border-radius: 3px;
        }

        /* .btn {
            text-decoration: none;
            background-color: #005af0;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            outline: none;
            transition: 0.3s;
        } */

        /* .btn:hover {
            text-decoration: none;
            background-color: #ffffff;
            color: #005af0;
            padding: 10px 20px;
            border: none;
            outline: 1px solid #010101;
        } */

        .form input {
            margin: 10px 0;
            width: 100%;
            background-color: #e2e2e2;
            border: none;
            outline: none;
            padding: 12px 20px;
            border-radius: 4px;
        }

        .imagePreview {
            margin-top: 20px;
            width: 200px;
            border: 1px solid #ccc;
            display: none;
            /* Initially hide the image preview */
        }

        .imagePreview img {
            max-width: 100%;
            max-height: 100%;
        }

        .fileLabel svg {
            font-size: 50px;
            cursor: pointer;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-5">Admission Form</h1>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <fieldset class="border mb-3 rounded-3">
                        <div class="container">
                            <legend class="w-auto mx-4 mt-3">Upload Picture</legend>
                            <div class="card">
                                <div class="drop_box">
                                    <input type="file" accept="image/*" name="picture" id="fileInput" style="display:none;" required>
                                    <label for="fileInput" class="fileLabel">
                                        <svg height="80px" width="80px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 312.602 312.602" xml:space="preserve">
                                            <path style="fill:#000002;" d="M251.52,137.244c-3.966,0-7.889,0.38-11.738,1.134c-1.756-47.268-40.758-85.181-88.448-85.181
    c-43.856,0-80.964,32.449-87.474,75.106C28.501,129.167,0,158.201,0,193.764c0,36.106,29.374,65.48,65.48,65.48h54.782
    c4.143,0,7.5-3.357,7.5-7.5c0-4.143-3.357-7.5-7.5-7.5H65.48c-27.835,0-50.48-22.645-50.48-50.48c0-27.835,22.646-50.48,50.48-50.48
    c1.367,0,2.813,0.067,4.419,0.206l7.6,0.658l0.529-7.61c2.661-38.322,34.861-68.341,73.306-68.341
    c40.533,0,73.51,32.977,73.51,73.51c0,1.863-0.089,3.855-0.272,6.088l-0.983,11.968l11.186-4.367
    c5.356-2.091,10.99-3.151,16.747-3.151c25.409,0,46.081,20.672,46.081,46.081c0,25.408-20.672,46.08-46.081,46.08
    c-0.668,0-20.608-0.04-40.467-0.08c-19.714-0.04-39.347-0.08-39.999-0.08c-4.668,0-7.108-2.248-7.254-6.681v-80.959l8.139,9.667
    c2.667,3.17,7.399,3.576,10.567,0.907c3.169-2.667,3.575-7.398,0.907-10.567l-18.037-21.427c-2.272-2.699-5.537-4.247-8.958-4.247
    c-3.421,0-6.686,1.548-8.957,4.247l-18.037,21.427c-2.668,3.169-2.262,7.9,0.907,10.567c1.407,1.185,3.121,1.763,4.826,1.763
    c2.137,0,4.258-0.908,5.741-2.67l7.901-9.386v80.751c0,8.686,5.927,21.607,22.254,21.607c0.652,0,20.27,0.04,39.968,0.079
    c19.874,0.041,39.829,0.081,40.498,0.081c33.681,0,61.081-27.4,61.081-61.08C312.602,164.644,285.201,137.244,251.52,137.244z" />
                                        </svg>
                                    </label>
                                    <label for="fileInput" class="fileLabel">Click here to upload</label>
                                    <div class="imagePreview" id="imagePreview" style="display: none;"></div>
                                    <button class="btn-danger rounded mt-3" id="deleteButton" style="display: none;" onclick="deleteImage()"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="border p-3 rounded-3">
                        <legend class="w-auto">Login Details</legend>
                        <div class="form-group row">
                            <label for="username" class="col-sm-4 col-form-label">Username:</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- <label for="password" class="col-sm-4 col-form-label">Password:</label> -->
                            <div class="col-sm-8 mb-3">
                                <input type="password" hidden class="form-control" id="password" name="password" value=" " placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="class" class="col-sm-4 col-form-label">Class:</label>
                            <div class="col-sm-8 mb-3">
                                <select class="form-select" name="class" required>
                                    <option selected="">Choose...</option>
                                    <option value="class1">Class 1</option>
                                    <option value="class2">Class 2</option>
                                    <option value="class3">Class 3</option>
                                    <option value="class4">Class 4</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="border p-3 mt-3 rounded-3">
                        <legend class="w-auto">Personal Details</legend>
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Name:</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dob" class="col-sm-4 col-form-label">Date of Birth:</label>
                            <div class="col-sm-8 mb-3">
                                <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="motherName" class="col-sm-4 col-form-label">Mother's Name:</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" class="form-control" id="motherName" name="motherName" placeholder="Mother's Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fatherName" class="col-sm-4 col-form-label">Father's Name:</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" class="form-control" id="fatherName" name="fatherName" placeholder="Father's Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contactNumber" class="col-sm-4 col-form-label">Parent's Contact:</label>
                            <div class="col-sm-8 mb-3">
                                <input type="tel" class="form-control" id="contactNumber" name="contactNumber" placeholder="Contact Number" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label">Parent's Email:</label>
                            <div class="col-sm-8 mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email ID" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="blood" class="col-sm-4 col-form-label">Blood Group:</label>
                            <div class="col-sm-8 mb-3">
                                <input type="text" class="form-control" id="blood" name="blood" placeholder="Blood Group" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-4 col-form-label">Permanent Address:</label>
                            <div class="col-sm-8 mb-3">
                                <textarea class="form-control" id="address" name="address" placeholder="Address" cols="30" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gender" class="col-sm-4 col-form-label">Gender:</label>
                            <div class="col-sm-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-group m-5 text-center">
                        <button type="button" id="applyButton" class="submit btn btn-primary btn-lg btn-block px-5">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('fileInput');
        const imagePreview = document.getElementById('imagePreview');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    imagePreview.innerHTML = '';
                    imagePreview.appendChild(img);
                    imagePreview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });

        function ekUpload() {
            var fileInput = document.getElementById('fileInput');
            var fileLabel = document.querySelector('.fileLabel');
            var deleteButton = document.getElementById('deleteButton');

            fileInput.addEventListener('change', function(e) {
                var file = e.target.files[0];

                if (file) {
                    var reader = new FileReader();

                    reader.onload = function() {
                        var imagePreview = document.getElementById('imagePreview');
                        imagePreview.innerHTML = `<img src="${reader.result}" alt="Preview Image">`;
                        imagePreview.style.display = 'block';
                        fileLabel.style.display = 'none';
                        deleteButton.style.display = 'inline-block';
                    };

                    reader.readAsDataURL(file);
                }
            });
        }

        function deleteImage() {
            var fileInput = document.getElementById('fileInput');
            var imagePreview = document.getElementById('imagePreview');
            var fileLabel = document.querySelector('.fileLabel');
            var deleteButton = document.getElementById('deleteButton');

            // Clear the file input
            fileInput.value = '';

            // Hide the image preview and delete button
            imagePreview.innerHTML = '';
            imagePreview.style.display = 'none';
            deleteButton.style.display = 'none';

            // Show the file label
            fileLabel.style.display = 'inline-block';
        }

        ekUpload();

        document.getElementById('applyButton').addEventListener('click', function(e) {
            e.preventDefault();
            var formData = new FormData(document.querySelector('form'));

            // Check if the student already exists
            fetch('check_student_exists.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        alert('Student already exists. Please choose different credentials.');
                    } else {
                        // Proceed to payment if the student does not exist
                        fetch('create_razorpay_order.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                var options = {
                                    "key": data.key,
                                    "amount": "499900",
                                    "currency": "INR",
                                    "name": "Sunshine Academy",
                                    "description": "Admission Fee",
                                    "order_id": data.order_id,
                                    "handler": function(response) {
                                        formData.append('razorpay_payment_id', response.razorpay_payment_id);
                                        formData.append('razorpay_order_id', response.razorpay_order_id);
                                        formData.append('razorpay_signature', response.razorpay_signature);

                                        fetch('<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', {
                                                method: 'POST',
                                                body: formData
                                            })
                                            .then(response => response.text())
                                            .then(data => {
                                                alert('Application submitted successfully!');
                                                window.location.href = "./home/";
                                            })
                                            .catch(error => console.error('Error:', error));
                                    },
                                    "prefill": {
                                        "name": formData.get('name'),
                                        "email": formData.get('email'),
                                        "contact": formData.get('contactNumber')
                                    },
                                    "notes": {
                                        "address": formData.get('address')
                                    },
                                    "theme": {
                                        "color": "#525ceb"
                                    }
                                };

                                var rzp1 = new Razorpay(options);
                                rzp1.open();
                            })
                            .catch(error => console.error('Error:', error));
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>