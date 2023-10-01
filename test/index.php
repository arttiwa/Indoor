<!DOCTYPE html>
<html>
<style>
    /* สไตล์สำหรับ Dropdown */
    .dropdown {
    position: relative;
    display: inline-block;
    }

    .dropbtn {
    background-color: #3498DB;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
    }

    .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    }

    .dropdown-content a {
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    }

    .dropdown-content a:hover {
    background-color: #ddd;
    }

    /* สไตล์สำหรับ input ค้นหา */
    #myInput {
    border-box: box-sizing;
    background-image: url('searchicon.png');
    background-position: 14px 12px;
    background-repeat: no-repeat;
    font-size: 16px;
    padding: 14px 20px 12px 45px;
    border: none;
    border-bottom: 1px solid #ddd;
    }

    /* เมื่อ hover ที่ input ค้นหา */
    #myInput:hover {
    border-bottom: 1px solid #3498DB;
    }

    /* แสดงผลใน Dropdown หากตรงกับคำค้นหา */
    .show {
    display: block;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>

    <div class="container">
        <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Home</a></li>
            <li class="nav-item"><a href="beindex.php" class="nav-link">UPDATE PICTURE</a></li>
            <li class="nav-item"><a href="capture.php" class="nav-link">USE CAM FOR FIND ROOM </a></li>
            <!-- <li class="nav-item"><a href="#" class="nav-link">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link">About</a></li> -->
        </ul>
        </header>
    </div>

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
        
<!-- start - end  -->
<div class="container">
    <header class="d-flex justify-content-center py-3">
        <h2>Select a start and an end:</h2>
    </header>

    
    <div class="d-flex justify-content-center py-3">
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
        </div>

        <div class="d-flex justify-content-center py-3">
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
            <input type="submit" value="Find Shortest Path" class="btn btn-primary">
            
        </form>
    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</div>



<!-- <header class="py-3 mb-3 border-bottom">
    <div class="d-flex justify-content-center py-3">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center col-lg-4 mb-2 mb-lg-0 link-dark text-decoration-none dropdown-toggle" id="dropdownNavLink" data-bs-toggle="dropdown" aria-expanded="false">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownNavLink">
            <li><a class="dropdown-item active" href="#" aria-current="page">Overview</a></li>
            <li><a class="dropdown-item" href="#">Inventory</a></li>
            <li><a class="dropdown-item" href="#">Customers</a></li>
            <li><a class="dropdown-item" href="#">Products</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Reports</a></li>
            <li><a class="dropdown-item" href="#">Analytics</a></li>
            </ul> 
        </div>

        <div class="d-flex align-items-center">
            <form class="w-100 me-3">
            <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
            </form>
            <input type="submit" value="Search" class="btn btn-primary">
            <div class="flex-shrink-0 dropdown">
            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
            </div>
        </div>
        </div>
</header> -->

</body>
</html>
