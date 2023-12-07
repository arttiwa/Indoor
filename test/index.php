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

    <form id="searchForm" action="process.php" method="get">
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

        <!-- <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Enter the Code</h2>
                <input type="text" id="codeInput" placeholder="Enter code">
                <button id="submitButton">Submit</button>
            </div>
        </div> -->

        <div class="conPoint">
            <div class="conStart">
                <div class="start">
                    <input list="startList" name="start" id="startId" required>
                    <datalist id="startList">
                        <option value="test1"></option>
                        <?php generateDatalist("selectLo1"); ?>
                    </datalist>
                </div>
            </div>

            <div class="conTarget">
                <div class="target">
                    <input list="targetList" name="end" id="endId" required>
                    <datalist id="targetList">
                        <option value="test2"></option>
                        <?php generateDatalist("selectLo2"); ?>
                    </datalist>
                </div>
            </div>
        </div>

        <button type="submit" class="goGo"><i class="fa fa-search"></i></button>
    </form>



    <script>
        function selectLo1(start) {
            document.getElementById("startList").classList.toggle("show");
            document.getElementById("startId").value = start;
        }

        function selectLo2(end) {
            document.getElementById("targetList").classList.toggle("show");
            document.getElementById("endId").value = end;
        }

        function toProcess() {
            // Redirect to process.php with URL parameters
            var start = document.getElementById("startId").value;
            var end = document.getElementById("endId").value;
            window.location.href = "process.php?start=" + encodeURIComponent(start) + "&end=" + encodeURIComponent(end);
        }


        // // When the user clicks the submit button, check the code
        // submitButton.addEventListener("click", function () {
        //     var enteredCode = codeInput.value;

        //     // Send an AJAX request to your PHP script for code validation
        //     var xhr = new XMLHttpRequest();
        //     xhr.open("POST", "validate_code.php", true);
        //     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        //     xhr.onreadystatechange = function () {
        //         if (xhr.readyState === 4 && xhr.status === 200) {
        //             var response = xhr.responseText;

        //             if (response === "valid") {
        //                 alert("Code is correct. Proceed with the action.");
        //                 modal.style.display = "none";
        //             } else {
        //                 alert("Invalid code. Please try again.");
        //             }
        //         }
        //     };

        //     // Send the entered code to the PHP script
        //     xhr.send("code=" + encodeURIComponent(enteredCode));
        // });

        // // Get the modal element
        // var modal = document.getElementById("myModal");

        // // Get the link element for "UPLOAD PICTURE TO DATABASE"
        // var uploadLink = document.querySelector(".nav-item a[href='beindex.php']");

        // // Get the close button element
        // var closeButton = document.querySelector(".close");

        // // Get the submit button element
        // var submitButton = document.getElementById("submitButton");

        // // Get the code input field
        // var codeInput = document.getElementById("codeInput");

        // // When the user clicks the link, show the modal
        // uploadLink.addEventListener("click", function () {
        //     modal.style.display = "block";
        // });

        // // When the user clicks the close button, hide the modal
        // closeButton.addEventListener("click", function () {
        //     modal.style.display = "none";
        // });

        // // When the user clicks the submit button, check the code
        // submitButton.addEventListener("click", function () {
        //     var enteredCode = codeInput.value;
        //     // Check the entered code here, and take appropriate action
        //     // For example, you can compare it to a predefined code
        //     if (enteredCode === "your-secret-code") {
        //         alert("Code is correct. Proceed with the action.");
        //         modal.style.display = "none";
        //     } else {
        //         alert("Invalid code. Please try again.");
        //     }
        // });

    </script>



    <?php
    function generateDatalist($functionName) {
        // Establish a database connection
        $conn = new mysqli("localhost", "root", "", "indoor_db");

        // Check the connection
        if($conn->connect_error) {
            die("Connection failed: ".$conn->connect_error);
        }

        // Create a query to fetch data from the database
        $sql = "SELECT roomname FROM room";
        $result = $conn->query($sql);

        // Check the query result
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value=\"".$row["roomname"]."\">".$row["roomname"]."</option>";
            }
        } else {
            echo "No data found."; // Add this line to check if data is being retrieved.
        }
        // Close the database connection
        $conn->close();
    }
    ?>
</body>

</html>