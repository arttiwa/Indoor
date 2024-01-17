<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $targetDir = "uploads/"; // specify the directory where you want to store the uploaded files

        // Function to handle file upload and return an error message if unsuccessful
        function handleFileUpload($fileInputName, $targetDir, $pointName, $fileNameAll)
        {
            $oldFileName = $_FILES[$fileInputName]["name"];
            $extension = pathinfo($oldFileName, PATHINFO_EXTENSION);
            $fileNameMid = $_POST["fileNameMid"];
            $setFileNameAll = $_POST[$fileNameAll];
            $newFileName = $fileNameMid . "_" . $setFileNameAll . "." . $extension;
            $file = $targetDir . $newFileName;
            $uploadOk = 1;
            
            // Move the file to the specified directory
            if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $file)) {
                return "File uploaded successfully. Old name: " . $oldFileName . ", New name: " . $newFileName;
            } else {
                return "Error uploading file.";
            }
        }

        // Process File 1
        $pointName1 = $_POST["fileName1"];
        $message1 = handleFileUpload("fileUpload1", $targetDir, $_POST["fileNameMid"], "fileName1");

        // Process File 2
        $pointName2 = $_POST["fileName2"];
        $message2 = handleFileUpload("fileUpload2", $targetDir, $_POST["fileNameMid"], "fileName2");

        // Process File 3
        $pointName3 = $_POST["fileName3"];
        $message3 = handleFileUpload("fileUpload3", $targetDir, $_POST["fileNameMid"], "fileName3");

        // Process File 4
        $pointName4 = $_POST["fileName4"];
        $message4 = handleFileUpload("fileUpload4", $targetDir, $_POST["fileNameMid"], "fileName4");

        // Display uploaded images only if they exist
        if (file_exists($targetDir . $_POST["fileNameMid"] . "_" . $_FILES["fileUpload1"]["name"])) {
            echo "File 1:<br>";
            echo "<img src='" . $targetDir . $_POST["fileNameMid"] . "_" . $_FILES["fileUpload1"]["name"] . "' alt='File 1' width='300' height='300'><br>";

        }

        if (file_exists($targetDir . $_POST["fileNameMid"] . "_" . $_FILES["fileUpload2"]["name"])) {
            echo "File 2:<br>";
            echo "<img src='" . $targetDir . $_POST["fileNameMid"] . "_" . $_FILES["fileUpload2"]["name"] . "' alt='File 2' width='300' height='300'><br>";
        }

        if (file_exists($targetDir . $_POST["fileNameMid"] . "_" . $_FILES["fileUpload3"]["name"])) {
            echo "File 3:<br>";
            echo "<img src='" . $targetDir . $_POST["fileNameMid"] . "_" . $_FILES["fileUpload3"]["name"] . "' alt='File 3' width='300' height='300'><br>";
        }

        if (file_exists($targetDir . $_POST["fileNameMid"] . "_" . $_FILES["fileUpload4"]["name"])) {
            echo "File 4:<br>";
            echo "<img src='" . $targetDir . $_POST["fileNameMid"] . "_" . $_FILES["fileUpload4"]["name"] . "' alt='File 4' width='300' height='300'><br>";
        }

        // You can add more processing logic or database operations here if needed

        echo "File 1: " . $message1 . "<br>";
        echo "File 2: " . $message2 . "<br>";
        echo "File 3: " . $message3 . "<br>";
        echo "File 4: " . $message4 . "<br>";
    }
?>