<?php

    session_start();
    $conn = mysqli_connect("localhost","root","","signup_signin");

    if(isset($_POST['submit'])){
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $phone = mysqli_real_escape_string($conn,$_POST['phone']);
        $password = mysqli_real_escape_string($conn,$_POST['createp']);
        $cpassword = mysqli_real_escape_string($conn,$_POST['repeatp']);

        // for encrypt your password value...
        $pass = password_hash($password,PASSWORD_BCRYPT);
        $cpass = password_hash($cpassword,PASSWORD_BCRYPT);

        //for genrate random token...
        $token = bin2hex(random_bytes(15));

        $emailQuery = "SELECT * FROM register WHERE email='$email'";
        $email_mysqli_query = mysqli_query($conn,$emailQuery);

        $emailCount = mysqli_num_rows($email_mysqli_query);

        if($emailCount>0){
        ?>
            <div class="redErrorMsg">
                <h4>This Email Already Exists</h4>
            </div>
        <?php
        }
        else{
            if($password === $cpassword){

                $insertQuery = "INSERT INTO `register`(`username`, `email`, `mobile`, `password`, `cpassword`,`token`,`status`) VALUES ('$username','$email','$phone','$pass','$cpass','$token','inactive')";

                $query = mysqli_query($conn,$insertQuery);

                if($query){
                    $subject = "Email Activation";
                    $body = "Hello " .$username .". Please Click Here To Aactivate Your Account
                    http://localhost/PHP/signup_signin/activateLink.php?token=$token";
                    $sender_email = "From:sonidhaval576@gmail.com";

                    if(mail($email,$subject,$body,$sender_email)){
                        $_SESSION['msg'] = "Check Your Mail To Activate Your Account $email";
                        header('Location:login.php');
                    }else{
                        echo "Email sending Faild..";
                    }
                }
            }   
            else{
            ?>
                <div class="redErrorMsg">
                    <h4>Passwords Are Not Matching</h4>
                </div>
            <?php
            }
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
            <form id="form_signup" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                <div class="title_div">
                    <h2>Create Account</h2>
                    <a href="#" class="fb btn">
                        <i class="fa fa-facebook fa-fw"></i> Login with Facebook
                    </a>
                    <a href="#" class="google btn"><i class="fa fa-google fa-fw">
                        </i> Login with Google+
                    </a><br>
                    <h2 class="underlineH2"><span>OR</span></h2>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="name" type="text" class="form-control" name="username" placeholder="Full Name" required>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input id="email" type="text" class="form-control" name="email" placeholder="Email Address" required>
                    <div id="emailErrorId"></div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                    <input id="phone" type="text" class="form-control" name="phone" placeholder="Phone Number" required>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="	glyphicon glyphicon-lock"></i></span>
                    <input id="createp" type="password" class="form-control" name="createp" placeholder="Create Password" required>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="	glyphicon glyphicon-lock"></i></span>
                    <input id="repeatp" type="password" class="form-control" name="repeatp" placeholder="Repeat Password" required>
                </div>
                <input class="btn btn_class" type="submit" name="submit" value="Create Account">
                <div class="bottom_class">
                    <p>Have An Aaccount ?&nbsp;<a href="login.php" class="loginStyle">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>