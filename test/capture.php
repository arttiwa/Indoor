<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">    

    <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="beindex.php" class="nav-link ">UPLOAD PICTURE TO DATABASE</a></li>
                <li class="nav-item"><a href="capture.php" class="nav-link active">USE CAM FOR FINDING ROOM </a></li>
                <li class="nav-item"><a href="maptest.php" class="nav-link">MAP</a></li>
                <li class="nav-item"><a href="page3.php" class="nav-link">page3</a></li>
            </ul>
        </header>
    </div>

    <div class="d-flex justify-content-center py-3">
        <form method="post" action="capture.php">
        <br/>
            <input type="submit" value="Open Camera" class="btn btn-primary">
            <br/>
            <br/>
        </form>

</body>

</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Execute the Python script
    $output = shell_exec('python capture.py');
    echo $output;
}
?>