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

    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link " aria-current="page">Home</a></li>
                <!-- <li class="nav-item"><a href="up_show_DB.php" class="nav-link">UP 2 DATABASE</a></li> -->
                <li class="nav-item"><a href="map_select.php" class="nav-link active">Map View</a></li>
                <li class="nav-item"><a href="admin_upload.php" class="nav-link ">UPLOAD</a></li>
                <li class="nav-item"><a href="yolov8\wabcam.php" class="nav-link">Finding Room with Camera</a></li>
                <li class="nav-item"><a href="mapapi.php" class="nav-link">MAP</a></li>
                <!-- <li class="nav-item"><a href="page3.php" class="nav-link">page3</a></li> -->
            </ul>
        </header>
    </div>


    <div class="conBuild">
        <div class="Building">
            <div class="conFloors">
                <div class="floors">
                    <h4>Building : </h4>
                    <select id="BuildingId" onchange="updateFloors()">
                        <?php
                        $buildings = Buildinglist("selectBuilding");
                        foreach ($buildings as $building) {
                            echo "<option value=\"" . $building['buildingname'] . "\">" . $building['buildingname'] . "</option>";
                        }
                        ?>
                    </select>

                    <h4>Floors : </h4>
                    <input list="FloorsList" name="Floors" id="FloorsId" required>
                    <datalist id="FloorsList"></datalist>

                    <br>
                    <br>
                    <button type="submit" onclick="changeMap()">Search Floor Map</button>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <button type="submit" onclick="toggleVisibility()">Toggle Map</button>
    <br><br>


    <div class="conMap" id="map_toggle">
        <div class="map">
            <img src="" usemap="#Map_F11_4" alt="Indoor Map" id="mapImage">
            <map name="Map_F11_4" id="imageMap">
                <area shape="rect" coords="4,213,154,293" title="P'Ohm">
                <area shape="rect" coords="5,294,85,408" title="Elevator">

                <area shape="rect" coords="4,441,117,576" title="PneuLap">
                <area shape="rect" coords="120,441,237,576" title="Th">

                <area shape="rect" coords="4,575,119,688" title="413">
                <area shape="rect" coords="120,576,237,688" title="415">


                <area shape="rect" coords="4,746,121,802" title="412">
                <area shape="rect" coords="4,807,119,866" title="410">

                <area shape="rect" coords="179,736,344,867" title="408">

                <area shape="rect" coords="3,911,110,1052" title="411">
                <area shape="rect" coords="112,912,235,1049" title="409">
                <area shape="rect" coords="234,912,344,1050" title="407">

                <area shape="rect" coords="393,972,504,1048" title="WC">
                <area shape="rect" coords="506,973,617,1047" title="Stair">

                <area shape="rect" coords="401,739,616,911" title="402">

                <area shape="rect" coords="702,660,924,821" title="401">
                <area shape="rect" coords="702,823,924,915" title="Th">
                <area shape="rect" coords="703,915,924,1047" title="Lab">

                <area shape="poly" coords="357,213,410,212,461,181,481,210,427,245,357,245" title="Stair & WC">
                <area shape="poly" coords="393,323,486,266,534,344,442,399" title="419">
                <area shape="poly" coords="442,401,535,345,585,420,491,478" title="420">
                <area shape="poly" coords="503,503,598,445,643,518,550,575" title="Elavator">

                <area shape="poly" coords="533,211,605,163,722,341,647,389" title="421">
                <area shape="poly" coords="608,161,685,113,795,293,720,340" title="422">
                <area shape="poly" coords="654,63,753,-1,941,302,842,366" title="423">

                <area shape="poly" coords="500,157,551,125,581,178,533,206" title="W">
                <area shape="poly" coords="549,126,601,92,634,143,581,175" title="H">
                <area shape="poly" coords="604,92,652,62,682,113,636,139" title="S">


                <!-- <area shape="poly" coords="604,92,652,62,682,113,636,139" title="S" href=""> -->
            </map>
        </div>
    </div>


    <script>
        function changeMap() {
            let buildingId = document.getElementById("BuildingId").value
            let floorsId = document.getElementById("FloorsId").value
            let newMapSource = ""

            console.log("buildingId")
            console.log(buildingId)
            console.log("floorsId")
            console.log(floorsId)

            if (buildingId == "F11 -- อาคารสิรินธรวิศวพัฒน์" && floorsId == 4) {
                console.log("Building and floors match");
                newMapSource = "Map_F11_41.png"

            } else if (buildingId == "F11 -- อาคารสิรินธรวิศวพัฒน์" && floorsId == 3) {
                console.log("Building and floors match");
                newMapSource = "Map_F11_3.png"

            } else if (buildingId == "F11 -- อาคารสิรินธรวิศวพัฒน์" && floorsId == 2) {
                console.log("Building and floors match");
                newMapSource = "Map_F11_2.png"

            } else if (buildingId == "F11 -- อาคารสิรินธรวิศวพัฒน์" && floorsId == 1) {
                console.log("Building and floors match");
                newMapSource = "Map_F11_1.png"

            }

            //change img
            var element = document.getElementById('mapImage');
            element.src = '/Indoor/Map_for_indor/' + newMapSource;
        }

        function toggleVisibility() {
            var element = document.getElementById('map_toggle');

            // Check the current visibility state
            if (element.style.display === 'none' || element.style.display === '') {
                // If hidden, make it visible
                element.style.display = 'block';
            } else {
                // If visible, make it hidden
                element.style.display = 'none';
            }
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

        document.addEventListener('DOMContentLoaded', function () {
            // Get the map image and the map areas
            var mapImage = document.getElementById('mapImage');
            var imageMap = document.getElementById('imageMap');

            imageMap.addEventListener('click', function (event) {
                // Get the clicked area
                var clickedArea = event.target;

                // Check if the clicked element is an area
                if (clickedArea.tagName.toLowerCase() === 'area') {
                    // Get the title attribute of the clicked area
                    var roomTitle = clickedArea.getAttribute('title');

                    // Display the room value
                    var outputElement = document.getElementById('output');
                    outputElement.innerHTML = 'Clicked Room: ' + roomTitle;

                    // You can also save the roomTitle variable or perform other actions here
                    console.log('Clicked Room:', roomTitle);
                }
            });
        });
    </script>

    <?php
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