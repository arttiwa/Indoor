<?php
session_start();
include_once 'dbConfig.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shortest Path Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php include('sidebar.html'); ?>

    <div class="ad">

        <div class="container">
            <div class="row mt-5">
                <div class="col-12">
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <div
                            class="text-center justify-content-center align-items-center p-4 border-2 border-dashed rounded-3">
                            <h6 class="my-2">Select image file to upload</h6>
                            <input type="file" name="file" class="form-control streched-link"
                                accept="image/gif, image/jpeg, image/png">
                            <p class="small mb-0 mt-2"><b>Note:</b> Only JPG, JPEG, PNG & GIF files are allowed to
                                upload
                            </p>
                        </div>
                        <div class="d-sm-flex justify-content-end mt-2">
                            <input type="submit" name="submit" value="Upload" class="btn btn-sm btn-primary mb-3">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <?php if (!empty($_SESSION['statusMsg'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php
                        echo $_SESSION['statusMsg'];
                        unset($_SESSION['statusMsg']);
                        ?>
                    </div>
                <?php } ?>
            </div>
            <!-- SELECT pic to show on web -->
            <div class="row g-2">

                <?php
                $query = $conn->query("SELECT * FROM images ORDER BY uploaded_on DESC;
                ");
                //WHERE file_name IN ('Screenshot 2021-09-16 175807.png', 'picme.jpg') ORDER BY FIELD(file_name, 'Screenshot 2021-09-16 175807.png', 'picme.jpg')
                //SELECT * FROM images WHERE file_name IN ('picme.jpg', 'Screenshot 2021-09-16 175807.png') ORDER BY uploaded_on DESC;
                if ($query->num_rows > 0) {
                    while ($row = $query->fetch_assoc()) {
                        $imageURL = 'uploads/' . $row['file_name'];
                        ?>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card shadow h-100">
                                <img src="<?php echo $imageURL ?>" alt="" width="100%" class="card-img">
                            </div>
                        </div>
                        <?php
                    }
                } else { ?>
                    <p>No image found...</p>
                <?php } ?>

            </div>
        </div>
    </div>
</body>

</html>
<style>
    .ad{
        padding-top: 50px;
    }
</style>