<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register formDocument</title>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
    <link rel="stylesheet" href="style.css">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body background="school2.jpg" class="bodydeg">


<div class="container">

            <form class="row g-3" id="addStudentForm" action="insert.php" method="POST">
                    <div class="col-md-6">
                        <label for="username" class="mt-3">Username:</label>
                        <input type="text" class="form-control" name="student_username" id="username" placeholder="Enter your username" required>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="mt-3">Student's name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter student's name" required>
                    </div>
                    <div class="col-6">
                        <label for="class" class="mt-3">Class:</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Options</label>
                            <select class="form-select" name="class" id="inputGroupSelect01">
                                <option selected="">Choose...</option>
                                <option value="class1">Class 1</option>
                                <option value="class2">Class 2</option>
                                <option value="class3">Class 3</option>
                                <option value="class4">Class 4</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="phone" class="mt-3">Phone:</label>
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter your phone number" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="mt-3">Email:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="mt-3">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="col-md-6">
                        <label hidden for="image" class="mt-3">Image:</label>
                        <input hidden type="file" class="form-control" name="image" id="image">
                    </div>
                    
                    <div class="col-12">
                    <button type="submit" class="btn btn-success mt-3 rounded-3 float-end submit" name="add_student">Add Student</button>
                </div>
            </form>

        </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $("#addStudentForm").submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize(); // Get form data

                $.ajax({
                    url: "add-student.php", // Change to your actual PHP file URL
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.trim() === "error") {
                            // Show error toast notification if user already exists
                            $(".toast").removeClass("bg-success").addClass("bg-danger").find(".toast-body").text("Student already exists!");
                            $(".toast").toast('show');
                        } else if (response.trim() === "success") {
                            // Show success toast notification if student added successfully
                            $(".toast").removeClass("bg-danger").addClass("bg-success").find(".toast-body").text("Student added successfully!");
                            $(".toast").toast('show');
                        } else {
                            console.error("Unexpected response from server: " + response);
                        }
                        $("#addStudentForm")[0].reset(); // Clear form fields
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error message
                        // Handle errors appropriately, e.g., display user-friendly error message
                    }
                });
            });
        });
    </script>
</body>
</html>
</body>
</html>