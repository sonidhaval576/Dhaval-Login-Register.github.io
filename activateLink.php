<?php

session_start();
$conn = mysqli_connect("localhost","root","","signup_signin");

if(isset($_GET['token'])){
    $token = $_GET['token'];

    $updateQuery = "UPDATE register SET `status`='active' WHERE `token`='$token'";

    $query = mysqli_query($conn,$updateQuery);

    if($query){
        if(isset($_SESSION['msg'])){
            $_SESSION['msg'] = 'Acoount Activate Successfully.';
            header('Location:login.php');
        }else{
            $_SESSION['msg'] = 'You are logged out.';
            header('Location:login.php');
        }
    }else{
        $_SESSION['msg'] = 'Acoount Not Activated';
        header('Location:register.php');
    }
}


?>