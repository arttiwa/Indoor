<?php
require_once 'graph.php';

$graph_obj = new Graph($graph);

if(isset($_POST['submit'])){
    // Get the selected Source and Destination nodes from the form
    $source = $_POST['source'];
    $destination = $_POST['destination'];

    // Call the dijkstra function
    $shortest_path = $graph_obj->dijkstra($source, $destination);

    // Display the result
    echo "Shortest path from $source to $destination: " . implode(' -> ', $shortest_path);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shortest Path Finder</title>
</head>
<body>
    <h1>Shortest Path Finder</h1>
    
    <form action="process.php" method="post">
        <label for="source">Source Node:</label>
        <select name="source" id="source">
            <!-- สร้างตัวเลือกสำหรับ Source Node จากข้อมูลในกราฟ -->
            <?php foreach ($graph_obj->edges as $node => $destinations) : ?>
                <option value="<?php echo $node; ?>"><?php echo $node; ?></option>
            <?php endforeach; ?>
        </select>

        <br>

        <label for="destination">Destination Node:</label>
        <select name="destination" id="source">
            <!-- สร้างตัวเลือกสำหรับ Destination Node จากข้อมูลในกราฟ -->
            <?php foreach ($graph_obj->edges as $node => $destinations) : ?>
                <option value="<?php echo $node; ?>"><?php echo $node; ?></option>
            <?php endforeach; ?>
        </select>

        <br>

        <input type="submit" name="submit" value="Calculate Shortest Path">
    </form>

    <!-- ส่วนสคริปต์ JavaScript -->
<script>
    // โหลดข้อมูลกราฟมาเก็บไว้ในตัวแปร
    var graphData = <?php echo json_encode($graph_obj->edges); ?>;

    // เมื่อหน้าเว็บโหลดเสร็จ
    document.addEventListener("DOMContentLoaded", function() {
        // เลือก DOM elements ของตัวเลือก
        var sourceSelect = document.getElementById("source");
        var destinationSelect = document.getElementById("destination");

        // ให้ฟังก์ชัน updateDestinations อัปเดตตัวเลือก Destination โดยอิงจาก Source Node
        function updateDestinations() {
            var selectedSource = sourceSelect.value;
            var destinations = graphData[selectedSource] || {};

            // ล้างตัวเลือก Destination เดิมและเพิ่มตัวเลือกใหม่
            destinationSelect.innerHTML = "";
            for (var destination in destinations) {
                var option = document.createElement("option");
                option.value = destination;
                option.textContent = destination;
                destinationSelect.appendChild(option);
            }
        }

        // เมื่อมีการเลือก Source Node
        sourceSelect.addEventListener("change", updateDestinations);

        // เมื่อหน้าเว็บโหลดเสร็จ ให้ทำการอัปเดตตัวเลือก Destination เริ่มต้น
        updateDestinations();
    });
</script>
</body>
</html>
