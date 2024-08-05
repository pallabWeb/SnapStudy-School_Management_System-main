<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Booking Status</title>
    <!-- AJAX CDN Link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #495057;
        }

        input[type="text"] {
            padding: 10px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #bookingDetails {
            margin-top: 20px;
        }

        .card {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 10px;
            background-color: #e9ecef;
        }

        .card h5 {
            margin: 0;
            color: #343a40;
        }

        .card p {
            margin: 5px 0 0 0;
            color: #495057;
        }

        .alert {
            padding: 10px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: #ffc107;
            color: #856404;
        }
        button {
            margin: 10px 0;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #ffc107;
            color: #fff;
            cursor: pointer;
        }
        button a {
            text-decoration: none;
            color: #fff;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#bookingForm').on('submit', function(event) {
                event.preventDefault();
                var phone = $('#phone').val();

                $.ajax({
                    url: 'fetch_booking.php',
                    method: 'POST',
                    data: {
                        phone: phone
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var bookings = response.data;
                            var output = '';
                            for (var i = 0; i < bookings.length; i++) {
                                output += '<div class="card">';
                                output += '<h5>Name: ' + bookings[i].name + '</h5>';
                                output += '<p>Status: ' + bookings[i].status + '</p>';
                                output += '</div>';
                            }
                            $('#bookingDetails').html(output);
                        } else {
                            $('#bookingDetails').html('<div class="alert">No booking found for this phone number.</div>');
                        }
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <h2>Seat Booking Status</h2>
        <form id="bookingForm">
            <label for="phone">Enter your phone number:</label>
            <input type="text" id="phone" name="phone" maxlength="10" required>
            <div style="text-align: center;">
                <input type="submit" value="Search">
                <button><a href="index.php">Back</a></button>
            </div>
        </form>
        <div id="bookingDetails"></div>
    </div>
</body>

</html>