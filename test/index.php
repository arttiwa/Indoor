<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="home.scss">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>

<form id="searchForm" action="process.php" method="post">
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="beindex.php" class="nav-link">UPLOAD PICTURE TO DATABASE</a></li>
                <li class="nav-item"><a href="capture.php" class="nav-link">USE CAM FOR FINDING ROOM </a></li>
                <li class="nav-item"><a href="maptest.php" class="nav-link">MAP</a></li>
                <li class="nav-item"><a href="page3.php" class="nav-link">page3</a></li>
            </ul>
        </header>
    </div>

    <div class="conPoint">

        <div class="conStart">
            <div class="start">
                <input list="startList" name="startN" id="startId">

                <datalist id="startList">
                    <option value="test1"></option>
                    <?php generateDatalist("selectLo1"); ?>

                </datalist>

            </div>
        </div>


        <div class="conTarget">
            <div class="target">
                <input list="targetList" name="endN" id="endId">

                <datalist id="targetList">
                    <option value="test2"></option>
                    <?php generateDatalist("selectLo2"); ?>

                </datalist>

            </div>
        </div>
    </div>

    <button type="submit" class="goGo" onclick="toProcess()" ><i class="fa fa-search"></i></button>
</form>
</body>
<script>
    function selectLo1($start) {
        document.getElementById("startList").classList.toggle("show");
        document.getElementById("startId").value = $start;
    }

    function selectLo2($end) {
        document.getElementById("targetList").classList.toggle("show");
        document.getElementById("endId").value = $end;
    }

    function toProcess() {
    var $start = document.getElementById("startId").value;
    var $end = document.getElementById("endId").value;
    
    // Redirect to page2.php with URL parameters
    window.location.href = "process.php?start=" + encodeURIComponent($start) + "&end=" + encodeURIComponent($end);

    form.submit();
}


</script>


<?php
function generateDatalist($functionName)
{
    // Establish a database connection
    $conn = new mysqli("localhost", "root", "", "indoor_db");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create a query to fetch data from the database
    $sql = "SELECT roomname FROM room";
    $result = $conn->query($sql);

    // Check the query result
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value=\"" . $row["roomname"] . "\">" . $row["roomname"] . "</option>";
        }
    } else {
        echo "No data found."; // Add this line to check if data is being retrieved.
    }
    // Close the database connection
    $conn->close();
}
?>

</html>