<?php
include 'db.php';
require 'PHPspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if (isset($_POST["Import"])) {
    $filename = $_FILES["file"]["tmp_name"];
    $fileType = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

    if ($_FILES["file"]["size"] > 0) {
        // Function to convert date
        function convertDate($date)
        {
            // Check if the date is in Excel format
            if (is_numeric($date)) {
                $excelDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
                return $excelDate->format('Y-m-d');
            } else {
                // Handle common date formats
                $timestamp = strtotime(str_replace('/', '-', $date));
                if ($timestamp) {
                    return date('Y-m-d', $timestamp);
                } else {
                    return null; // Return null if the date is invalid
                }
            }
        }

        // Check if the file is a CSV or an Excel file
        if ($fileType == 'csv') {
            $file = fopen($filename, "r");

            // Prepare the SQL statement with placeholders
            $stmt = $data->prepare("INSERT INTO excel_data (username, password, name, dob, class, mother_name, father_name, parent_contact, parent_email, blood_group, address, gender, added) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if ($stmt === false) {
                echo "<script type=\"text/javascript\">
                        alert(\"Failed to prepare the SQL statement.\");
                        window.location = \"excel_upload.php\"
                      </script>";
                exit;
            }

            // Skip the first line if it contains headers
            fgetcsv($file);

            // Read the CSV file row by row
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $dob = convertDate($emapData[3]);

                if ($dob === null) {
                    echo "<script type=\"text/javascript\">
                            alert(\"Invalid date format in CSV.\");
                            window.location = \"excel_upload.php\"
                          </script>";
                    exit;
                }

                $stmt->bind_param(
                    "ssssssssssssi",
                    $emapData[0],
                    $emapData[1],
                    $emapData[2],
                    $dob,
                    $emapData[4],
                    $emapData[5],
                    $emapData[6],
                    $emapData[7],
                    $emapData[8],
                    $emapData[9],
                    $emapData[10],
                    $emapData[11],
                    $emapData[12]
                );

                $result = $stmt->execute();

                if (!$result) {
                    echo "<script type=\"text/javascript\">
                            alert(\"Error: " . $stmt->error . "\");
                            window.location = \"excel_upload.php\"
                          </script>";
                    exit;
                }
            }

            fclose($file);
            $stmt->close();
        } elseif (in_array($fileType, ['xls', 'xlsx'])) {
            $spreadsheet = IOFactory::load($filename);
            $sheet = $spreadsheet->getActiveSheet();
            $rowIterator = $sheet->getRowIterator();

            // Prepare the SQL statement with placeholders
            $stmt = $data->prepare("INSERT INTO excel_data (username, password, name, dob, class, mother_name, father_name, parent_contact, parent_email, blood_group, address, gender, added) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if ($stmt === false) {
                echo "<script type=\"text/javascript\">
                        alert(\"Failed to prepare the SQL statement.\");
                        window.location = \"excel_upload.php\"
                      </script>";
                exit;
            }

            // Skip the first row if it contains headers
            $firstRow = true;

            foreach ($rowIterator as $row) {
                if ($firstRow) {
                    $firstRow = false;
                    continue;
                }

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $emapData = [];

                foreach ($cellIterator as $cell) {
                    $emapData[] = $cell->getValue();
                }

                $dob = convertDate($emapData[3]);

                if ($dob === null) {
                    echo "<script type=\"text/javascript\">
                            alert(\"Invalid date format in Excel.\");
                            window.location = \"excel_upload.php\"
                          </script>";
                    exit;
                }

                $stmt->bind_param(
                    "ssssssssssssi",
                    $emapData[0],
                    $emapData[1],
                    $emapData[2],
                    $dob,
                    $emapData[4],
                    $emapData[5],
                    $emapData[6],
                    $emapData[7],
                    $emapData[8],
                    $emapData[9],
                    $emapData[10],
                    $emapData[11],
                    $emapData[12]
                );

                $result = $stmt->execute();

                if (!$result) {
                    echo "<script type=\"text/javascript\">
                            alert(\"Error: " . $stmt->error . "\");
                            window.location = \"excel_upload.php\"
                          </script>";
                    exit;
                }
            }

            $stmt->close();
        } else {
            // Display an alert for unsupported file type
            echo "<script type=\"text/javascript\">
                    alert(\"Unsupported file type. Please upload a CSV or Excel file.\");
                    window.location = \"excel_upload.php\"
                  </script>";
            exit;
        }

        // Display success message after import
        echo "<script type=\"text/javascript\">
                alert(\"File has been successfully imported.\");
                window.location = \"excel_upload.php\"
              </script>";
    } else {
        // Display alert if no file selected or file is empty
        echo "<script type=\"text/javascript\">
                alert(\"No file selected or file is empty.\");
                window.location = \"excel_upload.php\"
              </script>";
    }

    mysqli_close($data);
}
?>