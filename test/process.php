<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css"> -->

    <script>
        function toggle() {
            // Use the PHP values in your JavaScript function
            console.log("Start: " + start);
            console.log("End: " + end);
        }

        let pointXY_f11_4 = {
            'F11_423': { 'X': 790, 'Y': 350 },
            'F11_423_F11_423': { 'X': 820, 'Y': 332 },

            'F11_422': { 'X': 790, 'Y': 350 },
            'F11_422_F11_422': { 'X': 765, 'Y': 313 },

            'F11_421': { 'X': 712, 'Y': 400 },
            'F11_421_F11_421': { 'X': 691, 'Y': 361 },

            'F11_421b': { 'X': 510, 'Y': 240 },
            'F11_421b_F11_421b': { 'X': 542, 'Y': 224 },

            'F11_420': { 'X': 591, 'Y': 373 },
            'F11_420_F11_420': { 'X': 557, 'Y': 378 },

            'F11_419': { 'X': 540, 'Y': 290 },
            'F11_419_F11_419': { 'X': 508, 'Y': 300 },

            'toilet_421': { 'X': 435, 'Y': 269 },
            'toilet_421_toilet_421': { 'X': 422, 'Y': 238 },

            'b1': { 'X': 650, 'Y': 440 },

            'elevatorF11_4M': { 'X': 658, 'Y': 590 },
            'elevatorF11_4M_elevatorF11_4M': { 'X': 595, 'Y': 546 },

            'c1': { 'X': 658, 'Y': 703 },

            'F11_401': { 'X': 658, 'Y': 786 },
            'F11_401_F11_401': { 'X': 702, 'Y': 776 },

            'F11_402': { 'X': 658, 'Y': 786 },
            'F11_402_F11_402': { 'X': 615, 'Y': 823 },

            'c2': { 'X': 372, 'Y': 703 },
            'c3': { 'X': 372, 'Y': 890 },           
            'c4': { 'X': 275, 'Y': 712 },
            'c9': { 'X': 658, 'Y': 946 },

            'StairF11_f4s': { 'X': 372, 'Y': 946 },

            'F11_407': { 'X': 300, 'Y': 889 },
            'F11_407_F11_407': { 'X': 300, 'Y': 913 },

            'F11_408': { 'X': 210, 'Y': 888 },
            'F11_408_F11_408': { 'X': 210, 'Y': 866 },

            'F11_409': { 'X': 151, 'Y': 888 },
            'F11_409_F11_409': { 'X': 151, 'Y': 913 },

            'F11_410': { 'X': 25, 'Y': 888 },
            'F11_410_F11_410': { 'X': 25, 'Y': 870 },

            'F11_411': { 'X': 25, 'Y': 888 },
            'F11_411_F11_411': { 'X': 25, 'Y': 915 },

            'F11_412': { 'X': 35, 'Y': 715 },
            'F11_412_F11_412': { 'X': 35, 'Y': 737 },

            'F11_413': { 'X': 35, 'Y': 715 },
            'F11_413_F11_413': { 'X': 35, 'Y': 691 },

            'F11_415': { 'X': 151, 'Y': 715 },
            'F11_415_F11_415': { 'X': 151, 'Y': 690 },

            'c5': { 'X': 276, 'Y': 424 },
            'b2': { 'X': 276, 'Y': 269 },
 
            'Pohmroom': { 'X': 120, 'Y': 347 },            
            'Pohmroom_Pohmroom': { 'X': 120, 'Y': 295 },            



        };

        // Call drawLines after the page has loaded
        window.onload = function () {
            let canvas = document.getElementById('mapCanvas');
            let mapImage = document.getElementById('mapImage');

            // Set canvas size based on the image dimensions
            canvas.width = mapImage.width;
            canvas.height = mapImage.height;

            drawLines();
        };
    </script>

</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link active" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="process.php" class="nav-link active" aria-current="page">ANS</a></li>

                <!-- <li class="nav-item"><a href="up_show_DB.php" class="nav-link">UP 2 DATABASE</a></li> -->
                <li class="nav-item"><a href="map_select.php" class="nav-link ">Map View</a></li>
                <li class="nav-item"><a href="admin_upload.php" class="nav-link ">UPLOAD</a></li>
                <li class="nav-item"><a href="up_show_DB.php" class="nav-link active">UP 2 DATABASE</a></li>
                <li class="nav-item"><a href="yolov8\wabcam.php" class="nav-link">Finding Room with Camera</a></li>
                <li class="nav-item"><a href="mapapi.php" class="nav-link">MAP</a></li>
                <!-- <li class="nav-item"><a href="page3.php" class="nav-link">page3</a></li> -->
            </ul>
        </header>
    </div>

    <div class="conResult">
        <div class="conStart">
            <div class="ResStart">
                <h1>your origin is "start"</h1>
            </div>
        </div>
        <div class="conDestination">
            <div class="ResDestination">
                <h1>your destination is "end"</h1>
            </div>
        </div>
    </div> <br>

    <button onclick="toggle()">show start end</button><br>

    <div class="conMap">
        <div class="map">
            <canvas id="mapCanvas" style="border: solid 1px; position: absolute; "></canvas>
            <img src="/Indoor/Map_for_indor/Map_F11_41.png" id="mapImage">
        </div>
    </div>







    <br><br>

    <?php
    session_start();
    include_once 'dbConfig.php';

    function dijkstra($graph, $start, $end)
    {
        $distances = array_fill_keys(array_keys($graph), PHP_INT_MAX);
        $distances[$start] = 0;
        $previous = array_fill_keys(array_keys($graph), null);
        $queue = array_keys($graph);

        while (!empty($queue)) {
            // Find the node with the smallest distance in the queue
            $minDistance = PHP_INT_MAX;
            $minNode = null;
            foreach ($queue as $node) {
                if ($distances[$node] < $minDistance) {
                    $minDistance = $distances[$node];
                    $minNode = $node;
                }
            }

            if ($minNode === $end) {
                break; // Found shortest path to end
            }

            // Remove the selected node from the queue
            $queue = array_diff($queue, [$minNode]);

            // Update distances and previous nodes for neighboring nodes
            foreach ($graph[$minNode] as $neighbor => $weight) {
                $alt = $distances[$minNode] + $weight;
                if ($alt < $distances[$neighbor]) {
                    $distances[$neighbor] = $alt;
                    $previous[$neighbor] = $minNode;
                }
            }
        }

        // Reconstruct the shortest path
        $path = [];
        $node = $end;
        while ($previous[$node] !== null) {
            array_unshift($path, $node);
            $node = $previous[$node];
        }
        array_unshift($path, $start);

        return $path;
    }

    $graph = [
        'elevatorF11_4M' => ['c1' => 4, 'b1' => 3],
        'c1' => ['elevatorF11_4M' => 4, 'F11_401' => 3, 'F11_402' => 3, 'c2' => 4],

        'F11_401' => ['c1' => 3, 'F11_402' => 1, 'c9' => 3],
        'F11_402' => ['c1' => 3, 'F11_401' => 1, 'c9' => 3],

        'c9' => ['F11_401' => 3,'F11_402' => 3, 'StairF11_f4s' => 2,'tois4' => 3],

        'StairF11_f4s' => ['c9' => 2, 'tois4' => 1, 'c3' => 2],
        'tois4' => [ 'StairF11_f4s' => 1, 'c3' => 2,'c9' => 3,],

        'c2' => ['c1' => 4, 'c3' => 4, 'c4' => 3],
        'c3' => ['tois4' => 2, 'c2' => 4, 'F11_407' => 2, 'F11_408' => 4],

        'F11_407' => ['c3' => 2, 'F11_408' => 1],
        'F11_408' => ['c3' => 4, 'F11_407' => 2, 'F11_409' => 2, 'F11_410' => 3, 'F11_411' => 2],

        'F11_409' => ['F11_408' => 2, 'F11_410' => 1, 'F11_411' => 1, 'F11_415' => 4],
        'F11_410' => ['F11_408' => 3, 'F11_409' => 1, 'F11_411' => 1],
        'F11_411' => ['F11_408' => 2, 'F11_409' => 1, 'F11_410' => 1],

        'c4' => ['c2' => 3, 'F11_413' => 2, 'F11_415' => 1, 'c5' => 5],

        'F11_412' => ['F11_413' => 1, 'F11_415' => 2],
        'F11_413' => ['c4' => 2, 'F11_412' => 1, 'F11_415' => 1],
        //'F11_414' => [ 'c4' => 1, 'F11_412' => 2, 'F11_413' => 1, 'F11_415' => 1 ],
        'F11_415' => ['c4' => 1, 'F11_412' => 2, 'F11_413' => 1, 'F11_409' => 4],

        'c5' => ['c4' => 5, 'L2' => 4, 'F11_414' => 2, 'b2' => 4],
        'L2' => ['c5' => 4, 'F11_414' => 1, 'Pohmroom' => 2, 'b2' => 4],

        'F11_414' => ['c5' => 2, 'L2' => 1],
        'Pohmroom' => ['L2' => 2, 'b2' => 3],

        'b2' => ['c5' => 4, 'L2' => 4, 'Pohmroom' => 3, 'toilet_421' => 2],
        'toilet_421' => ['b2' => 2, 'F11_421b' => 1],

        'F11_421b' => ['toilet_421' => 1, 'F11_421' => 7, 'F11_419' => 2],
        'F11_421' => ['F11_421b' => 7, 'F11_422' => 2, 'b1' => 1],
        'F11_419' => ['F11_421b' => 2, 'F11_420' => 1, 'b1' => 3],
        'F11_420' => ['F11_419' => 1, 'b1' => 2],
        'F11_422' => ['F11_421' => 2, 'F11_423' => 1],
        'F11_423' => [ 'F11_422' => 1],

        'b1' => [
            'elevatorF11_4M' => 3,
            'F11_421' => 1,
            'F11_420' => 2
        ],

        'A' => ['B' => 1, 'C' => 4],
        'B' => ['A' => 1, 'C' => 2, 'D' => 5],
        'C' => ['A' => 4, 'B' => 2, 'D' => 1],
        'D' => ['B' => 5, 'C' => 1]
    ];

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Get the start and end values from the URL parameters
        $start = $_GET["start"];
        $end = $_GET["end"];


        // Calculate the shortest path
        $shortestPath = dijkstra($graph, $start, $end);

        // Display the selected start and end points
        echo "You selected start point: " . $start . "<br>";
        echo "You selected end point: " . $end . "<br>";

        if ($shortestPath !== null) {
            $shortestArrayPath = $shortestPath;
            echo "Shortest path from $start to $end: " . implode(' -> ', $shortestPath);

            echo "<pre>";
            print_r($shortestArrayPath);
            echo "</pre>";

            // Encode the PHP array as JSON
            $pathWayJSON = json_encode($shortestArrayPath);


            // Fetch and display images related to the shortestArrayPath
            echo "<div class='row g-2'>";

            // แสดงรูปสำหรับ $start
            $imageURLStart = 'uploads/' . $start . '.jpg';
            echo "<div class='col-sm-6 col-lg-4 col-xl-3'>";
            echo "<div class='card shadow h-100'>";
            echo "<img src='$imageURLStart' alt='' width='100%' class='card-img'>";
            echo "</div>";
            echo "</div>";

            foreach ($shortestArrayPath as $point1) {
                $nextPointIndex = array_search($point1, $shortestArrayPath) + 1;
                if ($nextPointIndex < count($shortestArrayPath)) {
                    $point2 = $shortestArrayPath[$nextPointIndex];
                    // $fileName = $point1  ;ok can use 1 valiable
                    $fileName = $point1 . '-' . $point2;

                    // สร้าง query เพื่อค้นหารูปภาพโดยใช้ $fileName
                    //$query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName" . "b.jpg'");ok
                    $query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName.jpg'");

                    if ($query->num_rows > 0) {
                        while ($row = $query->fetch_assoc()) {
                            $imageURL = 'uploads/' . $row['file_name'];
                            echo "<div class='col-sm-6 col-lg-4 col-xl-3'>";
                            echo "<div class='card shadow h-100'>";
                            echo "<img src='$imageURL' alt='' width='100%' class='card-img'>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No image found for point: $fileName</p>";
                    }
                }
            }

            // แสดงรูปสำหรับ $end
            $imageURLEnd = 'uploads/' . $end . '.jpg';

            echo "<br><div class='col-sm-6 col-lg-4 col-xl-3'>";
            echo "<div class='card shadow h-100'>";
            echo "<img src='$imageURLEnd' alt='' width='100%' class='card-img'>";
            echo "</div>";
            echo "</div>";


        } else {
            echo "Sorry, there is no way to go from $start to $end. Please select somewhere closer to the target.";
        }
    }

    ?>

</body>

<script>
    var start = "<?php echo $start; ?>";
    var end = "<?php echo $end; ?>";
    var pathWay = <?php echo $pathWayJSON; ?>;
    console.log(pathWay);
    console.log(pathWay[pathWay.length - 1]);
    console.log(pathWay[pathWay.length - 1] + "_" + pathWay[pathWay.length - 1]);

    // Function to draw a square on the canvas
    function drawLines() {
        console.log("drawLines_function =-=-=-=");
        let canvas = document.getElementById('mapCanvas');
        let ctx = canvas.getContext('2d');

        const radius = 8;

        for (let index = 0; index < pathWay.length - 1; index++) {
            console.log(pathWay[index]);

            let x1 = pointXY_f11_4[pathWay[index]].X;
            let y1 = pointXY_f11_4[pathWay[index]].Y;
            let x2 = pointXY_f11_4[pathWay[index + 1]].X;
            let y2 = pointXY_f11_4[pathWay[index + 1]].Y;

            ctx.beginPath();
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.strokeStyle = 'white'; // Set the border color
            ctx.lineWidth = 8; // Set the border width
            ctx.stroke();

            // Draw line
            ctx.beginPath();
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.strokeStyle = 'blue';
            ctx.lineWidth = 5;
            ctx.stroke();

            // Draw circle at the start point
            if (index == 0) {
                ctx.beginPath();
                ctx.arc(x1, y1, radius, 0, 2 * Math.PI);
                ctx.fillStyle = "blue";
                ctx.fill();
                ctx.strokeStyle = "white";
                ctx.lineWidth = 3;
                ctx.stroke();
            }

        }


        let lastPoint = pathWay[pathWay.length - 1];
        let lastX = pointXY_f11_4[lastPoint].X;
        let lastY = pointXY_f11_4[lastPoint].Y;

        // Draw circle at the last point
        let lastPointReal = pathWay[pathWay.length - 1] + "_" + pathWay[pathWay.length - 1];
        let lastXReal = pointXY_f11_4[lastPointReal].X;
        let lastYReal = pointXY_f11_4[lastPointReal].Y;

        // Draw line
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(lastXReal, lastYReal);
        ctx.strokeStyle = 'white'; // Set the border color
        ctx.lineWidth = 8; // Set the border width
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(lastXReal, lastYReal);
        ctx.strokeStyle = 'blue';
        ctx.lineWidth = 5;
        ctx.stroke();


        ctx.beginPath();
        ctx.arc(lastXReal, lastYReal, radius, 0, 2 * Math.PI);
        ctx.fillStyle = "blue";
        ctx.fill();
        ctx.strokeStyle = "white";
        ctx.lineWidth = 3;
        ctx.stroke();
    }



</script>

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
        background: skyblue;
        width: 1000px;
        height: 30%;
        margin-bottom: 50px;
        margin-top: 50px;
        border-radius: 4px;
        text-align: center;
        padding: 10px;

        /* canvas {
            position: absolute;
            top: 0;
            left: 0;
            size: 20px;
        } */
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