<?php
// Include Graph class
require_once 'graph.php';

// Create the graph object

//$graph_data  = array("A","B","C","D","E","F","G","EleF11_f4m","StairF11_f4c","F11_401",
//    "F11_
//402","F11
//_414","F11_415","F11_419
//","F11_420","F11_421","F11_4
//22","F11_423"
//);

$graph_data  = array(
    'EleF11_f4m' => array('F11_401' => 6,'F11_402' => 6,'F11_414' => 10,'F11_415' => 9,'F11_419' => 5,'F11_420' => 4,'F11_421' => 4,'F11_422' => 5,'F11_423' => 6),
    'StairF11_f4c' => array('F11_401' => 4,'F11_402' => 4,'F11_414' => 11,'F11_415' => 10,'F11_419' => 12,'F11_420' => 12,'F11_421' => 13,'F11_422' => 14,'F11_423' => 15),
    'F11_401' => array('StairF11_f4c' => 4,'EleF11_f4m' => 6,'F11_402' => 1,'F11_414' => 8,'F11_415' => 9,'F11_419' => 9,'F11_420' => 8,'F11_421' => 8,'F11_422' => 9,'F11_423' => 13),
    'F11_402' => array('StairF11_f4c' => 4,'EleF11_f4m' => 6,'F11_401' => 1,'F11_414' => 8,'F11_415' => 9,'F11_419' => 9,'F11_420' => 8,'F11_421' => 8,'F11_422' => 9,'F11_423' => 13),
    'F11_414' => array('StairF11_f4c' => 11,'EleF11_f4m' => 10,'F11_401' => 8,'F11_402' => 8,'F11_415' => 1,'F11_419' => 5,'F11_420' => 6,'F11_421' => 5,'F11_422' => 8,'F11_423' => 9),
    'F11_415' => array('StairF11_f4c' => 10,'EleF11_f4m' => 9,'F11_401' => 9,'F11_402' => 9,'F11_414' => 1,'F11_419' => 5,'F11_420' => 6,'F11_421' => 5,'F11_422' => 8,'F11_423' => 9),
    'F11_419' => array('StairF11_f4c' => 12,'EleF11_f4m' => 5,'F11_401' => 9,'F11_402' => 9,'F11_414' => 5,'F11_415' => 5,'F11_420' => 1,'F11_421' => 3,'F11_422' => 5,'F11_423' => 6),
    'F11_420' => array('StairF11_f4c' => 12,'EleF11_f4m' => 4,'F11_401' => 8,'F11_402' => 8,'F11_414' => 6,'F11_415' => 6,'F11_419' => 1,'F11_421' => 2,'F11_422' => 4,'F11_423' => 5),
    'F11_421' => array('StairF11_f4c' => 13,'EleF11_f4m' => 4,'F11_401' => 8,'F11_402' => 8,'F11_414' => 5,'F11_415' => 5,'F11_419' => 3,'F11_420' => 2,'F11_422' => 1,'F11_423' => 2),
    'F11_422' => array('StairF11_f4c' => 14,'EleF11_f4m' => 5,'F11_401' => 9,'F11_402' => 9,'F11_414' => 8,'F11_415' => 8,'F11_419' => 5,'F11_420' => 4,'F11_421' => 1,'F11_423' => 4),
    'F11_423' => array('StairF11_f4c' => 15,'EleF11_f4m' => 6,'F11_401' => 10,'F11_402' => 10,'F11_414' => 9,'F11_415' => 9,'F11_419' => 6,'F11_420' => 5,'F11_421' => 2,'F11_422' => 1),
    'A' => array('B' => 1,'C' => 4),
    'B' => array('A' => 1,'C' => 2,'D' => 5),
    'C' => array('A' => 4,'B' => 2,'D' => 1),
    'D' => array('B' => 5,'C' => 1)
);


$graph_obj = new Graph($graph);

$graph_obj = new Graph($graph_data);

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the selected Source and Destination nodes from the form
    $source = $_POST['source'];
    $destination = $_POST['destination'];

    // Call the dijkstra function
    $shortest_path = $graph_obj->dijkstra($source, $destination);

    // Display the result
    echo "Shortest path from $source to $destination: " . implode(' -> ', $shortest_path);
}
?>