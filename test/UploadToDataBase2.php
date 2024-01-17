

<?php
session_start();
include_once 'dbConfig.php';

// File upload path
$targetDir = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    for ($i = 1; $i <= 4; $i++) {
        $fileInputName = "fileUpload" . $i;

        if (!empty($_FILES[$fileInputName]["name"])) {
            $fileName = basename($_FILES[$fileInputName]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
            if (in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFilePath)) {
                    $insert = $conn->query("INSERT INTO images(file_name, uploaded_on) VALUES ('" . $fileName . "', NOW())");
                    if (!$insert) {
                        $_SESSION['statusMsg'] = "File upload failed, please try again.";
                        header("location: testup.php");
                        exit(); // Ensure the script stops execution if an error occurs
                    }
                } else {
                    $_SESSION['statusMsg'] = "Sorry, there was an error uploading your file.";
                    header("location: testup.php");
                    exit(); // Ensure the script stops execution if an error occurs
                }
            } else {
                $_SESSION['statusMsg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
                header("location: testup.php");
                exit(); // Ensure the script stops execution if an error occurs
            }
        }
    }

    // Redirect only if there were no errors
    $_SESSION['statusMsg'] = "All files have been uploaded successfully.";
    header("location: testup.php");
    exit(); // Ensure the script stops execution after the redirect
}
?>
