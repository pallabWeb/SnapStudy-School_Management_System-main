<?php
include 'db.php';

// Fetch students who have paid their fees
$sql = "SELECT af.id, s.name AS student_name, af.after_6_months_fees_amount, af.pdf_path_1, af.pdf_path_2, 
               af.first_library_fees, af.second_library_fees, af.first_tuition_fees, af.second_tuition_fees
        FROM after_6_months_fees af
        JOIN students s ON af.student_id = s.id";

$result = $data->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students Fees</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Students Fees Details</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Student Name</th>
        <th>Fees Amount (After 6 months)</th>
        <th>First Library Fees</th>
        <th>Second Library Fees</th>
        <th>First Tuition Fees</th>
        <th>Second Tuition Fees</th>
        <th>PDF 1</th>
        <th>PDF 2</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['student_name']}</td>
                    <td>{$row['after_6_months_fees_amount']}</td>
                    <td>{$row['first_library_fees']}</td>
                    <td>{$row['second_library_fees']}</td>
                    <td>{$row['first_tuition_fees']}</td>
                    <td>{$row['second_tuition_fees']}</td>
                    <td>" . ($row['pdf_path_1'] ? "<a href='{$row['pdf_path_1']}' target='_blank'>View PDF 1</a>" : "No PDF 1") . "</td>
                    <td>" . ($row['pdf_path_2'] ? "<a href='{$row['pdf_path_2']}' target='_blank'>View PDF 2</a>" : "No PDF 2") . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No records found</td></tr>";
    }
    $data->close();
    ?>
</table>

</body>
</html>
