<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    // Database connection setup
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "indoor_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve data from the database
    $sql = "SELECT roomname FROM room";
    $result = $conn->query($sql);
    ?>

    <h1>Select a start and an end:</h1>
    <form method="post" action="process.php">
         <label for="start">Start:</label>
    <select name="start" id="start">
            <?php
            // Loop through the query result and create options in the select
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["roomname"] . "'>" . $row["roomname"] . "</option>";
                }
            }
            ?>
        </select>

        <label for="end">End:</label>
        <select name="end" id="end">
            <?php
            // Reset the data pointer for the second select
            $result->data_seek(0);

            // Loop through the query result and create options in the select
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["roomname"] . "'>" . $row["roomname"] . "</option>";
                }
            }
            ?>
        </select>
        <input type="submit" value="Find Shortest Path">
    </form>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
            