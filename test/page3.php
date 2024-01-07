<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Capture</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="beindex.php" class="nav-link">UPLOAD PICTURE TO DATABASE</a></li>
                <li class="nav-item"><a href="capture.php" class="nav-link">USE CAM FOR FINDING ROOM </a></li>
                <li class="nav-item"><a href="maptest.php" class="nav-link">MAP</a></li>
                <li class="nav-item"><a href="page3.php" class="nav-link active">page3</a></li>
            </ul>
        </header>
    </div>
    <h1>Camera Capture</h1>

    <div class="butCon">
        <button onclick="openCamera()">Open Camera</button>
        <button onclick="capturePicture()">Capture</button>
    </div>
    <div class="camOut">
        <video id="cameraFeed" autoplay></video>
        <canvas id="capturedImage"></canvas>
    </div>



</body>

</html>


<script>
    let cameraStream = null;

    async function openCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            const cameraFeed = document.getElementById('cameraFeed');
            cameraFeed.srcObject = stream;
            cameraStream = stream;
        } catch (error) {
            console.error('Error accessing the camera:', error);
        }
    }

    function capturePicture() {
        const cameraFeed = document.getElementById('cameraFeed');
        const capturedImage = document.getElementById('capturedImage');
        const context = capturedImage.getContext('2d');

        // Ensure the video dimensions match the canvas dimensions
        capturedImage.width = cameraFeed.videoWidth;
        capturedImage.height = cameraFeed.videoHeight;

        // Draw the current video frame onto the canvas
        context.drawImage(cameraFeed, 0, 0, capturedImage.width, capturedImage.height);

        // You can now work with the captured image as needed
        // For example, you can convert it to a data URL and send it to a server

        // To stop the camera stream (optional)
        if (cameraStream) {
            const tracks = cameraStream.getTracks();
            tracks.forEach(track => track.stop());
        }

        // Extract the captured image data (Base64-encoded)
        const base64Image = capturedImage.toDataURL('image/jpeg'); // or 'image/png'

        // Send the captured image data to the server for processing
        sendImageToServer(base64Image);
    }

    function sendImageToServer(base64Image) {
        // Make an HTTP POST request to your server with the image data
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'your_server_endpoint.php'); // Replace with your server endpoint
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify({ imageData: base64Image }));

        // Handle the response from the server if needed
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                // Handle the response from the server
                console.log(response);
            }
        };
    }
</script>


<style lang="scss" :scope>
    body {
        background: #ddd;
        margin: auto;
        text-align: center;



        .butCon {
            /* background: #000; */
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
            margin: 20px
        }

    }
</style>