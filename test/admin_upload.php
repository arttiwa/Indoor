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
                <li class="nav-item"><a href="up_show_DB.php" class="nav-link">UP 2 DATABASE</a></li>
                <li class="nav-item"><a href="admin_upload.php" class="nav-link active">UPLOAD test</a></li>
                <li class="nav-item"><a href="yolov8\wabcam.php" class="nav-link">USE CAM FOR FINDING ROOM </a></li>
                <li class="nav-item"><a href="mapapi.php" class="nav-link">MAP</a></li>
                <li class="nav-item"><a href="page3.php" class="nav-link">page3</a></li>
            </ul>
        </header>
    </div>
    <form action="uploadtest2.php" method="post" enctype="multipart/form-data">
        <input type="text" class="BlockUpDown" id="fileName1" name="fileName1" placeholder="Enter next point name"
            required><br><br>
        <div class="uploadFields">
            <label for="fileInput1">File 1:</label>
            <input type="file" id="fileInput1" name="fileUpload1"
                onchange="previewImage(this, 'preview1', 'fileName1')"><br><br>
            <div id="preview1"></div>
        </div>

        <div class="upDown"><span style='font-size:100px;'>&#8593;</span></div>
        <div class="midd">
            <div class="uploadFields">
                <input type="text" class="newPoint" id="fileName2" name="fileName2" placeholder="Left point name" required><br><br><br>

                <label for="fileInput2">File 2:</label>
                <input type="file" id="fileInput2" name="fileUpload2"
                    onchange="previewImage(this, 'preview2', 'fileName2')"><br><br>
                <div id="preview2"></div>
            </div>

            <div class="leftRightSpan"><span style='font-size:100px;'>&#8592;</span></div>
            <figure class="circle">
                <input type="text" class="newPoint" name="fileNameMid" id="fileNameMid" placeholder="Enter point name"
                    required>
            </figure>
            <div class="leftRightSpan"><span style='font-size:100px;'>&#8594;</span></div>

            <div class="uploadFields">
                <input type="text" class="newPoint" id="fileName3" name="fileName3" placeholder="Right point name"required><br><br><br>
                <label for="fileInput3">File 3:</label>
                <input type="file" id="fileInput3" name="fileUpload3"
                    onchange="previewImage(this, 'preview3', 'fileName3')"><br><br>
                <div id="preview3"></div>
            </div>
        </div>
        <div class="upDown"><span style='font-size:100px;'>&#8595;</span></div>

        <input type="text" class="BlockUpDown" id="fileName4" name="fileName4" placeholder="Enter before point name"
            required><br><br>
        <div class="uploadFields">
            <label for="fileInput4">File 4:</label>
            <input type="file" id="fileInput4" name="fileUpload4"
                onchange="previewImage(this, 'preview4', 'fileName4')"><br><br>
            <div id="preview4"></div><br><br>
            <br><br>
        </div>

        <input type="submit" value="Upload">
    </form>

    <script>
        function previewImage(input, previewId, fileNameAll) {
            var preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = new Image();
                    img.src = e.target.result;

                    img.onload = function () {
                        var canvas = document.createElement('canvas');
                        var ctx = canvas.getContext('2d');
                        var maxWidth = 300;
                        var maxHeight = 300;
                        var width = img.width;
                        var height = img.height;

                        if (width > height) {
                            if (width > maxWidth) {
                                height *= maxWidth / width;
                                width = maxWidth;
                            }
                        } else {
                            if (height > maxHeight) {
                                width *= maxHeight / height;
                                height = maxHeight;
                            }
                        }

                        canvas.width = width;
                        canvas.height = height;
                        ctx.drawImage(img, 0, 0, width, height);

                        var oldFileName = input.files[0].name;
                        var newFileName = generateNewFileName(input, previewId, fileNameAll);

                        console.log("Old File Name:", oldFileName);
                        console.log("New File Name:", newFileName);

                        preview.innerHTML = '<img src="' + canvas.toDataURL('image/jpeg') + '" alt="Preview">';
                    };
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function generateNewFileName(input, previewId, fileNameAll) {
            var oldFileName = input.files[0].name;
            var timestamp = new Date().getTime();
            var extension = oldFileName.split('.').pop();
            var fileNameMid = document.getElementById('fileNameMid').value;
            let setFileNameAll = document.getElementById(fileNameAll).value

            // Use the value from the fileNameMid input field in the new file name
            var newFileName = fileNameMid + "-" + setFileNameAll + "." + extension;

            return newFileName;
        }
    </script>


</body>
<style>
    form {
        text-align: center;
        padding: 50px;
    }



    .uploadFields {
        /* background: #000; */
    }


    .midd {
        display: inline-flex;
        text-align: center;
        /* background: #80C1DE; */
        width: 100%;
    }

    .leftRightSpan {
        display: flex;
        align-items: center;
    }

    .upDown {
        margin: auto;
        text-align: center;
    }

    .circle {
        display: block;
        background: gainsboro;
        border-radius: 50%;
        height: 150px;
        width: 150px;
        margin: auto;
        border: 2px dashed #555;

    }

    .newPoint {
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






    .uploadBut {
        border: 1px solid gray;
        border-radius: 5px;
        width: 20%;
        height: 40px;
        background: #6666FF;

    }

    .uploadPic {
        margin-top: 100px;
        width: 100%;
        text-align: center;
    }


    .footter {
        padding: 100px;
    }
</style>

</html>