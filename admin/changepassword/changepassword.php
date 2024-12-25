<?php
require '../conn.php';
if (isset($_POST['pass']) && isset($_POST['cpass'])) {
    if (empty($_POST['pass'])) {
        echo " <script>alert('password can not be empty...!');location.replace('')</script> ";
    } else {
        $pass = mres($conn, $_POST['pass']);
        $cpass = mres($conn, $_POST['cpass']);
        if ($pass === $cpass) {
            $hashPass = password_hash($pass, PASSWORD_BCRYPT);
            $passUQ = mysqli_query($conn, "UPDATE admin SET pass='$hashPass'");
            if ($passUQ) {
                echo " <script>alert('password has been changed...!');location.replace('index.php')</script> ";
            } else {
                echo " <script>alert('something went wrong please try again later...!');location.replace('forgot.php')</script> ";
            }
        } else {
            echo " <script>alert('passwords are not matching...!');location.replace('')</script> ";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ganraj Travels - Login Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="favicon.ico" />
    <link rel="stylesheet" type="text/css" href="login_files/vendor/bootstrap/css/bootstrap.min.css">   
    <link rel="stylesheet" type="text/css" href="login_files/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="login_files/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="login_files/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="login_files/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="login_files/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" type="text/css" href="login_files/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="login_files/vendor/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="login_files/css/util.css">
    <link rel="stylesheet" type="text/css" href="login_files/css/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('login_files/images/bg-01.jpg');">
           <div class="wrap-login100 p-t-30 p-b-50">
                <span class="login100-form-title p-b-41">
                    Change Password
                </span>
                    <form class="form-horizontal form-material" enctype="multipart/form-data" method="post">
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0" style="color:white;font-size: 20px;">Enter Password</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="password" required name="pass" placeholder="Create New Password" class="form-control p-1 border-dark border-1 input_password">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="col-md-12 p-0" style="color:white;font-size: 20px;">Repeat Password</label>
                            <div class="col-md-12 border-bottom p-0">
                                <input type="password" required name="cpass" placeholder="Repeat New Password" class="form-control p-1 border-dark border-1 input_password">
                            </div>
                        </div>
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" id="show_pass">
                            <label class="form-check-label  user-select-none" for="show_pass" style="color:white;font-size: 20px;">Show Password</label>
                        </div>
                        <button type="submit" class="btn text-white btn-success w-100">Change Password</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
   
     </div>
    </div>


    <!--===============================================================================================-->
<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
 <!-- Bootstrap tether Core JavaScript -->
 <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
 <script src="js/app-style-switcher.js"></script>
 <!--Wave Effects -->
 <script src="js/waves.js"></script>
 <!--Menu sidebar -->
 <script src="js/sidebarmenu.js"></script>
 <!--Custom JavaScript -->
 <script src="js/custom.js"></script>
    <script src="login_files/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="login_files/vendor/animsition/js/animsition.min.js"></script>
    <script src="login_files/vendor/bootstrap/js/popper.js"></script>
    <script src="login_files/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="login_files/vendor/select2/select2.min.js"></script>
    <script src="login_files/vendor/daterangepicker/moment.min.js"></script>
    <script src="login_files/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="login_files/vendor/countdowntime/countdowntime.js"></script>
    <script src="login_files/js/main.js"></script>

</body>

</html>