<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finding Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="/indoor/test/index.php" class="nav-link" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="/indoor/test/beindex.php" class="nav-link">UPLOAD PICTURE TO DATABASE</a></li>
                <li class="nav-item"><a href="/indoor/test/yolov8/wabcam.php" class="nav-link active">USE CAM FOR FINDING ROOM</a></li>
                <li class="nav-item"><a href="/indoor/test/maptest.php"  class="nav-link">MAP</a></li>
                <li class="nav-item"><a href="/indoor/test/page3.php"  class="nav-link">page3</a></li>
            </ul>
        </header>
    </div>
    
    <div class="d-flex justify-content-center py-3">
        <form method="post" action="wabcam.php">
        <br/>
            <input type="submit" value="Open Camera" class="btn btn-primary">
            <br/>
            <br/>
        </form>
    </div>
    <div class="pre_output">
        <h1>Now you stay at . . . </h1>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Execute the Python script and capture the output
    $output = shell_exec('python D:/xampp/htdocs/Indoor/test/yolov8/detect_sign.py 2>&1');
    
    // Check if there is any output
    if (!empty($output)) {
        echo "<pre>$output</pre>";
    } else {
        echo "Error executing the Python script.";
    }
}
?>
<style lang="scss">
    .pre_output{
        background: wheat;
        margin: auto;
        width: 80%;

        pre {
            background: rosybrown;
        },
    }
</style>