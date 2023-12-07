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
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="home.scss"> -->
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ?php
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
    ? -->

    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="beindex.php" class="nav-link">UPLOAD PICTURE TO DATABASE</a></li>
                <li class="nav-item"><a href="capture.php" class="nav-link">USE CAM FOR FINDING ROOM </a></li>
                <li class="nav-item"><a href="maptest.php" class="nav-link">MAP</a></li>
            <!-- <li class="nav-item"><a href="#" class="nav-link">About</a></li> -->
            </ul>
        </header>
    </div>

    <header class="d-flex justify-content-start py-3">

        <div class="dropdown">

            <button onclick="myFunction1()" class="dropbtn">Please select your current location</button>
            <div id="myDropdown1" class="dropdown-content">

                <label for="start">Start:</label>
                <input type="text" placeholder="Search.." id="start" onkeyup="filterFunction1()" name="start">
                    <?php
                        // ติดต่อกับฐานข้อมูล
                        $conn = new mysqli("localhost", "root", "", "indoor_db");

                        // ตรวจสอบการเชื่อมต่อ
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // สร้าง query เพื่อดึงข้อมูลจากฐานข้อมูล
                        $sql = "SELECT roomname FROM room";
                        $result = $conn->query($sql);

                        // ตรวจสอบผลลัพธ์
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='#' onclick='selectLocation1(\"" . $row["roomname"] . "\")'>" . $row["roomname"] . "</a>";
                            }
                        }

                        // ปิดการเชื่อมต่อกับฐานข้อมูล
                        $conn->close();
                    ?>

            </div>

        </div>

        <script>
            // เมื่อคลิกที่ปุ่ม Dropdown
            function myFunction1() {

                document.getElementById("myDropdown1").classList.toggle("show");
            }

            // ค้นหาตัวเลือกใน Dropdown
            function filterFunction1() {
                var input, filter, ul, li, a, i;
                input = document.getElementById("start");
                filter = input.value.toUpperCase();
                div = document.getElementById("myDropdown1");
                a = div.getElementsByTagName("a");
                for (i = 0; i < a.length; i++) {
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                    } else {
                        a[i].style.display = "none";
                    }
                }
            }

            // เมื่อคลิกที่ตัวเลือกใน Dropdown
            function selectLocation1($start) {
                document.getElementById("myDropdown1").classList.toggle("show");
                document.getElementById("start").value = $start;
            }
        </script>


        ------------------------

        <div class="dropdown">
            <button onclick="myFunction2()" class="dropbtn" id="toggle-linear">Please select your target
                location</button>
            <div id="myDropdown2" class="dropdown-content">

                <form method="post" action="process.php">

                    <input type="text" placeholder="Search.." id="end" onkeyup="filterFunction2()" name="end">

                    <?php
                    // ติดต่อกับฐานข้อมูล
                    $conn = new mysqli("localhost", "root", "", "indoor_db");

                    // ตรวจสอบการเชื่อมต่อ
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // สร้าง query เพื่อดึงข้อมูลจากฐานข้อมูล
                    $sql = "SELECT roomname FROM room";
                    $result = $conn->query($sql);

                    // ตรวจสอบผลลัพธ์
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<a href='#' onclick='selectLocation2(\"" . $row["roomname"] . "\")'>" . $row["roomname"] . "</a>";
                        }
                    }

                    // ปิดการเชื่อมต่อกับฐานข้อมูล
                    $conn->close();
                    ?>
            </div>
        </div>

        <script>
            // เมื่อคลิกที่ปุ่ม Dropdown
            function myFunction2() {
                document.getElementById("myDropdown2").classList.toggle("show");
            }

            // ค้นหาตัวเลือกใน Dropdown
            function filterFunction2() {
                var input, filter, ul, li, a, i;
                input = document.getElementById("end");
                filter = input.value.toUpperCase();
                div = document.getElementById("myDropdown2");
                a = div.getElementsByTagName("a");
                for (i = 0; i < a.length; i++) {
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                    } else {
                        a[i].style.display = "none";
                    }
                }
            }

            // เมื่อคลิกที่ตัวเลือกใน Dropdown
            function selectLocation2($end) {
                document.getElementById("myDropdown2").classList.toggle("show");
                document.getElementById("end").value = $end;
            }


        </script>


        *----------------*


        <input type="submit" value="Find Shortest Path" class="btn btn-primary">
        </form>
        ------------

    </header>

</body>

</html>