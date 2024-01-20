<?php
session_start();
include_once 'dbConfig.php';

// File upload path
$targetDir = "uploads/";

if(isset($_POST['submit'])) {
    if(!empty($_FILES["file"]["name"])) {
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir.$fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
        if(in_array($fileType, $allowTypes)) {
            if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                $insert = $conn->query("INSERT INTO images(file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
                if($insert) {
                    $_SESSION['statusMsg'] = "The file <b>".$fileName."</b> has been uploaded successfully.";
                    header("location: up_show_DB.php");
                } else {
                    $_SESSION['statusMsg'] = "File upload failed, please try again.";
                    header("location: up_show_DB.php");
                }
            } else {
                $_SESSION['statusMsg'] = "Sorry, there was an error uploading your file.";
                header("location: up_show_DB.php");
            }
        } else {
            $_SESSION['statusMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
            header("location: up_show_DB.php");
        }
    } else {
        $_SESSION['statusMsg'] = "Please select a file to upload.";
        header("location: up_show_DB.php");
    }
}
?>