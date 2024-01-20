<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finding Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="/indoor/test/index.php" class="nav-link" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="/indoor/test/up_show_DB.php" class="nav-link">UPLOAD PICTURE TO DATABASE</a></li>
                <li class="nav-item"><a href="/indoor/test/yolov8/wabcam.php" class="nav-link active">USE CAM FOR FINDING ROOM</a></li>
                <li class="nav-item"><a href="/indoor/test/mapapi.php" class="nav-link">MAP</a></li>
                <li class="nav-item"><a href="/indoor/test/page3.php" class="nav-link">page3</a></li>
            </ul>
        </header>
    </div>

    <div class="d-flex justify-content-center py-3">
        <form method="post" action="wabcam.php">
            <br />
            <input type="submit" value="Open Camera" class="btn btn-primary">
            <br />
            <br />
        </form>
    </div>
    <div class="window_form_python">
        <video id="video_feed" autoplay></video>
    </div>
    <div class="pre_output">
        <h1>Now you stay at . . . </h1>
        <?php
        function fetchDataFromDatabase()
        {
            $conn = new mysqli("localhost", "root", "", "indoor_db");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT roomname FROM room";
            $result = $conn->query($sql);

            if ($result === false) {
                die("Query failed: " . $conn->error);
            }

            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row["roomname"];
            }

            $conn->close();
            return $data;
        }

        function generateDatalist($functionName)
        {
            $data = fetchDataFromDatabase();

            if (!empty($data)) {
                foreach ($data as $roomname) {
                    echo "<option value=\"" . htmlspecialchars($roomname) . "\">" . htmlspecialchars($roomname) . "</option>";
                }
            } else {
                echo "No data found.";
            }

            // Save data as a JSON file
            $jsonEncodedData = json_encode($data);
            file_put_contents("received_data.json", $jsonEncodedData);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = fetchDataFromDatabase();

            if (!empty($data)) {
                $dataString = implode(" ", array_map('escapeshellarg', $data));
                $output = shell_exec("python D:/xampp/htdocs/Indoor/test/yolov8/detect_sign.py $dataString 2>&1");

                if (!empty($output)) {
                    echo "<pre>$output</pre>";
                } else {
                    echo "Error executing the Python script.";
                }
            } else {
                echo "No data found.";
            }
        }
        ?>





        <div class="conFindRoom">
            <div>
                <h4>Target : </h4>
                <input list="targetList" name="end" id="endId" required>
                <datalist id="targetList">
                    <option value="test2"></option>
                    <?php generateDatalist("selectLo2"); ?>
                </datalist>
            </div>
        </div>
    </div>



</body>

</html>
<script>
    // JavaScript to update the video feed
    const video = document.getElementById('video_feed');
    video.src = '/video_feed';
</script>

<style>
    .pre_output {
        background: wheat;
        margin: auto;
        width: 80%;
    }

    .pre_output pre {
        background: rosybrown;
    }
</style>