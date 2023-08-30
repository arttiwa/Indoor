<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Execute the Python script
    $output = shell_exec('python capture.py');
    echo $output;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form method="post" action="capture.php">
    <input type="submit" value="Open Camera">
</form>

</body>
</html>
