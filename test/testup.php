<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Drag and Drop Image Upload with Rename</title>



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

        <div class="dropArea" id="dropAreaTop" data-drop-area="top" ondragover="allowDrop(event)" ondrop="dropImage(event)">
            <p>Drag and drop an image here</p>
            <input type="text" class="newNameInput" placeholder="Enter new name">
        </div>


        <div class="upDown"><span style='font-size:100px;'>&#8593;</span></div>
        <div class="midd">
            <div class="dropArea" id="dropAreaLeft" data-drop-area="left" ondragover="allowDrop(event)" ondrop="dropImage(event)">
                <p>Drag and drop an image here</p>
                <input type="text" class="newNameInput" placeholder="Enter new name">
            </div>        

            <div class="leftRightSpan"><span style='font-size:100px;'>&#8592;</span></div>
            <figure class="circle"><input type="text" class="newPoint" placeholder="Enter point name"></figure>
            <div class="leftRightSpan"><span style='font-size:100px;'>&#8594;</span></div>

            <div class="dropArea" id="dropAreaRight" data-drop-area="Right" ondragover="allowDrop(event)" ondrop="dropImage(event)">
                <p>Drag and drop an image here</p>
                <input type="text" class="newNameInput" placeholder="Enter new name">
            </div>
        </div>
        <div class="upDown"><span style='font-size:100px;'>&#8595;</span></div>


        <div class="dropArea" id="dropAreaBottom" data-drop-area="bottom" ondragover="allowDrop(event)" ondrop="dropImage(event)">
            <p>Drag and drop an image here</p>
            <input type="text" class="newNameInput" placeholder="Enter new name">
        </div>

    </div>
    
    <div class="uploadPic">
        <button class="uploadBut" onclick="uploadAll()">Upload</button>
    </div>

    <script>
        async function uploadAll() {
            console.log('Upload button pressed');

            var dropAreas = document.querySelectorAll('.dropArea');
            console.log('Upload button 0');

            for (const dropArea of dropAreas) {
                var input = dropArea.querySelector('.newNameInput');
                var fileInput = dropArea.querySelector('input[type="file"]');
                console.log('Upload button 111');

                if (!fileInput) continue;  // Use 'continue' to move to the next iteration if no file input is found

                var file = fileInput.files[0];
                console.log('Upload button 1');

                if (input && file && input.value.trim() !== '') {
                    var newName = input.value.trim();
                    var dropAreaId = dropArea.getAttribute('data-drop-area');
                    var pointName = document.querySelector('.circle .newPoint').value.trim();

                    console.log('Upload button 2');
                    var formData = new FormData();
                    formData.append('file', file);
                    formData.append('dropAreaId', dropAreaId);
                    formData.append('newName', newName);
                    formData.append('pointName', pointName);

                    console.log('Upload button formData');
                    console.log(formData);

                    try {
                        const response = await fetch('upload.php', {
                            method: 'POST',
                            body: formData,
                        });

                        if (!response.ok) {
                            throw new Error('Error uploading file');
                        }

                        const data = await response.json();
                        alert('File uploaded successfully');
                        console.log('File uploaded successfully', data);
                    } catch (error) {
                        alert('Error uploading file. Please try again.');
                        console.error('Error uploading file', error);
                    }
                } else {
                    alert('Please fill in all the required fields.');
                }
            }
        }





        function uploadFile(file, dropAreaId, newName, pointName) {
            var formData = new FormData();
            formData.append('file', file);
            formData.append('dropAreaId', dropAreaId);
            formData.append('newName', newName);
            formData.append('pointName', pointName);

            fetch('upload.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error uploading file');
                }
                console.log('File uploaded successfully');
            })
            .catch(error => {
                console.error(error);
            });
        }



        function allowDrop(event) {
            event.preventDefault();
        }

        function dropImage(event) {
            event.preventDefault();

            var files = event.dataTransfer.files;

            if (files.length > 0) {
                var file = files[0];

                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();

                    reader.readAsDataURL(file);

                    reader.onload = function (e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'droppedImage';

                        // Create a container for the image and input
                        var container = document.createElement('div');
                        container.className = 'dropAreaContainer';
                        container.appendChild(img);

                        var input = document.createElement('input');
                        input.type = 'text';
                        input.className = 'newNameInput';
                        input.placeholder = 'Enter new name';
                        container.appendChild(input);

                        // Append the container to the drop area
                        event.target.innerHTML = '';
                        event.target.appendChild(container);

                        // Send the file to the server
                        var dropAreaId = event.target.getAttribute('data-drop-area');
                        var newName = input.value.trim();  // Get the newName at the time of uploading
                        var pointName = document.querySelector('.circle .newPoint').value.trim();
                        uploadFile(file, dropAreaId, newName, pointName);
                    };
                } else {
                    alert('Please drop an image file.');
                }
            }
        }

    </script>

<div class="footter"></div>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dropAreaId = $_POST['dropAreaId'];
        $newName = $_POST['newName'];
        $pointName = $_POST['pointName'];

        $uploadsDirectory = 'D:\xampp\htdocs\Indoor\test\uploads';

        if (!file_exists($uploadsDirectory)) {
            mkdir($uploadsDirectory, 0777, true);
        }

        $tempFilePath = $_FILES['file']['tmp_name'];
        $originalFileName = $_FILES['file']['name'];
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

        $baseName = $pointName . '-' . $newName;

        switch ($dropAreaId) {
            case 'top':
                $newFileName = $baseName . '-T';
                break;
            case 'left':
                $newFileName = $baseName . '-L';
                break;
            case 'point':
                $newFileName = $baseName . '-P';
                break;
            case 'Right':
                $newFileName = $baseName . '-R';
                break;
            case 'bottom':
                $newFileName = $baseName . '-B';
                break;
            default:
                $newFileName = $baseName;
                break;
        }

        $targetFilePath = $uploadsDirectory . '/' . $newFileName . '.' . $fileExtension;

        move_uploaded_file($tempFilePath, $targetFilePath);

        // You can perform additional actions here if needed

        echo 'File uploaded successfully';
    } else {
        http_response_code(400);
        echo 'Invalid request';
    }
?>


</body>
<style>

        
    /* Styles for the drop area */
    .dropArea {
        width: 300px;
        height: 250px;
        border: 2px dashed #555;
        border-radius: 8px;
        margin: 50px auto;
        text-align: center;
        padding: 20px;
        cursor: pointer;

        background-color: #B0C4DE; 

    }





    .midd{
        display: inline-flex;
        text-align: center;
        /* background: #80C1DE; */
        width: 100%;
    }

    .leftRightSpan{
        display: flex;
        align-items: center;
    }
    .upDown{
        margin: auto;
        text-align: center;
    }

    .circle {
        display: block;
        background: gainsboro;
        border-radius: 50%;
        height: 200px;
        width: 200px;
        margin: auto;
        border: 2px dashed #555;

    }
    .newPoint{
        margin-top: 40%;
        text-align: center;
        justify-items: center;
        width: 80%;
        border: 1px solid gray;
        border-radius: 3px;
    }




    /* Style for the dropped image */
    .droppedImage {
        max-width: 100%;
        max-height: 100%;
    }

    /* Style for the input field */
    .newNameInput {
        width: 100%;
        margin-top: 10px;
        padding: 5px;
        box-sizing: border-box;
        border: 2px solid gray;
        border-radius: 5px;

    }






    .uploadBut{
        border: 1px solid gray;
        border-radius: 5px; 
        width: 20%;
        height: 40px;
        background: #6666FF;
                
    }
    .uploadPic{
        margin-top: 100px;
        width: 100%;
        text-align: center;
    }


    .footter{
        padding: 100px;
    }
</style>
</html>
