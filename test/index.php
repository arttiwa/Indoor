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










    <div class="conMap">
        <div class="map">
            <img src="/Indoor/Map_for_indor/Map_F11_4.png" usemap="#Map_F11_4" alt="Indoor Map" />

            <map name="Map_F11_4">
                <area shape="rect" coords="5,211,155,295" title="Ractangle" href="youtube">
                <area shape="rect" coords="5,294,85,408" title="Ractangle" href="">

                <area shape="rect" coords="4,441,117,576" title="Ractangle" href="">
                <area shape="rect" coords="120,441,237,576" title="Ractangle" href="">

                <area shape="rect" coords="4,575,119,688" title="Ractangle" href="">
                <area shape="rect" coords="4,746,121,802" title="Ractangle" href="">
                <area shape="rect" coords="4,746,121,802" title="Ractangle" href="">
                <area shape="rect" coords="179,736,344,867" title="Ractangle" href="">
                <area shape="rect" coords="3,911,110,1052" title="Ractangle" href="">
                <area shape="rect" coords="112,912,235,1049" title="Ractangle" href="">
                <area shape="rect" coords="234,912,344,1050" title="Ractangle" href="">

                <area shape="rect" coords="393,972,504,1048" title="Ractangle" href="">
                <area shape="rect" coords="506,973,617,1047" title="Ractangle" href="">

                <area shape="rect" coords="401,739,616,911" title="Ractangle" href="">
                
                <area shape="rect" coords="702,660,924,821" title="Ractangle" href="">
                <area shape="rect" coords="702,823,924,915" title="Ractangle" href="">
                <area shape="rect" coords="703,915,924,1047" title="Ractangle" href="">

                <area shape="poly" coords="357,213,410,212,461,181,481,210,427,245,357,245" title="" href="">
                <area shape="poly" coords="393,323,486,266,534,344,442,399" title="" href="">
                <area shape="poly" coords="442,401,535,345,585,420,491,478" title="" href="">
                <area shape="poly" coords="503,503,598,445,643,518,550,575" title="" href="">

                <area shape="poly" coords="533,211,605,163,722,341,647,389" title="" href="">
                <area shape="poly" coords="608,161,685,113,795,293,720,340" title="" href="">
                <area shape="poly" coords="654,63,753,-1,941,302,842,366" title="" href="">

                <area shape="poly" coords="500,157,551,125,581,178,533,206" title="" href="">
                <area shape="poly" coords="549,126,601,92,634,143,581,175" title="" href="">
                <area shape="poly" coords="604,92,652,62,682,113,636,139" title="" href="">
            </map>

        </div>




    </div>
</body>

</html>