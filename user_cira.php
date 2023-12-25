<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>


</head>

<body>
    <div class="conpage">
        <h2>Add User for Cira Project</h2>
        <form action="" method="post">
            <label for="username">Name:</label>
            <input type="text" name="username" required>
            <br/>

            <label for="email">Other:</label>
            <input class="other" type="text" name="email" required>
            <br/>
            <button type="submit">Add User</button>
        </form>
    </div>
    <?php
    // Database connection parameters
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "cira_db";

    // Create a connection to the database
    $conn = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Process the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve user input
        $username = $_POST["username"];
        $other = $_POST["email"];
    
        // Insert the user into the database
        $sql = "INSERT INTO users (username, other) VALUES ('$username', '$other')";
    
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("User added successfully!");</script>';
            
            // Redirect to another page after successful form submission
            header("Location: success.php");
            exit();  // Ensure that no more PHP code is executed after the header
        } else {
            echo '<script>alert("Error: ' . $sql . '\\n' . $conn->error . '");</script>';
        }
    }

    // Close the database connection
    $conn->close();
    ?>

</body>

</html>

<style>
    
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 20px;
        text-align: center;
        background: #778899;

    }

    .conpage{
        padding: 20px;
        font-family: Arial, sans-serif;
        background: #b0c4de;
        border-radius: 20px;
        margin: auto;
        margin-top: 10%; 

        width: 50%;
    }

    h2 {
        color: #333;
    }

    label {
        display: inline;
        margin: 10px 0;
        font-weight: bold;
    }

    input {
        width: 30%;
        padding: 8px;
        margin: 5px 0 20px;
        box-sizing: border-box;
    }


    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    .success {
        color: green;
    }

    .error {
        color: red;
    }
</style>