<?php
    session_start();

    if(!isset($_SESSION['username'])){
        ?>
            <div class="redErrorMsg">
                <h4>You Are Logged Out</h4>
            </div>
        <?php
        header('location:login.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './links/links.php'; ?>
    <title>Dashboard</title>
</head>
<body>

    <div class="container">
        <div class="main_div">
            <h2>This Is <?php echo $_SESSION['username']; ?></h2><br>
            <a href="logout.php" class="btn btn_class2">Logout</a>
        </div>
    </div>
</body>
</html>