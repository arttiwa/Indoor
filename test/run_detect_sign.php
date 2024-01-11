<?php

// Run the detect_sign.py script
$output = shell_exec('python D:\\xampp\\htdocs\\Indoor\\test\\yolov8\\detect_sign.py');

// Output the result
echo $output;

?>