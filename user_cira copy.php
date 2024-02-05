<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Table</title>
</head>

<body>
    <div class="conpage">
        <h2>Table Show Database</h2>
    </div>

    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "cira_db";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Assuming you want to display all rows from the 'car' table
    $sql = "SELECT * FROM car";

    $result = $conn->query($sql);

    if ($result === FALSE) {
        echo '<script>alert("Error: ' . $sql . '\\n' . $conn->error . '");</script>';
    } else {
        if ($result->num_rows > 0) {
            echo '<table border="1">';
            echo '<tr><th>ID</th><th>Name 1</th><th>Name 2</th><th>Date Timestamp</th></tr>';
            
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['name1'] . '</td>';
                echo '<td>' . $row['name2'] . '</td>';
                echo '<td>' . $row['datetimestamp'] . '</td>';
                echo '</tr>';
            }
            
            echo '</table>';
        } else {
            echo '<p>No records found</p>';
        }
    }

    $conn->close();
    ?>

</body>

</html>

<style>
    /* Your existing CSS styles */
</style>
