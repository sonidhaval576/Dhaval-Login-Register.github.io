<?php

session_start();
$conn = mysqli_connect("localhost","root","","signup_signin");

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $emailquery = "SELECT * FROM register WHERE email='$email'";
    $query = mysqli_query($conn,$emailquery);

    $emailCount = mysqli_num_rows($query);

    if($emailCount){

        $userdata = mysqli_fetch_array($query);

        $username = $userdata['username'];
        $token = $userdata['token'];
        
        $subject = "Password reset";
        $body = "Hello " .$username .". Please Click Here To Reset Your Password
        http://localhost/PHP/signup_signin/reset_password.php?token=$token";
        $sender_email = "From:sonidhaval576@gmail.com";

        if(mail($email,$subject,$body,$sender_email)){
            $_SESSION['msg'] = "Check Your Mail To Reset Your Password $email";
            header('Location:login.php');
        }else{
            echo "Email sending Faild..";
        }
    }
    else{
    ?>
        <div class="redErrorMsg">
            <h4>No Email Address Found!</h4>
        </div>
    <?php
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './links/links.php'; ?>
    <title>Recover Email</title>
</head>
<body>

    <div class="container">
        <div class="main_div">
            <form id="form_signup" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                <div class="title_div">
                    <h2>Recover Your Account</h2>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input id="email" type="text" class="form-control" name="email" placeholder="Email Address" required>
                    <div id="emailErrorId"></div>
                </div>
                <input class="btn btn_class" type="submit" name="submit" value="Send Mail">
                <div class="bottom_class">
                    <p>Have An Aaccount ?&nbsp;<a href="login.php" class="loginStyle">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>