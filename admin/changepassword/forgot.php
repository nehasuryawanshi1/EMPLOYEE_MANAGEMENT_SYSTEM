<?php
require "../conn.php";

$email =mres($conn, $_POST['email']);
if(isset($_POST['submit']))
{
    $result = mysqli_query($conn,"SELECT * FROM admin where mail='$email'");
    $row = mysqli_fetch_assoc($result);
    $fetch_user_mail=$row['mail'];
    $email =mres($conn, $_POST['email']);
    if($email==$fetch_user_mail) {
                $to = $fetch_user_mail;
                $subject = "Forgot Password ";
                $txt = "If you want change Password .. Please <a href='https://maticinfo.in/Ganraj1/12/admin/changepassword.php'>Click here</a>";

               	// Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                mail($to,$subject,$txt,$headers);
                echo " <script>alert('Link is shared On Registered Email Please check Email');location.replace('index.php')</script> ";
            }
                else{
                 echo "<script>alert('invalid mail');location.replace('')</script> ";
                }
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Ganraj Travels - Forgot Admin Dashboard</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login_files/css/util.css">
	<link rel="stylesheet" type="text/css" href="login_files/css/main.css">
	<!--===============================================================================================-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('login_files/images/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Forgot Password
				</span>
				 <p class=" login100-form-title ">Enter your email to get a password reset link</p>
				<form method="POST" class="login100-form validate-form p-b-33 p-t-5">
					<div class="wrap-input100 validate-input" data-validate="Enter Email">
						<input class="input100" type="email" name="email" placeholder="Enter Email">
						<span class="focus-input100" data-placeholder="&#xe7ed;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" name="submit" value="Forgot" type="submit">Forgot</button>
					</div>
					
				</form>
				<
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

	<!--===============================================================================================-->
	<script src="login_files/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="login_files/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="login_files/vendor/bootstrap/js/popper.js"></script>
	<script src="login_files/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="login_files/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="login_files/vendor/daterangepicker/moment.min.js"></script>
	<script src="login_files/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="login_files/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="login_files/js/main.js"></script>

</body>

</html>