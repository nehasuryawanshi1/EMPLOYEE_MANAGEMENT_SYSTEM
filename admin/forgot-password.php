<?php
include_once '../dbconnection.php';

$email = $_POST['Email'];
if(isset($_POST['submit']))
{
    $result = mysqli_query($conn,"SELECT * FROM admin WHERE email='$email'");
    $row = mysqli_fetch_assoc($result);
    $fetch_user_mail=$row['email'];
    $fetch_user_pass=$row['password'];
    $email = $_POST['Email'];
    if($email==$fetch_user_mail) {
                $to = $fetch_user_mail;
                $subject = "Forgot Password ";
                // $txt = "<span>Your Password : ".$fetch_user_pass."</span>";
                $txt = "If you want change Password .. Please <a href='/changepassword.php'>Click here</a>";

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                mail($to,$subject,$txt,$headers);
                echo " <script>alert('Password Link is shared On Registered Email Please check Email');location.replace('login.php')</script> ";
            }
                else{
                 echo "<script>alert('Invalid Email ID');location.replace('')</script> ";
                }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>SsquareIT - Forgot Password</title>

    <link rel="shortcut icon" href="../img/logop.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="../img/logop.png" alt="Logo">
                    </div>
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Forgot Password?</h1>
                            <p class="account-subtitle">Enter your email to get a password reset link</p>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="Email" placeholder="Email">
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block" name="submit" type="submit">Reset Password</button>
                                </div>
                            </form>
                            <div class="text-center dont-have">Remember your password? <a href="login.php">Login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Scripts -->
    <script src="assets/js/jquery-3.5.1.min.js"></script>

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>