<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $targetDir = "uploads/"; // specify the directory where you want to store the uploaded files

        // Function to handle file upload and return an error message if unsuccessful
        function handleFileUpload($fileInputName, $targetDir, $pointName, $fileNameAll, $fileTag)
        {
            $oldFileName = $_FILES[$fileInputName]["name"];
            $extension = pathinfo($oldFileName, PATHINFO_EXTENSION);
            $fileNameMid = $_POST["fileNameMid"];
            $setFileNameAll = $_POST[$fileNameAll];

            // Modify the copy file name to include the specified tag
            $copyFileName = $fileNameMid . "_" . $setFileNameAll . "_" . $fileTag . "." . $extension;

            $newFileName = $fileNameMid . "_" . $setFileNameAll . "." . $extension;
            $file = $targetDir . $newFileName;
            $copyFile = $targetDir . $copyFileName;
            $uploadOk = 1;

            // Move the file to the specified directory
            if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $file)) {
                // Copy the file with a new name
                copy($file, $copyFile);

                return "File uploaded successfully. Old name: " . $oldFileName . ", New name: " . $newFileName . "<br>Copied as: " . $copyFileName;
            } else {
                return "Error uploading file.";
            }
        }

        // Function to generate combinations of tags for a given file
        function generateTagCombinations($fileNumber, $totalFiles)
        {
            $tags = ['T', 'L', 'R', 'B'];
            $combinations = [];

            for ($i = 0; $i < $totalFiles; $i++) {
                $tag = $tags[($fileNumber + $i) % count($tags)];
                $combinations[] = $tag;
            }

            return $combinations;
        }

        // Process File 1
        $pointName1 = $_POST["fileName1"];
        $combinations1 = generateTagCombinations(0, 4);
        $message1 = implode("<br>Copied as File 1: ", array_map(function ($tag) use ($pointName1, $targetDir) {
            return handleFileUpload("fileUpload1", $targetDir, $pointName1, "fileName1", $tag);
        }, $combinations1));

        // Process File 2
        $pointName2 = $_POST["fileName2"];
        $combinations2 = generateTagCombinations(1, 4);
        $message2 = implode("<br>Copied as File 2: ", array_map(function ($tag) use ($pointName2, $targetDir) {
            return handleFileUpload("fileUpload2", $targetDir, $pointName2, "fileName2", $tag);
        }, $combinations2));

        // Process File 3
        $pointName3 = $_POST["fileName3"];
        $combinations3 = generateTagCombinations(2, 4);
        $message3 = implode("<br>Copied as File 3: ", array_map(function ($tag) use ($pointName3, $targetDir) {
            return handleFileUpload("fileUpload3", $targetDir, $pointName3, "fileName3", $tag);
        }, $combinations3));

        // Process File 4
        $pointName4 = $_POST["fileName4"];
        $combinations4 = generateTagCombinations(3, 4);
        $message4 = implode("<br>Copied as File 4: ", array_map(function ($tag) use ($pointName4, $targetDir) {
            return handleFileUpload("fileUpload4", $targetDir, $pointName4, "fileName4", $tag);
        }, $combinations4));

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
