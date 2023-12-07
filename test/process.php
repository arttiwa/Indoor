<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="process.php" class="nav-link active" aria-current="page">ANS</a></li>
                <li class="nav-item"><a href="beindex.php" class="nav-link">UPLOAD PICTURE TO DATABASE</a></li>
                <li class="nav-item"><a href="capture.php" class="nav-link">USE CAM FOR FINDING ROOM </a></li>
                <li class="nav-item"><a href="maptest.php" class="nav-link ">MAP</a></li>
                <li class="nav-item"><a href="page3.php" class="nav-link">page3</a></li>
            </ul>
        </header>
    </div>
</body>

</html>
<?php

session_start();
include_once 'dbConfig.php';

function dijkstra($graph, $start, $end) {
    $distances = array_fill_keys(array_keys($graph), PHP_INT_MAX);
    $distances[$start] = 0;
    $previous = array_fill_keys(array_keys($graph), null);
    $queue = array_keys($graph);

    while(!empty($queue)) {
        // Find the node with the smallest distance in the queue
        $minDistance = PHP_INT_MAX;
        $minNode = null;
        foreach($queue as $node) {
            if($distances[$node] < $minDistance) {
                $minDistance = $distances[$node];
                $minNode = $node;
            }
        }

        if($minNode === $end) {
            break; // Found shortest path to end
        }

        // Remove the selected node from the queue
        $queue = array_diff($queue, [$minNode]);

        // Update distances and previous nodes for neighboring nodes
        foreach($graph[$minNode] as $neighbor => $weight) {
            $alt = $distances[$minNode] + $weight;
            if($alt < $distances[$neighbor]) {
                $distances[$neighbor] = $alt;
                $previous[$neighbor] = $minNode;
            }
        }
    }

    // Reconstruct the shortest path
    $path = [];
    $node = $end;
    while($previous[$node] !== null) {
        array_unshift($path, $node);
        $node = $previous[$node];
    }
    array_unshift($path, $start);

    return $path;
}

$graph = [
    'elevatorF11_4M' => ['c1' => 4, 'b1' => 3],
    'c1' => ['elevatorF11_4M' => 4, 'F11_401' => 3, 'F11_402' => 3, 'cc' => 5, 'cd' => 5, 'ce' => 6, 'StairF11_f4s' => 6, 'c2' => 4],

    'F11_401' => ['c1' => 3, 'F11_402' => 1, 'cc' => 2],
    'F11_402' => ['c1' => 3, 'F11_401' => 1, 'cc' => 2, 'cd' => 1, 'StairF11_f4s' => 3, 'tois4' => 4],

    'cc' => ['c1' => 5, 'F11_401' => 2, 'F11_402' => 2, 'cd' => 1, 'ce' => 2, 'StairF11_f4s' => 2, 'tois4' => 3],
    'cd' => ['c1' => 5, 'F11_402' => 1, 'cd' => 1],
    'ce' => ['c1' => 6, 'cc' => 2, 'StairF11_f4s' => 2],

    'StairF11_f4s' => ['c1' => 6, 'F11_402' => 3, 'cc' => 2, 'ce' => 2, 'tois4' => 1],
    'tois4' => ['F11_402' => 4, 'cc' => 3, 'StairF11_f4s' => 1, 'c3' => 2],

    'c2' => ['c1' => 4, 'c3' => 4, 'c4' => 3],
    'c3' => ['tois4' => 2, 'c2' => 4, 'F11_405' => 3, 'F11_406' => 2, 'F11_407' => 2, 'F11_408' => 4],

    'F11_405' => ['c3' => 3, 'F11_406' => 1, 'F11_407' => 1, 'F11_408' => 1],
    'F11_406' => ['c3' => 2, 'F11_405' => 1, 'F11_407' => 1, 'F11_408' => 1],
    'F11_407' => ['c3' => 2, 'F11_405' => 1, 'F11_406' => 1, 'F11_408' => 1],
    'F11_408' => ['c3' => 4, 'F11_405' => 1, 'F11_406' => 2, 'F11_407' => 2, 'F11_409' => 2, 'F11_410' => 3, 'F11_411' => 2, 'F11_413' => 4],

    'F11_409' => ['F11_408' => 2, 'F11_410' => 1, 'F11_411' => 1],
    'F11_410' => ['F11_408' => 3, 'F11_409' => 1, 'F11_411' => 1],
    'F11_411' => ['F11_408' => 2, 'F11_409' => 1, 'F11_410' => 1],

    'c4' => ['c2' => 3, 'F11_413' => 2, 'F11_415' => 1, 'c5' => 5],

    'F11_412' => ['F11_413' => 1, 'F11_415' => 2],
    'F11_413' => ['F11_408' => 4, 'c4' => 2, 'F11_412' => 1, 'F11_415' => 1],
    //'F11_414' => [ 'c4' => 1, 'F11_412' => 2, 'F11_413' => 1, 'F11_415' => 1 ],
    'F11_415' => ['c4' => 1, 'F11_412' => 2, 'F11_413' => 1,],

    'c5' => ['c4' => 5, 'L2' => 4, 'F11_414' => 2, 'b2' => 4],
    'L2' => ['c5' => 4, 'F11_414' => 1, 'Pohmroom' => 2, 'b2' => 4],

    'F11_414' => ['c5' => 2, 'L2' => 1],
    'Pohmroom' => ['L2' => 2, 'b2' => 3],

    'b2' => ['c5' => 4, 'L2' => 4, 'Pohmroom' => 3, 'toilet_421' => 2],
    'toilet_421' => ['b2' => 2, 'F11_421b' => 1, 'b1' => 5],

    'F11_421b' => ['toilet_421' => 1, 'F11_421' => 3, 'F11_419' => 2, 'b1' => 4],
    'F11_421' => ['F11_421b' => 3, 'F11_422' => 2, 'F11_423' => 5, 'b1' => 1],
    'F11_419' => ['F11_421b' => 2, 'F11_420' => 1, 'b1' => 3],
    'F11_420' => ['F11_419' => 1, 'b1' => 2],
    'F11_422' => ['F11_421' => 2, 'F11_423' => 1, 'b1' => 4],
    'F11_423' => ['toilet_421' => 5, 'F11_422' => 1, 'b1' => 6],

    'b1' => ['elevatorF11_4M' => 3, 'toilet_421' => 5, 'F11_421b' => 4, 'F11_421' => 1, 'F11_419' => 3, 'F11_420' => 2, 'F11_422' => 4, 'F11_423' => 6],

    'A' => ['B' => 1, 'C' => 4],
    'B' => ['A' => 1, 'C' => 2, 'D' => 5],
    'C' => ['A' => 4, 'B' => 2, 'D' => 1],
    'D' => ['B' => 5, 'C' => 1]
];

if($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get the start and end values from the URL parameters
    $start = $_GET["start"];
    $end = $_GET["end"];


    // Calculate the shortest path
    $shortestPath = dijkstra($graph, $start, $end);

    // Display the selected start and end points
    echo "You selected start point: ".$start."<br>";
    echo "You selected end point: ".$end."<br>";

    if($shortestPath !== null) {
        $shortestArrayPath = $shortestPath;
        echo "Shortest path from $start to $end: ".implode(' -> ', $shortestPath);

        echo "<pre>";
        print_r($shortestArrayPath);
        echo "</pre>";

        // Fetch and display images related to the shortestArrayPath
        echo "<div class='row g-2'>";

        // แสดงรูปสำหรับ $start
        $imageURLStart = 'uploads/'.$start.'.jpg';
        echo "<div class='col-sm-6 col-lg-4 col-xl-3'>";
        echo "<div class='card shadow h-100'>";
        echo "<img src='$imageURLStart' alt='' width='100%' class='card-img'>";
        echo "</div>";
        echo "</div>";

        foreach($shortestArrayPath as $point1) {
            $nextPointIndex = array_search($point1, $shortestArrayPath) + 1;
            if($nextPointIndex < count($shortestArrayPath)) {
                $point2 = $shortestArrayPath[$nextPointIndex];
                // $fileName = $point1  ;ok can use 1 valiable
                $fileName = $point1.'-'.$point2;

                // สร้าง query เพื่อค้นหารูปภาพโดยใช้ $fileName
                //$query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName" . "b.jpg'");ok
                $query = $conn->query("SELECT * FROM images WHERE file_name = '$fileName.jpg'");

                if($query->num_rows > 0) {
                    while($row = $query->fetch_assoc()) {
                        $imageURL = 'uploads/'.$row['file_name'];
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
        $imageURLEnd = 'uploads/'.$end.'.jpg';
        echo "<div class='col-sm-6 col-lg-4 col-xl-3'>";
        echo "<div class='card shadow h-100'>";
        echo "<img src='$imageURLEnd' alt='' width='100%' class='card-img'>";
        echo "</div>";
        echo "</div>";


    } else {
        echo "Sorry, there is no way to go from $start to $end. Please select somewhere closer to the target.";
    }
}

?>