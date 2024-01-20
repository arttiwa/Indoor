<?php
session_start();
include_once 'dbConfig.php';

// Function to handle file upload and return an error message if unsuccessful
function handleFileUpload($fileInputName, $targetDir, $pointName, $conn)
{
    $copyTags = [];
    $fileName = basename($_FILES[$fileInputName]["name"]);
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $fileNameMid = $_POST["fileNameMid"];
    $setFileNameAll = $_POST[$pointName];

    $newFileName = $fileNameMid . "_" . $setFileNameAll . "." . $extension;
    $file = $targetDir . $newFileName;

    // Move the file to the specified directory
    if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $file)) {

        // assign data to  
        $copyTags = [
            $pointName . "_T",
            $pointName . "_R",
            $pointName . "_L",
            $pointName . "_B"
        ];
        // assign data to  
        if ($setFileNameAll == "fileName1") {
            $copyTags = [
                $pointName[0] . "_T",
                $pointName[1] . "_R",
                $pointName[2] . "_L",
                $pointName[3] . "_B"
            ];
        } elseif ($setFileNameAll == "fileName2") {
            $copyTags = [
                $pointName[0] . "_L",
                $pointName[1] . "_T",
                $pointName[2] . "_B",
                $pointName[3] . "_R"
            ];
        } elseif ($setFileNameAll == "fileName3") {
            $copyTags = [
                $pointName[0] . "_R",
                $pointName[1] . "_B",
                $pointName[2] . "_T",
                $pointName[3] . "_L"
            ];
        } elseif ($setFileNameAll == "fileName4") {
            $copyTags = [
                $pointName[0] . "_B",
                $pointName[1] . "_L",
                $pointName[2] . "_R",
                $pointName[3] . "_T"
            ];
        } else {
            return "Error sssssss file.";
        }

        $copyMessages = [];

        foreach ($copyTags as $tag) {
            $copyFileName = $fileNameMid . "_" . $tag . "." . $extension;
            $copyFile = $targetDir . $copyFileName;

            if (copy($file, $copyFile)) {
                $insertCopy = $conn->query("INSERT INTO images(file_name, uploaded_on) VALUES ('" . $copyFileName . "', NOW())");
                if (!$insertCopy) {
                    $copyMessages[] = "Error inserting copy file into database for tag $tag.";
                } else {
                    $copyMessages[] = "Copied as File: $copyFileName";
                }
            } else {
                $copyMessages[] = "Error copying file for tag $tag.";
            }
        }

        $insertOriginal = $conn->query("INSERT INTO images(file_name, uploaded_on) VALUES ('" . $newFileName . "', NOW())");

        if (!$insertOriginal) {
            return "Error inserting original file into database. " . implode("<br>", $copyMessages);
        }

        return "File uploaded successfully. <br>Old name: $fileName,<br> New name: $newFileName<br>" . implode("<br>", $copyMessages);
    } else {
        return "Error uploading file.";
    }
}

// File upload path
$targetDir = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pointNames = [
        "fileName1",
        "fileName2",
        "fileName3",
        "fileName4"
    ];

    for ($i = 1; $i <= 4; $i++) {
        $fileInputName = "fileUpload" . $i;
        $pointName = $pointNames[$i - 1];

        if (!empty($_FILES[$fileInputName]["name"])) {
            // Handle both the original file and its copies
            $message = handleFileUpload($fileInputName, $targetDir, $pointName, $conn);

            // Display or log $message as needed
            echo $message;
        }
    }

    // Redirect only if there were no errors
    $_SESSION['statusMsg'] = "All files have been uploaded successfully.";
    header("location: testup.php");
    exit(); // Ensure the script stops execution after the redirect
}
?>