<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Sign</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="beindex.php" class="nav-link">UP 2 DATABASE</a></li>
                <li class="nav-item"><a href="yolov8\wabcam.php" class="nav-link">USE CAM FOR FINDING ROOM </a></li>
                <li class="nav-item"><a href="maptest.php" class="nav-link">MAP</a></li>
                <li class="nav-item"><a href="page3.php" class="nav-link active">page3</a></li>
            </ul>
        </header>
    </div>
    <h1>Find Sign</h1>

    <div class="butCon">
        <button onclick="detect_sign()">Open Camera</button>
        <button onclick="refresh()">Capture</button>
    </div>
    <div class="camOut">
        <video id="cameraFeed" autoplay></video>
        <canvas id="capturedImage"></canvas>
    </div>




    <script>
        // Function to start camera feed
        async function detect_sign() {
            try {
                const video = document.getElementById('cameraFeed');
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
            } catch (error) {
                console.error('Error accessing camera:', error);
            }
        }

        // Function to refresh camera and output
        function refresh() {
            const video = document.getElementById('cameraFeed');
            const canvas = document.getElementById('capturedImage');
            const context = canvas.getContext('2d');

            // Capture current frame from video to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Additional logic or actions you want to perform
            // e.g., send the captured image to the server for processing

            // Stop the video stream to release resources
            const stream = video.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            video.srcObject = null;
        }
    </script>
    <style>
        body {
            background: #ddd;
            margin: auto;
            text-align: center;

            .butCon {
                height: 30px;

                button {
                    background-color: #0000CC;
                    border-radius: 5px;
                    border: none;
                    height: 100%;
                    width: 10%;
                    color: white;
                    margin-left: 10px;
                }
            }

            .camOut {
                margin: 20px;
            }
        }
    </style>
</body>

</html>