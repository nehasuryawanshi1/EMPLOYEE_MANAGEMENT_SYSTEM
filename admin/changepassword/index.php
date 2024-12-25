<?php
session_start();
require "../conn.php";
if (isset($_POST['username']) && isset($_POST['pass'])) {
	$uname = mres($conn, $_POST['username']);
	$pass = mres($conn, $_POST['pass']);
	$loginSQ = mysqli_query($conn, "select * from admin where uname='$uname'");
	if (mysqli_num_rows($loginSQ) > 0) {
		$Row = mysqli_fetch_assoc($loginSQ);
		$hashpass = $Row['pass'];
		if (password_verify($pass, $hashpass)) {
			$_SESSION['login_row'] = $Row;
			header('Location:dashboard.php');
		} else {
			echo " <script>alert('Invalid Credentials...');loction.replace('')</script> ";
		}
	} else {
		echo " <script>alert('Invalid Credentials...');loction.replace('')</script> ";
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
					Account Login
				</span>
				<form method="POST" class="login100-form validate-form p-b-33 p-t-5">

					<div class="wrap-input100 validate-input" data-validate="Enter username">
						<input class="input100" type="text" autocomplete="off" placeholder="Username"name="username" placeholder="User name">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
					<div class="d-flex p-4 justify-content-center">
					<a href="forgot.php" class="link-danger" style="font-size: 20px; font-weight: bold;">Forgot Password ?</a>
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