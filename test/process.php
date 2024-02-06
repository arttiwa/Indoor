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
            'F11_423': { 'X': 792, 'Y': 348 },
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
    <?php include('sidebar.html');
    session_start();

    $up = 0;
    $holdState = "";

    $pointXY_f11_4 = [
        'F11_423' => ['X' => 792, 'Y' => 348],
        'F11_423_F11_423' => ['X' => 820, 'Y' => 332],

        'F11_422' => ['X' => 790, 'Y' => 350],
        'F11_422_F11_422' => ['X' => 765, 'Y' => 313],

        'F11_421' => ['X' => 712, 'Y' => 400],
        'F11_421_F11_421' => ['X' => 691, 'Y' => 361],

        'F11_421b' => ['X' => 510, 'Y' => 240],
        'F11_421b_F11_421b' => ['X' => 542, 'Y' => 224],

        'F11_420' => ['X' => 591, 'Y' => 373],
        'F11_420_F11_420' => ['X' => 557, 'Y' => 378],

        'F11_419' => ['X' => 540, 'Y' => 290],
        'F11_419_F11_419' => ['X' => 508, 'Y' => 300],

        'toilet_421' => ['X' => 435, 'Y' => 269],
        'toilet_421_toilet_421' => ['X' => 422, 'Y' => 238],

        'b1' => ['X' => 650, 'Y' => 440],

        'elevatorF11_4M' => ['X' => 658, 'Y' => 590],
        'elevatorF11_4M_elevatorF11_4M' => ['X' => 595, 'Y' => 546],

        'c1' => ['X' => 658, 'Y' => 712],

        'F11_401' => ['X' => 658, 'Y' => 786],
        'F11_401_F11_401' => ['X' => 702, 'Y' => 776],

        'F11_402' => ['X' => 658, 'Y' => 786],
        'F11_402_F11_402' => ['X' => 615, 'Y' => 823],

        'c2' => ['X' => 372, 'Y' => 712],
        'c3' => ['X' => 372, 'Y' => 890],
        'c4' => ['X' => 275, 'Y' => 712],
        'c9' => ['X' => 658, 'Y' => 946],

        'StairF11_f4s' => ['X' => 375, 'Y' => 946],

        'F11_407' => ['X' => 300, 'Y' => 889],
        'F11_407_F11_407' => ['X' => 300, 'Y' => 913],

        'F11_408' => ['X' => 210, 'Y' => 888],
        'F11_408_F11_408' => ['X' => 210, 'Y' => 866],

        'F11_409' => ['X' => 151, 'Y' => 888],
        'F11_409_F11_409' => ['X' => 151, 'Y' => 913],

        'F11_410' => ['X' => 25, 'Y' => 888],
        'F11_410_F11_410' => ['X' => 25, 'Y' => 870],

        'F11_411' => ['X' => 25, 'Y' => 888],
        'F11_411_F11_411' => ['X' => 25, 'Y' => 915],

        'F11_412' => ['X' => 30, 'Y' => 712],
        'F11_412_F11_412' => ['X' => 35, 'Y' => 737],

        'F11_413' => ['X' => 35, 'Y' => 712],
        'F11_413_F11_413' => ['X' => 35, 'Y' => 691],

        // 'F11_414' => ['X' => 35, 'Y' => 691],
        // 'L2' => ['X' => 35, 'Y' => 691],
    
        'F11_415' => ['X' => 151, 'Y' => 712],
        'F11_415_F11_415' => ['X' => 151, 'Y' => 690],

        'c5' => ['X' => 276, 'Y' => 424],
        'b2' => ['X' => 276, 'Y' => 269],

        'Pohmroom' => ['X' => 120, 'Y' => 347],
        'Pohmroom_Pohmroom' => ['X' => 120, 'Y' => 295],
    ];

    ?>

    <div id="main">

        <div class="conResult">

            <!-- <div class="conStart">
                <div class="ResStart">
                    <h1>your origin is "start"</h1>
                </div>
            </div>
            <div class="conDestination">
                <div class="ResDestination">
                    <h1>your destination is "end"</h1>
                </div>
            </div> -->

            <?php
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

            // function dijkstraWithDirections($graph, $start, $end, $pointXY_f11_4)
            // {
            //     $distances = array_fill_keys(array_keys($graph), PHP_INT_MAX);
            //     $distances[$start] = 0;
            //     $previous = array_fill_keys(array_keys($graph), null);
            //     $directions = array_fill_keys(array_keys($graph), null);
            //     $queue = array_keys($graph);
            
            //     while (!empty($queue)) {
            //         // Find the node with the smallest distance in the queue
            //         $minDistance = PHP_INT_MAX;
            //         $minNode = null;
            //         foreach ($queue as $node) {
            //             if ($distances[$node] < $minDistance) {
            //                 $minDistance = $distances[$node];
            //                 $minNode = $node;
            //             }
            //         }
            
            //         if ($minNode === $end) {
            //             break; // Found shortest path to end
            //         }
            
            //         // Remove the selected node from the queue
            //         $queue = array_diff($queue, [$minNode]);
            
            //         // Update distances, previous nodes, and directions for neighboring nodes
            //         foreach ($graph[$minNode] as $neighbor => $weight) {
            //             $alt = $distances[$minNode] + $weight;
            //             if ($alt < $distances[$neighbor]) {
            //                 $distances[$neighbor] = $alt;
            //                 $previous[$neighbor] = $minNode;
            //                 if (isset($pointXY_f11_4[$minNode]['X']) && isset($pointXY_f11_4[$neighbor]['X'])) {
            //                     $directions[$neighbor] = ($pointXY_f11_4[$minNode]['X'] < $pointXY_f11_4[$neighbor]['X']) ? 'right' : 'left';
            //                 } else {
            //                     error_reporting(E_ERROR | E_PARSE);
            //                     ini_set('display_errors', 1);
            //                 }
            //             }
            //         }
            //     }
            
            //     // Reconstruct the shortest path
            //     $path = [];
            //     $directionInfo = [];
            //     $node = $end;
            //     while ($previous[$node] !== null) {
            //         array_unshift($path, $node);
            //         array_unshift($directionInfo, $directions[$node]);
            //         $node = $previous[$node];
            //     }
            //     array_unshift($path, $start);
            
            //     return ['path' => $path, 'directions' => $directionInfo];
            // }
            
            function calculateAngle($current, $next)
            {
                $angle = atan2($next['Y'] - $current['Y'], $next['X'] - $current['X']);

                // Convert radians to degrees
                $angle = rad2deg($angle);

                // Adjust the angle to be between 0 and 360 degrees
                $angle = ($angle + 360) % 360;


                $up = ($next['Y'] <= $current['Y']) ? 1 : 2;

                return ['angle' => $angle, 'up' => $up];
            }



            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                // Get the start and end values from the URL parameters
                $start = $_GET["start"];
                $end = $_GET["end"];
                $mapURL = "";
                $graph = [];

                // select map
                $query = $conn->query(
                    "SELECT building.buildingname, room.floors
                                        FROM building
                                        JOIN room ON building.buildingid = room.buildingid
                                        WHERE room.roomname = '$end';"
                );
                if ($query->num_rows > 0) {
                    while ($row = $query->fetch_assoc()) {
                        $buildingName = $row['buildingname'];
                        $floors = $row['floors'];

                        echo "Building Name : $buildingName, Floor : $floors";
                        echo "<br>";

                    }
                } else {
                    echo "<div class='col-3'>";
                    echo "<p>Cannot find floors and building name</p>";
                    echo "</div>";
                }

                //check Map - Floor
                if ($buildingName == 'F11 -- อาคารสิรินธรวิศวพัฒน์') {
                    if ($floors == 4) {
                        $mapURL = "Map_F11_41.png";
                        $graph = [
                            'elevatorF11_4M' => ['c1' => 4, 'b1' => 3],
                            'c1' => ['elevatorF11_4M' => 4, 'F11_401' => 3, 'F11_402' => 3, 'c2' => 4],

                            'F11_401' => ['c1' => 3, 'F11_402' => 1, 'c9' => 3],
                            'F11_402' => ['c1' => 3, 'F11_401' => 1, 'c9' => 3],

                            'c9' => ['F11_401' => 3, 'F11_402' => 3, 'StairF11_f4s' => 2, 'tois4' => 3],

                            'StairF11_f4s' => ['c9' => 2, 'tois4' => 1, 'c3' => 3],
                            'tois4' => ['StairF11_f4s' => 1, 'c3' => 2, 'c9' => 3,],

                            'c2' => ['c1' => 4, 'c3' => 4, 'c4' => 3],
                            'c3' => ['tois4' => 2, 'c2' => 4, 'F11_407' => 2, 'F11_408' => 4],

                            'F11_407' => ['c3' => 2, 'F11_408' => 1],
                            'F11_408' => ['c3' => 4, 'F11_407' => 2, 'F11_409' => 2],

                            'F11_409' => ['F11_408' => 2, 'F11_410' => 1, 'F11_411' => 1, 'F11_415' => 4],
                            'F11_410' => ['F11_409' => 1, 'F11_411' => 1],
                            'F11_411' => ['F11_409' => 1, 'F11_410' => 1],

                            'c4' => ['c2' => 3, 'F11_415' => 1, 'c5' => 5],

                            'F11_412' => ['F11_413' => 1,],
                            'F11_413' => ['F11_412' => 1, 'F11_415' => 1],
                            //'F11_414' => [ 'c4' => 1, 'F11_412' => 2, 'F11_413' => 1, 'F11_415' => 1 ],
                            'F11_415' => ['c4' => 1, 'F11_413' => 1, 'F11_409' => 4],

                            'c5' => ['c4' => 5, 'L2' => 4, 'F11_414' => 2, 'b2' => 4],
                            'L2' => ['c5' => 4, 'F11_414' => 1, 'Pohmroom' => 2, 'b2' => 4],

                            'F11_414' => ['c5' => 2, 'L2' => 1],
                            'Pohmroom' => ['L2' => 2, 'b2' => 3],

                            'b2' => ['c5' => 4, 'L2' => 4, 'Pohmroom' => 3, 'toilet_421' => 2],
                            'toilet_421' => ['b2' => 2, 'F11_421b' => 1],

                            'F11_421b' => ['toilet_421' => 1, 'F11_421' => 7, 'F11_419' => 2],
                            'F11_421' => ['F11_421b' => 7, 'F11_422' => 2, 'b1' => 1],
                            'F11_419' => ['F11_421b' => 2, 'F11_420' => 1],
                            'F11_420' => ['F11_419' => 1, 'b1' => 2],
                            'F11_422' => ['F11_421' => 2, 'F11_423' => 1],
                            'F11_423' => ['F11_422' => 1],

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
                    } elseif ($floors == 3) {
                        $mapURL = "Map_F11_3.png";
                        $graph = [
                        ];
                    } elseif ($floors == 2) {
                        $mapURL = "Map_F11_2.png";
                        $graph = [
                        ];
                    } elseif ($floors == 1) {
                        $mapURL = "Map_F11_1.png";
                        $graph = [
                        ];
                    }
                } elseif ($buildingName == 'อาคารเรียนรวม 1') {
                    if ($floors == 2) {
                        $mapURL = "Map_M1_2.png";
                        $graph = [
                        ];
                    } elseif ($floors == 1) {
                        $mapURL = "Map_M1_1.png";
                        $graph = [
                        ];
                    }
                } elseif ($buildingName == 'อาคารเรียนรวม 2') {
                    if ($floors == 2) {
                        $mapURL = "Map_M2_2.png";
                        $graph = [
                        ];
                    } elseif ($floors == 1) {
                        $mapURL = "Map_M2_1.png";
                        $graph = [
                        ];
                    }
                } elseif ($buildingName == 'อาคารวิชาการ 1') {
                    $graph = [];
                } elseif ($buildingName == 'อาคารวิชาการ 2') {
                    $graph = [];
                } elseif ($buildingName == 'F12 อาคารเทพรัตน์วิทยรักษ์') {
                    if ($floors == 4) {
                        $mapURL = "Map_F11_41.png";
                        $graph = [
                        ];
                    } elseif ($floors == 3) {
                        $mapURL = "Map_F11_3.png";
                        $graph = [
                        ];
                    } elseif ($floors == 2) {
                        $mapURL = "Map_F11_2.png";
                        $graph = [
                        ];
                    } elseif ($floors == 1) {
                        $mapURL = "Map_F11_1.png";
                        $graph = [
                        ];
                    }
                }

                echo '<div class="conMap">';
                echo '    <div class="map">';
                echo '        <canvas id="mapCanvas" style="border: solid 1px; position: absolute; "></canvas>';
                echo '        <img src="/Indoor/Map_for_indor/' . $mapURL . '" id="mapImage">';
                echo '    </div>';
                echo '</div>';
                echo '<br><br>';

                // Calculate the shortest path
                $shortestPath = dijkstra($graph, $start, $end);

                // Display the selected start and end points
                echo "You selected start point: " . $start . "<br>";
                echo "You selected end point: " . $end . "<br>";


                // // Usage example
                // $result = dijkstraWithDirections($graph, $start, $end, $pointXY_f11_4);
                // $shortestArrayPath = $result['path'];
                // $directions = $result['directions'];
            
                // // Display the shortest path and directions
                // echo "Shortest path from $start to $end: " . implode(' -> ', $shortestArrayPath) . "<br>";
            
                // echo "Directions: ";
                // foreach ($directions as $index => $direction) {
                //     echo $shortestArrayPath[$index] . " -> " . $direction . " -> ";
                // }
                // echo $end;
                // echo "<br>";
            

                if ($shortestPath !== null) {
                    $shortestArrayPath = $shortestPath;
                    echo "Shortest path from $start to $end: " . implode(' -> ', $shortestPath);

                    // Encode the PHP array as JSON
                    $pathWayJSON = json_encode($shortestArrayPath);

                    // Fetch and display images related to the shortestArrayPath
                    echo "<div class='row g-2'>";
                    $namePath = $start . '_' . $start;

                    echo "<div class='col-72' style='padding: 20px;  background-color: #555; border-radius: 5px;'>";
                    echo "</div>";

                    // แสดงรูปสำหรับ $start
                    $imageURLEnd = 'uploads/' . $namePath . '.jpg';
                    echo "<div class='col-3'>";
                    echo "</div>";

                    echo "<div class='col-3'>";
                    echo "<div class='card shadow h-100'>";
                    echo "<img src='$imageURLEnd' alt='' width='20%' class='card-img'>";
                    if (file_exists($imageURLEnd)) {
                        echo "$imageURLEnd";
                    }
                    echo "</div>";
                    echo "</div>";

                    echo "<div class='col-5'>";
                    echo "</div>";


                    // แสดงรูปสำหรับ $start l
                    $imageURLEnd1 = 'uploads/' . $namePath . '_L.jpg';
                    echo "<div class='col-1'>";
                    echo "</div>";

                    echo "<div class='col-3'>";
                    echo "<div class='card shadow h-100'>";
                    echo "<img src='$imageURLEnd1' alt='' width='20%' class='card-img'>";
                    if (file_exists($imageURLEnd1)) {
                        echo "Left of $start Room";
                    }
                    echo "</div>";
                    echo "</div>";

                    //circle echo "<div class='col-1 d-flex align-items-center justify-content-center circle'>Circle</div>";
                    echo "<div class='col-3 circle'>You</div>";

                    // แสดงรูปสำหรับ $start r
                    $imageURLEnd2 = 'uploads/' . $namePath . '_R.jpg';

                    echo "<div class='col-3'>";
                    echo "<div class='card shadow h-100'>";
                    echo "<img src='$imageURLEnd2' alt='' width='20%' class='card-img'>";
                    if (file_exists($imageURLEnd2)) {
                        echo "Right of $start Room";
                    }
                    echo "</div>";
                    echo "</div>";



                    // แสดงรูปสำหรับ $start B
                    // $imageURLEnd3 = 'uploads/' . $namePath . '_B.jpg';
                    echo "<div class='col-3'>";
                    echo "</div>";

                    // echo "<div class='col-3'>";
                    // echo "</div>";
            
                    // echo "<div class='col-3'>";
                    // echo "<div class='card shadow h-100'>";
                    // echo "<img src='$imageURLEnd3' alt='' width='20%' class='card-img'>";
                    // if (file_exists($imageURLEnd3)) {
                    //     echo "Back of $start Room";
                    // }
                    // echo "</div>";
                    // echo "</div>";
            
                    // echo "<div class='col-5'>";
                    // echo "</div>";
            
                    // $result = calculateAngle($pointXY_f11_4[$start], $pointXY_f11_4[ $namePath]);
                    // $angle = $result['angle'];
                    // $up = $result['up'];
            
                    // echo "Angle $up between $start and  $namePath: $angle degrees\n";
            
                    // //for up 
                    // if ($up == 1) {
                    //     if ($angle >= 45 && $angle < 135) {
                    //         echo "Go Anywhere\n";
                    //         $holdState = "upAnywhere";
            
                    //     } elseif ($angle >= 135 && $angle < 225) {
                    //         if ($holdState == "upLeft") {
                    //             echo "Go straight\n";
                    //         }elseif ($holdState == "") {
                    //             echo "Go straight\n";
                    //         } else {
                    //             echo "Go Left\n";
                    //         }
                    //         $holdState = "upLeft";
            
                    //     } elseif ($angle >= 225 && $angle < 315) {
                    //         if ($holdState == "upLeft" ) {
                    //             echo "Turn Left\n";
                    //         }elseif ($holdState == "upRight" ) {
                    //             echo "Turn Right\n";
                    //         }
                    //         echo "Go Straight \n";
                    //         $holdState = "upStraight";
            
                    //     } else {
                    //         if ($holdState == "upRight") {
                    //             echo "Go straight\n";
                    //         }elseif ($holdState == "") {
                    //             echo "Go straight\n";
                    //         } else {
                    //             echo "Go Right\n";
                    //         }
                    //         $holdState = "upRight";
            
                    //     }
                    //     $up = 0;
                    //     //for down
                    // } elseif ($up == 2) {
                    //     if ($angle >= 45 && $angle < 135) {
                    //         if ($holdState == "downLeft" ) {
                    //             echo "Turn Left\n";
                    //         }elseif ($holdState == "downRight" ) {
                    //             echo "Turn Right\n";
                    //         }
                    //         echo "Go Straight\n";
                    //         $holdState = "downStraight";
            
                    //     } elseif ($angle >= 135 && $angle < 225) {
                    //         if ($holdState == "downLeft") {
                    //             echo "Go straight\n";
                    //         }elseif ($holdState == "") {
                    //             echo "Go straight\n";
                    //         } else {
                    //             echo "Go Left\n";
                    //         }
                    //         $holdState = "downLeft";
            

                    //     } elseif ($angle >= 225 && $angle < 315) {
                    //         echo "Degree \n";
                    //         echo "Go Anywhere \n";
                    //         $holdState = "downAnywhere";
            
                    //     } else {
                    //         if ($holdState == "downRight") {
                    //             echo "Go straight\n";
                    //         }elseif ($holdState == "") {
                    //             echo "Go straight\n";
                    //         } else {
                    //             echo "Go Right\n";
                    //         }
                    //         $holdState = "downRight";
                    //     }
                    //     $up = 0;
                    // }
            
                    $holdState = "";
                    $elementNumber = 1;
                    foreach ($shortestArrayPath as $point1) {
                        $nextPointIndex = array_search($point1, $shortestArrayPath) + 1;
                        if ($nextPointIndex < count($shortestArrayPath)) {
                            $point2 = $shortestArrayPath[$nextPointIndex];

                            $result = calculateAngle($pointXY_f11_4[$point1], $pointXY_f11_4[$point2]);
                            $angle = $result['angle'];
                            $up = $result['up'];


                            // สร้าง query เพื่อค้นหารูปภาพโดยใช้ $fileName
                            //$query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName" . "b.jpg'");ok
            
                            echo "<div class='col-72' style='padding: 20px;  background-color: #555; border-radius: 5px;'>";
                            echo "</div>";


                            echo "<div class='col-12'>";
                            echo "Angle $up between $point1 and $point2: $angle degrees\n";


                            //for up 
                            if ($up == 1) {
                                if ($angle >= 45 && $angle < 135) {
                                    echo "Go Anywhere\n";
                                    $holdState = "upAnywhere";

                                } elseif ($angle >= 135 && $angle < 225) {
                                    if ($holdState == "upLeft") {
                                        echo "Go straight u1\n";
                                    } elseif ($holdState == "") {
                                        echo "Go straight start1\n";
                                    } else {
                                        echo "Go Left\n";
                                    }
                                    $holdState = "upLeft";

                                } elseif ($angle >= 225 && $angle < 315) {
                                    if ($holdState == "upLeft") {
                                        echo "Turn Left u2\n";
                                    } elseif ($holdState == "upRight") {
                                        echo "Turn Left sus\n";

                                        echo "<div class='row g-2'>";


                                        //mid R
                                        $fileName2 = $point1 . '_' . $point2 . '_R';
                                        $query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName2.jpg'");
                                        echo "<div class='col-3'>";
                                        echo "</div>";
                                        if ($query->num_rows > 0) {
                                            while ($row = $query->fetch_assoc()) {
                                                $imageURL = 'uploads/' . $row['file_name'];
                                                echo "<div class='col-3'>";
                                                echo "<div class='card shadow h-100'>";
                                                echo "<img src='$imageURL' alt='' width='100%' class='card-img'>";
                                                echo "Right of $fileName2 Room";
                                                echo "</div>";
                                                echo "</div>";
                                            }
                                        } else {
                                            echo "<div class='col-3'>";
                                            // echo "<p>No image found for point: $fileName2</p>";
                                            echo "</div>";

                                        }

                                        // $fileName3 = $point1 . '_' . $point2 . '_B';
                                        // $query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName3.jpg'");
                                        echo "<div class='col-3'>";
                                        echo "</div>";


                                        // T
                                        $fileName = $point1 . '_' . $point2;
                                        $query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName.jpg'");
                                        if ($query->num_rows > 0) {
                                            while ($row = $query->fetch_assoc()) {
                                                $imageURL = 'uploads/' . $row['file_name'];
                                                echo "<div class='col-3'>";
                                                echo "</div>";
                                                echo "<div class='col-sm-3 col-lg-4 col-xl-3'>";
                                                echo "<div class='card shadow h-100'>";
                                                echo "<img src='$imageURL' alt='' width='100%' class='card-img'>";
                                                echo "Way to  $fileName Room";
                                                echo "</div>";
                                                echo "</div>";
                                            }
                                        } else {
                                            echo "<br>";
                                            //echo "<p>No image found for point: $fileName</p>";
                                        }


                                        
                                        // Next circle
                                        $nextElementNumber = $elementNumber + 1;
                                        echo "<div id='element$nextElementNumber' class='col-3' style='text-align: center; margin: auto;'>";
                                        echo "<div class='circle' style='text-align: center; margin: auto;'>";
                                        echo "<span onclick=\"navigate('next')\" style='cursor: pointer;'>$nextElementNumber</span>";
                                        echo "</div>";
                                        echo "</div>";

                                        //B
                                        $fileName3 = $point1 . '_' . $point2 . '_B';
                                        $query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName3.jpg'");

                                        if ($query->num_rows > 0) {
                                            while ($row = $query->fetch_assoc()) {
                                                $imageURL = 'uploads/' . $row['file_name'];
                                                echo "<div class='col-sm-6 col-lg-4 col-xl-3'>";
                                                echo "<div class='card shadow h-100'>";
                                                echo "<img src='$imageURL' alt='' width='100%' class='card-img'>";
                                                echo "Back of $fileName3 Room";
                                                echo "</div>";
                                                echo "</div>";
                                            }
                                        } else {
                                            echo "<div class='col-3'>";
                                            echo "</div>";
                                        }
                                        echo "<div class='col-3'>";
                                        echo "</div>";


                                        echo "<div class='col-72' style='padding: 20px;  background-color: #555; border-radius: 5px;'>";
                                        echo "aaaaaaaaaaaaaaaaaaaaaaaaa";
                                        echo "</div>";

                                        echo "</div>";








                                    }
                                    echo "Go Straight \n";
                                    $holdState = "upStraight";

                                } else {
                                    if ($holdState == "upRight") {
                                        echo "Go straight u3 \n";
                                    } elseif ($holdState == "") {
                                        echo "Go straight start2\n";
                                    } else {
                                        echo "Go Right\n";
                                    }
                                    $holdState = "upRight";

                                }
                                $up = 0;
                                //for down
                            } elseif ($up == 2) {
                                if ($angle >= 45 && $angle < 135) {
                                    if ($holdState == "downLeft") {
                                        echo "Turn Left\n";
                                    } elseif ($holdState == "downRight") {
                                        echo "Turn Right\n";
                                    }
                                    echo "Go Straight\n";
                                    $holdState = "downStraight";

                                } elseif ($angle >= 135 && $angle < 225) {
                                    if ($holdState == "downLeft") {
                                        echo "Go straight\n";
                                    } elseif ($holdState == "") {
                                        echo "Go straight\n";
                                    } else {
                                        echo "Go Left\n";
                                    }
                                    $holdState = "downLeft";


                                } elseif ($angle >= 225 && $angle < 315) {
                                    echo "Degree \n";
                                    echo "Go Anywhere \n";
                                    $holdState = "downAnywhere";

                                } else {
                                    if ($holdState == "downRight") {
                                        echo "Go straight\n";
                                    } elseif ($holdState == "") {
                                        echo "Go straight\n";
                                    } else {
                                        echo "Go Right\n";
                                    }
                                    $holdState = "downRight";
                                }
                                $up = 0;
                            }

                            echo "</div>";


                            $fileName = $point1 . '_' . $point2;
                            $query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName.jpg'");
                            if ($query->num_rows > 0) {
                                while ($row = $query->fetch_assoc()) {
                                    $imageURL = 'uploads/' . $row['file_name'];
                                    echo "<div class='col-3'>";
                                    echo "</div>";
                                    echo "<div class='col-sm-3 col-lg-4 col-xl-3'>";
                                    echo "<div class='card shadow h-100'>";
                                    echo "<img src='$imageURL' alt='' width='100%' class='card-img'>";
                                    echo "Way to  $fileName Room";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<div class='col-5'>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<br>";
                                //echo "<p>No image found for point: $fileName</p>";
                            }

                            //L
                            $fileName1 = $point1 . '_' . $point2 . '_L';
                            $query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName1.jpg'");

                            if ($query->num_rows > 0) {
                                while ($row = $query->fetch_assoc()) {
                                    $imageURL = 'uploads/' . $row['file_name'];
                                    echo "<div class='col-3'>";
                                    echo "<div class='card shadow h-100'>";
                                    echo "<img src='$imageURL' alt='' width='100%' class='card-img'>";
                                    echo "Left of $fileName1 Room";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<div class='col-3'>";
                                // echo "<p>No image found for point: $fileName1</p>";
                                echo "</div>";

                            }


                            // Next circle
                            $nextElementNumber = $elementNumber + 1;
                            echo "<div id='element$nextElementNumber' class='col-3' style='text-align: center; margin: auto;'>";
                            echo "<div class='circle' style='text-align: center; margin: auto;'>";
                            echo "<span onclick=\"navigate('next')\" style='cursor: pointer;'>$nextElementNumber</span>";
                            echo "</div>";
                            echo "</div>";

                            //mid R
                            $fileName2 = $point1 . '_' . $point2 . '_R';
                            $query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName2.jpg'");

                            if ($query->num_rows > 0) {
                                while ($row = $query->fetch_assoc()) {
                                    $imageURL = 'uploads/' . $row['file_name'];
                                    echo "<div class='col-3'>";
                                    echo "<div class='card shadow h-100'>";
                                    echo "<img src='$imageURL' alt='' width='100%' class='card-img'>";
                                    echo "Right of $fileName2 Room";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<div class='col-3'>";
                                // echo "<p>No image found for point: $fileName2</p>";
                                echo "</div>";

                            }


                            echo "<div class='col-3'>";
                            echo "</div>";
                            //B
                            // $fileName3 = $point1 . '_' . $point2 . '_B';
                            // $query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName3.jpg'");
                            // echo "<div class='col-3'>";
                            // echo "</div>";
            
                            // if ($query->num_rows > 0) {
                            //     while ($row = $query->fetch_assoc()) {
                            //         $imageURL = 'uploads/' . $row['file_name'];
                            //         echo "<div class='col-sm-6 col-lg-4 col-xl-3'>";
                            //         echo "<div class='card shadow h-100'>";
                            //         echo "<img src='$imageURL' alt='' width='100%' class='card-img'>";
                            //         echo "Back of $fileName3 Room";
                            //         echo "</div>";
                            //         echo "</div>";
                            //     }
                            // } else {
                            //     echo "<p>No image found for point: $fileName3</p>";
                            // }
            
                            $elementNumber++;




                        }
                    }

                    echo "<div class='col-72' style='padding: 20px;  background-color: #555; border-radius: 5px;'>";
                    echo "</div>";

                    $namePath = $end . '_' . $end;

                    // แสดงรูปสำหรับ $end
                    $imageURLEnd = 'uploads/' . $namePath . '.jpg';
                    echo "<div class='col-3'>";
                    echo "</div>";

                    echo "<div class='col-3'>";
                    echo "<div class='card shadow h-100'>";
                    echo "<img src='$imageURLEnd' alt='' width='20%' class='card-img'>";
                    if (file_exists($imageURLEnd)) {
                        echo "$imageURLEnd";
                    }
                    echo "</div>";
                    echo "</div>";

                    echo "<div class='col-5'>";
                    echo "</div>";


                    // แสดงรูปสำหรับ $end l
                    $imageURLEnd1 = 'uploads/' . $namePath . '_L.jpg';
                    echo "<div class='col-1'>";
                    echo "</div>";

                    echo "<div class='col-3'>";
                    echo "<div class='card shadow h-100'>";
                    echo "<img src='$imageURLEnd1' alt='' width='20%' class='card-img'>";
                    if (file_exists($imageURLEnd1)) {
                        echo "Left of $end Room";
                    }
                    echo "</div>";
                    echo "</div>";

                    //circle echo "<div class='col-1 d-flex align-items-center justify-content-center circle'>Circle</div>";
                    echo "<div class='col-3 circle'>You</div>";

                    // แสดงรูปสำหรับ $end r
                    $imageURLEnd2 = 'uploads/' . $namePath . '_R.jpg';

                    echo "<div class='col-3'>";
                    echo "<div class='card shadow h-100'>";
                    echo "<img src='$imageURLEnd2' alt='' width='20%' class='card-img'>";
                    if (file_exists($imageURLEnd2)) {
                        echo "Right of $end Room";
                    }
                    echo "</div>";
                    echo "</div>";

                    // // แสดงรูปสำหรับ $end B
                    // $imageURLEnd3 = 'uploads/' . $namePath . '_B.jpg';
                    echo "<div class='col-3'>";
                    echo "</div>";

                    // echo "<div class='col-3'>";
                    // echo "</div>";
            
                    // echo "<div class='col-3'>";
                    // echo "<div class='card shadow h-100'>";
                    // echo "<img src='$imageURLEnd3' alt='' width='20%' class='card-img'>";
                    // if (file_exists($imageURLEnd3)) {
                    //     echo "Back of $end Room";
                    // }
                    // echo "</div>";
                    // echo "</div>";
            
                    // echo "<div class='col-5'>";
                    // echo "</div>";
            

                    // // แสดงรูปสำหรับ $end
                    // $imageURLEnd = 'uploads/' . $end . '.jpg';
            
                    // echo "<div class='col-sm-6 col-lg-4 col-xl-3'>";
                    // echo "<div class='card shadow h-100'>";
                    // echo "<img src='$imageURLEnd' alt='' width='100%' class='card-img'>";
                    // echo "</div>";
                    // echo "</div>";
            
                } else {
                    echo "Sorry, there is no way to go from $start to $end. Please select somewhere closer to the target.";
                }
            }

            ?>
        </div>
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
                ctx.fillStyle = "green";
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

    // Function to handle next and back navigation
    function navigate(direction) {
        var currentElement = parseInt(localStorage.getItem('currentElement')) || 1;

        if (direction === 'next') {
            currentElement++;
        } else if (direction === 'back') {
            currentElement--;
        }

        localStorage.setItem('currentElement', currentElement);
        scrollToElement('element' + currentElement);
    }

    function scrollToElement(elementId) {
        var element = document.getElementById(elementId);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    }


</script>

</html>

<style lang="scss" :scope>
    body {
        background: #ddd;
        text-align: center;

    }

    .conResult {
        padding-top: 20px;
        padding-bottom: 80px;
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

    .circle {
        width: 50px;
        height: 50px;
        background-color: #333;
        /* color of the circle */
        border-radius: 50%;
        /* creates a circular shape */
        margin: auto;
        text-align: center;
        /* centers the circle horizontally */
    }
</style>