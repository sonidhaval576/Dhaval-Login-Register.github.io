<?php

    session_start();
    $conn = mysqli_connect("localhost","root","","signup_signin");

    if(isset($_POST['submit'])){
        $email1 = $_POST['email'];
        $password = $_POST['password'];

        $email_search = "SELECT * FROM register WHERE email='$email1' and status='active' ";
        $query_email_search = mysqli_query($conn,$email_search);
        $email_search_count = mysqli_num_rows($query_email_search);

        if($email_search_count){
            $email_pass = mysqli_fetch_assoc($query_email_search);

            $db_email_pass = $email_pass['password'];
            $_SESSION['username'] = $email_pass['username'];

            $db_email_pass_decode = password_verify($password,$db_email_pass);

            if($db_email_pass_decode){
                if(isset($_POST['rememberme'])){
                ?>
                    <div class="greenErrorMsg">
                        <h4>Login Successfully</h4>
                    </div>
                    <script>
                        location.replace('dashboard.php');
                    </script>
                <?php
                    setcookie('emailCookie',$email1,time()+86400);
                    setcookie('passwordCookie',$password,time()+86400);
                }else{
                ?>
                    <div class="greenErrorMsg">
                        <h4>Login Successfully</h4>
                    </div>
                    <script>
                        location.replace('dashboard.php');
                    </script>
                <?php
                    
                }
            }else{
            ?>
                <div class="redErrorMsg">
                    <h4>Password Incorrect</h4>
                </div>
            <?php
            }
        }
        else{
            ?>
                <div class="redErrorMsg">
                    <h4>Invalid Email ID</h4>
                </div>
            <?php
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include './links/links.php'; ?>
    <title>Login</title>
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
                <div class="msg_style">
                    <p><?php
                        if(isset($_SESSION['msg'])){
                            echo $_SESSION['msg']; 
                        }else{
                            echo $_SESSION['msg'] = "You are logged out. please login again." ;
                        }
                
                    ?></p>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input id="email" type="text" class="form-control" name="email" placeholder="Enter Email ID" value="<?php if(isset($_COOKIE['emailCookie'])){ echo $_COOKIE['emailCookie']; } ?>" required>
                    <div id="emailErrorId"></div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Enter Password" value="<?php if(isset($_COOKIE['passwordCookie'])){ echo $_COOKIE['passwordCookie']; } ?>" required>
                    
                    <div id="passwordErrorId"></div>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="rememberme">
                    Remember Me
                    <input type="checkbox" class="showPass" onclick="myFunction()">Show Password
                </div>
                <input class="btn btn_class" type="submit" name="submit" value="Login Now">
                <div class="bottom_class">
                    <p><a href="recover_email.php" class="loginStyle">Forgot Password?</a></p>
                    <p>Not Have An Aaccount ?&nbsp;<a href="register.php" class="loginStyle">SignUp</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

</body>
</html>