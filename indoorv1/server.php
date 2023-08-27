<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "indoor_db";

    //creat connect
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        # check conn
        die("Connection failed". mysqli_connect_error());
    }// else {
    //     echo "Connection Successfully";
    // }
?>