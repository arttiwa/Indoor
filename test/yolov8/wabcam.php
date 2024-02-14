<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finding Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('../sidebar.html');
    $matchedLabel2 = null;
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
        //data[] == list room name
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

    ?>

    <div id="main" style="padding:50px">

        <div class="d-flex justify-content-center py-3">
            <form method="post" action="wabcam.php">
                <br />
                <br />
                <input type="submit" value="Open Camera" class="btn btn-primary">
            </form>
        </div>

        <div class="window_form_python">
            <video id="video_feed" autoplay></video>
        </div>

        <div class="pre_output">

            <form id="searchForm" action="../process.php" method="get" class="container">

                <div class="conFindRoom">
                    <div>
                        <label for="startId">Your location is :</label>

                        <input type="text" name="start" id="startId" value="" readonly
                            style="background-color: #bbb; border: 1px solid; border-radius: 5px;">
                    </div>
                    <br>
                    <div>
                        <label for="endId">Your Destination is :</label>
                        <input list="targetList" name="end" id="endId" required>
                        <datalist id="targetList">
                            <option value="test2"></option>
                            <?php generateDatalist("selectLo2"); ?>
                        </datalist>
                    </div>
                </div>
                <br>
                <button type="submit" class="goGo"><i class="fa fa-search"> Search</i></button>

            </form>




            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                //data[] == list room name
                $data = fetchDataFromDatabase();

                if (!empty($data)) {
                    $dataString = implode(" ", array_map('escapeshellarg', $data));
                    $output = shell_exec("python D:/xampp/htdocs/Indoor/test/yolov8/detect_sign.py $dataString 2>&1");

                    if (!empty($output)) {
                        //echo "<pre>$output</pre>";
            

                        $lines = explode(PHP_EOL, $output);
                        foreach ($lines as $line) {
                            if (preg_match("/matched with-->(.*?)<--/", $line, $matches1)) {
                                $matchedLabelOCR = $matches1[1];
                                echo "<script>console.log('Matched with1: $matchedLabelOCR');</script>";
                            } else {
                                echo "<script>console.log('No match for \'matched with-->\' in line: $line');</script>";
                            }

                            if (preg_match("/matched with>>>(.*?)<<</", $line, $matches2)) {
                                $matchedLabelDB = $matches2[1];
                                echo "<script>console.log('Matched with2: $matchedLabelDB');</script>";
                                echo "<script>document.getElementById('startId').value = '$matchedLabelDB';</script>";
                            } else {
                                echo "<script>console.log('No match for \'matched with>>>\' in line: $line');</script>";
                            }

                            if (preg_match("/Similarity000(.*?)000/", $line, $matches3)) {
                                $similarity = $matches3[1];
                                echo "<script>console.log('Similarity: $similarity');</script>";
                            } else {
                                echo "<script>console.log('No match for \'Similarity:\' in line: $line');</script>";
                            }

                            echo "<script>console.log(Matched Label 2: +  $matchedLabelDB);</script>";
                        }
                    } else {
                        echo "Error executing the Python script.";
                    }
                } else {
                    echo "No data found.";
                }
            }
            ?>

        </div>

    </div>



</body>

</html>
<script>
    const video = document.getElementById('video_feed');
    video.src = '/video_feed';
</script>

<style>
    body {
        background-image: url("./1111111.png");

    }

    input {
        border-radius: 5px;
        border: 1px solid;
    }

    button {
        border: 1px solid;
        border-radius: 5px;
        background: rgb(7, 205, 175);
        height: 40px;
        width: 10%;
        margin: 10px;

    }

    .pre_output {
        /* background: #4682B4; */
        background: none;
        margin: auto;
        width: 80%;
        text-align: center;
        /* padding: 10px; */
        border-radius: 10px;
        /* border: 1px solid; */

    }

    .pre_output pre {
        background: rosybrown;
    }

    .conFindRoom {
        margin: auto;
        padding: 20px;
        border-radius: 10px;
        width: 50%;
        background-color: #4682B4;
        /* background-color: #a5e9ef; */
    }
</style>