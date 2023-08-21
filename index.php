<?php 
    //include('server.php'); 
    session_start();
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "you must be crazy";
        header('location: web.php');
    }
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['username']);
        header('location: web.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h2>Home Page</h2>
    </div>
    <div class="content">
        <?php if (isset($_SESSION['username'])) :?>
            <p>welcome <strong><?php echo $_SESSION['username'] ; ?></strong></p> 
            <p><a href="index.php?logout='1'" style="color: red;">Logout</a></p>
        <?php endif ?>
    </div>
</body>
</html>