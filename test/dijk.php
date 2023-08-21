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
    'A' => ['B' => 1, 'C' => 4],
    'B' => ['A' => 1, 'C' => 2, 'D' => 5],
    'C' => ['A' => 4, 'B' => 2, 'D' => 1],
    'D' => ['B' => 5, 'C' => 1]
];

$start = 'A';
$end = 'D';

$shortestPath = dijkstra($graph, $start, $end);
echo "Shortest path from $start to $end: " . implode(' -> ', $shortestPath);
?>