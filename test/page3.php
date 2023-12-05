<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Capture</title>
</head>
<body>
    <h1>Camera Capture</h1>

    <!-- Button to open the camera -->
    <button onclick="openCamera()">Open Camera</button>

    <!-- Video element to display camera feed -->
    <video id="cameraFeed" autoplay></video>

    <!-- Button to capture a picture -->
    <button onclick="capturePicture()">Capture</button>

    <!-- Canvas to display the captured picture -->
    <canvas id="capturedImage"></canvas>

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
</body>
</html>
