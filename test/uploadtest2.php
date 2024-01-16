<?php
session_start();
include_once 'dbConfig.php';

// File upload path
$targetDir = "uploads/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dropAreaId = $_POST['dropAreaId'];
    $newName = $_POST['newName'];
    $pointName = $_POST['pointName'];

    // Check if the file field is set in $_FILES
    if (isset($_FILES["file"])) {
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                // Adjust the file name based on dropAreaId and newName
                $baseName = $pointName . '-' . $newName;

                switch ($dropAreaId) {
                    case 'top':
                        $newFileName = $baseName . '-T';
                        break;
                    case 'left':
                        $newFileName = $baseName . '-L';
                        break;
                    case 'point':
                        $newFileName = $baseName . '-P';
                        break;
                    case 'Right':
                        $newFileName = $baseName . '-R';
                        break;
                    case 'bottom':
                        $newFileName = $baseName . '-B';
                        break;
                    default:
                        $newFileName = $baseName;
                        break;
                }

                // Perform additional actions or store information in the database if needed
                // For now, let's assume the file information is stored in a table named 'images'
                $insert = $conn->query("INSERT INTO images(file_name, uploaded_on) VALUES ('" . $newFileName . "', NOW())");

                if ($insert) {
                    $_SESSION['statusMsg'] = "The file <b>" . $fileName . "</b> has been uploaded successfully.";
                } else {
                    $_SESSION['statusMsg'] = "File upload failed, please try again.";
                }
            } else {
                $_SESSION['statusMsg'] = "Sorry, there was an error uploading your file.";
            }
        } else {
            $_SESSION['statusMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
        }
    } else {
        $_SESSION['statusMsg'] = "Please select a file to upload.";
    }
} else {
    $_SESSION['statusMsg'] = "Invalid request.";
}

// Redirect to the appropriate page with the status message
header("location: testup.php");
?>
