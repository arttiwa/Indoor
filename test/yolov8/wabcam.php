<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finding Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('../sidebar.html'); ?>

    <div id="main" style="padding:50px">
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

</div>

</body>

</html>
<script>
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