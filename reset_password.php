<?php

    session_start();
    ob_start();
    $conn = mysqli_connect("localhost","root","","signup_signin");

    if(isset($_POST['submit'])){

        if(isset($_GET['token'])){

            $token = $_GET['token'];

            $newpassword = mysqli_real_escape_string($conn,$_POST['createp']);
            $cpassword = mysqli_real_escape_string($conn,$_POST['repeatp']);

            // for encrypt your password value...
            $pass = password_hash($newpassword,PASSWORD_BCRYPT);
            $cpass = password_hash($cpassword,PASSWORD_BCRYPT);

            if($newpassword === $cpassword){

                $updateQuery = "UPDATE register SET `password`='$pass' WHERE `token`='$token'";
                $query = mysqli_query($conn,$updateQuery);

                if($query){
                    $_SESSION['msg'] = "Your Password has been Updated";
                    header('Location:login.php');
                }else{
                    $_SESSION['passmsg'] = "Your password is not Updated";
                    header('Location:reset_password.php');
                }
            }else{
                $_SESSION['passmsg'] = "Your password is not Matching";
            }

        }else{
            $_SESSION['passmsg'] = "No Token Found";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './links/links.php'; ?>
    <title>Sign up</title>
</head>
<body>

    <div class="container">
        <div class="main_div">
            <form id="form_signup" method="POST" action="">
                <div class="title_div">
                    <h2>Create Account</h2>
                    <div class="msg_style">
                        <p><?php
                            if(isset($_SESSION['passmsg'])){
                                echo $_SESSION['passmsg']; 
                            }else{
                                echo $_SESSION['passmsg'] = "" ;
                            }
                    
                        ?></p>
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="	glyphicon glyphicon-lock"></i></span>
                    <input id="createp" type="password" class="form-control" name="createp" placeholder="New Password" required>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="	glyphicon glyphicon-lock"></i></span>
                    <input id="repeatp" type="password" class="form-control" name="repeatp" placeholder="Confirm Password" required>
                </div>
                <input class="btn btn_class" type="submit" name="submit" value="Update Password">
                <div class="bottom_class">
                    <p>Have An Aaccount ?&nbsp;<a href="login.php" class="loginStyle">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>