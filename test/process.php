<?php

function dijkstra($graph, $start, $end) {
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
    'c1' => ['elevatorF11_4M' => 4, 'F11_401' => 3,'F11_402' => 3,'cc' => 5,'cd' => 5,'ce' => 6, 'StairF11_f4s' => 6,'c2' => 4],
    
    'F11_401' => [ 'c1' => 3, 'F11_402' => 1, 'cc' => 2],
    'F11_402' => [ 'c1' => 3, 'F11_401' => 1, 'cc' => 2,'cd' => 1, 'StairF11_f4s' => 3, 'tois4' => 4],
    
    'cc' =>['c1'=>5,'F11_401'=>2,'F11_402'=>2,'cd'=>1,'ce'=>2,'StairF11_f4s'=>2,'tois4'=>3],
    'cd' =>['c1'=>5,'F11_402'=>1,'cd'=>1],
    'ce' =>['c1'=>6,'cc'=>2,'StairF11_f4s'=>2],
    
    'StairF11_f4s' => ['c1' => 6,'F11_402' => 3 , 'cc' => 2 ,'ce' => 2 ,  'tois4' => 1],
    'tois4' => ['F11_402' => 4 , 'cc' => 3 , 'StairF11_f4s' => 1, 'c3' => 2],   
    
    'c2' => ['c1' => 4 , 'c3' => 4,'c4'=>3 ],
    'c3' => ['tois4' => 2 , 'c2' => 4 , 'F11_407' => 2, 'F11_408' => 3, 'F11_409' => 5, 'F11_410' => 6, 'F11_411' => 6],
    
    'F11_407' => ['c3' => 2 , 'F11_408' => 1, 'F11_409' => 2 ],
    'F11_408' => ['c3' => 3 , 'F11_407' => 1, 'F11_409' => 2 ],
    'F11_409' => ['c3' => 5 , 'F11_407' => 2, 'F11_408' => 2, 'F11_410' => 1, 'F11_411' => 2, 'F11_412' => 5, 'F11_413' => 4, 'F11_414' => 5, 'F11_415' => 5 ],
    'F11_410' => ['c3' => 6 , 'F11_409' => 1, 'F11_411' => 1 ],
    'F11_411' => ['c3' => 6 , 'F11_409' => 2, 'F11_410' => 1 ],
    
    'c4' => ['c2' => 3 , 'F11_412' => 3, 'F11_413' => 2,'F11_414' => 1, 'F11_415' => 1, 'c5' => 5 ],
    
    'F11_412' => ['F11_409' => 5 , 'c4' => 3, 'F11_413' => 2, 'F11_414' => 3, 'F11_415' => 3 ],
    'F11_413' => ['F11_409' => 4 , 'c4' => 2, 'F11_412' => 2, 'F11_414' => 1, 'F11_415' => 1 ],        
    'F11_414' => ['F11_409' => 5 , 'c4' => 1, 'F11_412' => 3, 'F11_413' => 1, 'F11_415' => 1 ],
    'F11_415' => ['F11_409' => 5 , 'c4' => 1, 'F11_412' => 3, 'F11_414' => 1, 'F11_414' => 1 ],        
    
    'c5' => ['c4' => 5 , 'L2' => 4, 'puLab' => 2, 'b2' => 5],
    'L2' => ['c5' => 4 , 'puLab' => 1, 'Pohmroom' => 2, 'b2' => 4],
    
    'puLab' => ['c5' => 2 , 'L2' => 1],
    'Pohmroom' => ['L2' => 2 , 'b2' => 3],
    
    'b2' => ['c5' => 5 , 'L2' => 4, 'Pohmroom' =>3, 'toilet_421' => 4],
    'toilet_421' => ['b2' => 4 , 'F11_421b' => 1,  'b1' => 5 ],        
    
    'F11_421b' => ['toilet_421' => 1 , 'F11_421' => 4, 'F11_419' => 2, 'b1' => 4 ],        
    'F11_421' => ['F11_421b' => 4 , 'F11_422' => 2, 'F11_423' => 5, 'b1' => 1],        
    'F11_419' => ['F11_421b' => 2 , 'F11_420' => 1, 'b1' => 3],        
    'F11_420' => ['F11_419' => 1 , 'b1' => 2],        
    'F11_422' => ['F11_421' => 2 , 'F11_423' => 1, 'b1' => 4],        
    'F11_423' => ['toilet_421' => 5 , 'F11_422' => 1, 'b1' => 6],        
    
    'b1' => ['elevatorF11_4M' => 3,'toilet_421' => 5 ,'F11_421b' => 4 ,'F11_421' => 1,'F11_419' => 3 , 'F11_420' => 2, 'F11_422' => 4,'F11_423' => 6],        

    'A' => ['B' => 1, 'C' => 4],
    'B' => ['A' => 1, 'C' => 2, 'D' => 5],
    'C' => ['A' => 4, 'B' => 2, 'D' => 1],
    'D' => ['B' => 5, 'C' => 1]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the start point from the form
    $start = $_POST["start"];
    $end = $_POST["end"];

    // Calculate the shortest path
    $shortestPath = dijkstra($graph, $start, $end);

    // Display the selected start and end points
    echo "You selected start point: " . $start . "<br>";
    echo "You selected end point: " . $end . "<br>";

    // Display the shortest path
    if ($shortestPath !== null) {
        echo "Shortest path from $start to $end: " . implode(' -> ', $shortestPath);
    } else {
        echo "No path found.";
    }
}

?>
<!DOCTYPE html>
<html>
<form method="post" action="index.php">
<input type="submit" value="Back">
</form>

</html>