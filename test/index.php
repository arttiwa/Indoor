<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <?php include('sidebar.html'); ?>

    <div id="main">
        <form id="searchForm" action="process.php" method="get" class="container">
            <header class="d-flex justify-content-center py-3">
                <div class="conPoint">
                    <div class="conStart">
                        <div class="start">
                            <label for="startId" style="display: inline-block; width: 60px; text-align: right;">Start :</label>
                            <input list="startList" name="start" id="startId" required>
                            <datalist id="startList">
                                <?php generateDatalist("selectLo1"); ?>
                            </datalist>
                        </div>
                    </div>

                    <div class="conTarget">
                        <div class="target">
                            <label for="endId" style="display: inline-block; width: 60px; text-align: right;">Destination:</label>
                            <input list="targetList" name="end" id="endId" required>
                            <datalist id="targetList">
                                <?php generateDatalist("selectLo2"); ?>
                            </datalist>
                        </div>
                    </div>
                </div>

            </header>
            <button type="submit" class="goGo"><i class="fa fa-search"> Search</i></button>

        </form>
    </div>

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

<style>
    body {
        /* background: #555; */
        text-align: center;
        background-image: url("./1111111.png");
        /* filter: brightness(100%); */
    }

    .conPoint {
        margin-top: 100px;
        display: flex;
        background: #4682B4;
        padding: 10px;
        border-radius: 10px;

        .conStart,
        .conTarget {
            flex: 1;
            margin: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;

            h4 {
                margin-bottom: 5px;
            }

            input {
                border-radius: 5px;
                border: none;
                padding: 5px;
                width: 100%;
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
        border: 1px solid;
        border-radius: 5px;
        background: rgb(7, 205, 175);
        height: 40px;
        width: 80px;
        margin: 10px;
        margin-left: 30%;
    }
</style>

</html>