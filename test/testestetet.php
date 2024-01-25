<?php
include_once 'dbConfig.php';
session_start();
$targetDir = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to handle file upload and return an error message if unsuccessful
    function handleFileUpload($fileUpload, $pointName, $fileNameAll)
    {
        global $conn, $targetDir;

        // Check if a file was uploaded
        if ($fileUpload["error"] != UPLOAD_ERR_NO_FILE) {
            $copyTags = [];
            $pointNames = [
                $_POST["fileName1"],
                $_POST["fileName2"],
                $_POST["fileName3"],
                $_POST["fileName4"]
            ];

            $oldFileName = $fileUpload["name"];
            $extension = pathinfo($oldFileName, PATHINFO_EXTENSION);
            $fileNameMid = $_POST["fileNameMid"];
            $setFileNameAll = $_POST[$fileNameAll];

            $newFileName = $fileNameMid . "_" . $setFileNameAll . "." . $extension;
            $file = $targetDir . $newFileName;

            $insert = $conn->query("INSERT INTO images(file_name, uploaded_on) VALUES ('" . $newFileName . "', NOW())");
            if (!$insert) {
                return "Error uploading file to database for tag $newFileName.";
            }

            $uploadOk = 1;

            // Move the file to the specified directory
            if (move_uploaded_file($fileUpload["tmp_name"], $file)) {
                // assign data to  
                if ($fileNameAll == "fileName1") {
                    $copyTags = [
                        $pointNames[0] . "_T",
                        $pointNames[1] . "_R",
                        $pointNames[2] . "_L",
                        $pointNames[3] . "_B"
                    ];
                } elseif ($fileNameAll == "fileName2") {
                    $copyTags = [
                        $pointNames[0] . "_L",
                        $pointNames[1] . "_T",
                        $pointNames[2] . "_B",
                        $pointNames[3] . "_R"
                    ];
                } elseif ($fileNameAll == "fileName3") {
                    $copyTags = [
                        $pointNames[0] . "_R",
                        $pointNames[1] . "_B",
                        $pointNames[2] . "_T",
                        $pointNames[3] . "_L"
                    ];
                } elseif ($fileNameAll == "fileName4") {
                    $copyTags = [
                        $pointNames[0] . "_B",
                        $pointNames[1] . "_L",
                        $pointNames[2] . "_R",
                        $pointNames[3] . "_T"
                    ];
                } else {
                    return "Error fileNameAll = null .";
                }

                $copyMessages = [];

                foreach ($copyTags as $tag) {

                    $copyFileName = $fileNameMid . "_" . $tag . "." . $extension;
                    $copyFile = $targetDir . $copyFileName;

                    if (copy($file, $copyFile)) {
                        $copyMessages[] = "Copied as File 1: $copyFileName";
                        $insert = $conn->query("INSERT INTO images(file_name, uploaded_on) VALUES ('" . $copyFileName . "', NOW())");
                        if (!$insert) {
                            $copyMessages[] = "Error uploading copy file to database for tag $tag.";
                        }

                    } else {
                        $copyMessages[] = "Error copying file for tag $tag.";
                    }
                }

                return " File uploaded successfully. <br>Old name: $oldFileName,<br> New name: $newFileName<br>" . implode("<br>", $copyMessages);

            } else {
                return "Error uploading file.";
            }
        } else {
            return "No file uploaded for $pointName.";
        }
    }

    // Function to display uploaded images
    function displayUploadedImage($targetDir, $fileNameMid, $fileUpload)
    {
        $fileName = $fileNameMid . "_" . $fileUpload["name"];
        if (file_exists($targetDir . $fileName)) {
            echo "File:<br>";
            echo "<img src='" . $targetDir . $fileName . "' alt='File' width='300' height='300'><br>";
        }
    }

    // Process File 1
    $pointName1 = $_POST["fileName1"];
    $fileUpload1 = $_FILES["fileUpload1"];
    $message1 = handleFileUpload($fileUpload1, $pointName1, "fileName1");

    // Process File 2
    $pointName2 = $_POST["fileName2"];
    $fileUpload2 = $_FILES["fileUpload2"];
    $message2 = handleFileUpload($fileUpload2, $pointName2, "fileName2");

    // Process File 3
    $pointName3 = $_POST["fileName3"];
    $fileUpload3 = $_FILES["fileUpload3"];
    $message3 = handleFileUpload($fileUpload3, $pointName3, "fileName3");

    // Process File 4
    $pointName4 = $_POST["fileName4"];
    $fileUpload4 = $_FILES["fileUpload4"];
    $message4 = handleFileUpload($fileUpload4, $pointName4, "fileName4");


    // Display messages
    echo "<br><br>File 1: " . $message1 . "<br>";
    echo "<br><br>File 2: " . $message2 . "<br>";
    echo "<br><br>File 3: " . $message3 . "<br>";
    echo "<br><br>File 4: " . $message4 . "<br>";


    // Display uploaded images only if they exist
    displayUploadedImage($targetDir, $_POST["fileNameMid"], $fileUpload1);
    displayUploadedImage($targetDir, $_POST["fileNameMid"], $fileUpload2);
    displayUploadedImage($targetDir, $_POST["fileNameMid"], $fileUpload3);
    displayUploadedImage($targetDir, $_POST["fileNameMid"], $fileUpload4);

    // Redirect only if there were no errors
    $_SESSION['statusMsg'] = "All files have been uploaded successfully.";
    header("location: admin_upload.php");
    exit();



    
}
?>