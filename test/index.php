<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="home.scss"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>

    <form id="searchForm" action="process.php" method="get">
        <div class="container">
            <header class="d-flex justify-content-center py-3">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Home</a></li>
                    <!-- <li class="nav-item"><a href="up_show_DB.php" class="nav-link">UP 2 DATABASE</a></li> -->
                    <li class="nav-item"><a href="map_select.php" class="nav-link ">Map View</a></li>
                    <li class="nav-item"><a href="admin_upload.php" class="nav-link ">UPLOAD</a></li>
                    <li class="nav-item"><a href="up_show_DB.php" class="nav-link ">UP 2 DATABASE</a></li>
                    <li class="nav-item"><a href="yolov8\wabcam.php" class="nav-link">Finding Room with Camera</a></li>
                    <li class="nav-item"><a href="mapapi.php" class="nav-link">MAP</a></li>
                    <!-- <li class="nav-item"><a href="page3.php" class="nav-link">page3</a></li> -->
                </ul>
            </header>
        </div>

        <div class="conPoint">
            <div class="conStart">
                <div class="start">
                    <h4>Start : </h4>
                    <input list="startList" name="start" id="startId" required>
                    <datalist id="startList">
                        <option value="test1"></option>
                        <?php generateDatalist("selectLo1"); ?>
                    </datalist>
                </div>
            </div>

            <div class="conTarget">
                <div class="target">
                    <h4>Target : </h4>
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
        function updateFloors() {
            var buildingDropdown = document.getElementById('BuildingId');
            var selectedBuilding = buildingDropdown.value;

            // Get the number of floors based on the selected building
            var buildings = <?php echo json_encode(Buildinglist("selectBuilding")); ?>;
            var selectedBuildingInfo = buildings.find(building => building.buildingname === selectedBuilding);

            // Update the floors dropdown
            var floorsInput = document.getElementById('FloorsId');
            var floorsDatalist = document.getElementById('FloorsList');
            floorsDatalist.innerHTML = '';  // Clear existing options

            if (selectedBuildingInfo) {
                for (var i = 1; i <= selectedBuildingInfo.floors; i++) {
                    var option = document.createElement('option');
                    option.value = i;
                    floorsDatalist.appendChild(option);
                }
            }
        }
    </script>

    <?php
    function generateDatalist($functionName)
    {

        $conn = new mysqli("localhost", "root", "", "indoor_db");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT roomname FROM room";
        $result = $conn->query($sql);

        // Check the query result
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value=\"" . $row["roomname"] . "\">" . $row["roomname"] . "</option>";
            }
        } else {
            echo "No data found.";
        }
        $conn->close();
    }

    function Buildinglist($functionName)
    {
        $conn = new mysqli("localhost", "root", "", "indoor_db");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT buildingname, floors FROM building";
        $result = $conn->query($sql);

        // Check the query result
        $buildings = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Store buildingname and floors in the $buildings array
                $buildings[] = array(
                    'buildingname' => $row["buildingname"],
                    'floors' => $row["floors"]
                );
            }
        }

        // Close the database connection
        $conn->close();

        // Return the array of buildings
        return $buildings;
    }

    ?>


</body>

</html>

<style lang="scss" :scope>
    body {
        background: #ddd;
        text-align: center;

    }

    .conPoint {
        background: #4682B4;



        .conStart {
            /* background: olive;
            display: inline-block; */

            h4 {
                display: inline-block;
            }

            input {
                border-radius: 5px;
                border: none;

            }
        }

        .conTarget {
            /* background: darkcyan;
            display: inline-block; */

            h4 {
                display: inline-block;
            }

            input {
                border-radius: 5px;
                border: none;
            }
        }
    }

    .map {
        margin: auto;
        background: #bbb;
        width: 80%;
        height: 30%;
        margin-bottom: 50px;
        margin-top: 50px;
        border-radius: 4px;
        text-align: center;

        area {
            &:hover {
                cursor: pointer;
            }
        }
    }

    .goGo {
        border: none;
        border-radius: 5px;
        background: rgb(7, 205, 175);
        height: 30px;
        width: 40px;
        margin: 10px;
    }
</style>