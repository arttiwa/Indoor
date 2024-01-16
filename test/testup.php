<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Drag and Drop Image Upload with Rename</title>
    <style>
        /* Styles for the drop area */
        .dropArea {
            width: 300px;
            height: 200px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            margin: 50px auto;
            text-align: center;
            padding: 20px;
            cursor: pointer;
        }

        /* Style for the dropped image */
        .droppedImage {
            max-width: 100%;
            max-height: 100%;
        }

        /* Style for the input field */
        .newNameInput {
            width: 20%;
            margin-top: 10px;
            padding: 5px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <div class="container">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="index.php" class="nav-link " aria-current="page">Home</a></li>
                <li class="nav-item"><a href="beindex.php" class="nav-link">UP 2 DATABASE</a></li>
                <li class="nav-item"><a href="testup.php" class="nav-link active">UPLOAD test</a></li>
                <li class="nav-item"><a href="yolov8\wabcam.php" class="nav-link">USE CAM FOR FINDING ROOM </a></li>
                <li class="nav-item"><a href="maptest.php" class="nav-link">MAP</a></li>
                <li class="nav-item"><a href="page3.php" class="nav-link">page3</a></li>
            </ul>
        </header>
    </div>

    <div class="uppic">

        <div class="dropArea" id="dropAreaTop" ondragover="allowDrop(event)" ondrop="dropImage(event)">
            <p>Drag and drop an image here</p>
            <input type="text" class="newNameInput" placeholder="Enter new name">
        </div>

        <div class="dropArea" id="dropAreaLeft" ondragover="allowDrop(event)" ondrop="dropImage(event)">
            <p>Drag and drop an image here</p>
            <input type="text" class="newNameInput" placeholder="Enter new name">
        </div>
        
        <div class="dropArea" id="dropAreaRight" ondragover="allowDrop(event)" ondrop="dropImage(event)">
            <p>Drag and drop an image here</p>
            <input type="text" class="newNameInput" placeholder="Enter new name">
        </div>

        <div class="dropArea" id="dropAreaBottom" ondragover="allowDrop(event)" ondrop="dropImage(event)">
            <p>Drag and drop an image here</p>
            <input type="text" class="newNameInput" placeholder="Enter new name">
        </div>

    </div>

    <script>
        function allowDrop(event) {
            event.preventDefault();
        }

        function dropImage(event) {
            event.preventDefault();

            // Get the dropped files
            var files = event.dataTransfer.files;

            // Check if there is at least one file
            if (files.length > 0) {
                var file = files[0];

                // Check if the file is an image
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();

                    // Read the image file as a data URL
                    reader.readAsDataURL(file);

                    reader.onload = function (e) {
                        // Create an image element
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'droppedImage';

                        // Append the image to the drop area
                        event.target.innerHTML = '';
                        event.target.appendChild(img);

                        // Create an input field for renaming
                        var input = document.createElement('input');
                        input.type = 'text';
                        input.className = 'newNameInput';
                        input.placeholder = 'Enter new name';
                        event.target.appendChild(input);
                    };
                } else {
                    alert('Please drop an image file.');
                }
            }
        }
    </script>

</body>

</html>
