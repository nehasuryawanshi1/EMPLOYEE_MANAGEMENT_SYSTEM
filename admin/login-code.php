<?php
session_start();
include_once '../dbconnection.php';
?> 
<?php

 $name = $_POST['username'];
 $Password = $_POST['password'];

$result = mysqli_query($conn,"SELECT * FROM admin WHERE username='$name'");
 $count = mysqli_num_rows($result);

if ($count == 1) {
	while ($row = mysqli_fetch_assoc($result)) {
		$dbpass = $row["password"];
		if ($Password == $dbpass) {
			$_SESSION['admin_session'] = $row;
			//echo "-=-=-=-=";
			echo " <script> location.replace('index.php');</script>";
		} else {
			//echo "Password not Match";
			echo "<SCRIPT type='text/javascript'> alert('Password Not Match...');	window.location.replace('login.php'); </SCRIPT>";
		}
	}
} else {
	//echo "Wrong Details";
	echo "<SCRIPT type='text/javascript'> alert('Wrong Details...');window.location.replace('login.php'); </SCRIPT>";
}

?>

