<?php
session_start();
if (empty($_SESSION['user1_session'])) {
    header('Location:../index.php');
}

 $userid = $_SESSION['user1_session']['id'];

include_once '../dbconnection.php';

 $sql = "SELECT * FROM new_employee WHERE id=$userid";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$ooldpass = $row["password"];

if (isset($_POST['pass']) && isset($_POST['cpass'])) {
    $getoldpass = $_POST['oldpass'];
    if ($ooldpass == $getoldpass) {
        if (empty($_POST['pass'])) {
            echo " <script>alert('Passowrd can not be empty...!');location.replace('')</script> ";
        } else {
            $password = $_POST['pass'];
            $cpassword = $_POST['cpass'];
            if ($password == $cpassword) {
                $passUQ = mysqli_query($conn, "UPDATE new_employee SET password='$password' WHERE id=$userid");
                if ($passUQ) {
                    echo " <script>alert('password has been changed...!');location.replace('index.php')</script> ";
                } else {
                    echo " <script>alert('something went wrong please try again later...!');location.replace('changepassword.php')</script> ";
                }
            } else {
                echo " <script>alert('passwords are not matching...!');location.replace('')</script> ";
            }
        }
    } else {
        echo " <script>alert('Please Enter Correct Old Passowrd');location.replace('')</script> ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title> Swapra Technologies </title>

    <link rel="shortcut icon" href="assets/img/logo1.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
<link rel="icon" type="image/png" href="assets/img/logo1.jpg">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="main-wrapper">
        <?php include 'top.php'; ?>
        <?php include 'sidebar.php'; ?>
        <div class="page-wrapper" style="padding-top: 60px;">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Welcome <?php echo $_SESSION['user1_session']['name'] ?>!</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <h1 style="color: #18aefa;font-weight:bold;text-align: center;">Change Password</h1>
                        <div class="card">
                            <div class="card-body">
                                <form class="form-horizontal form-material" enctype="multipart/form-data" method="post">
                                    <div class="form-group">
                                        <input type="password" required name="oldpass" placeholder="Old Password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" required name="pass" placeholder="Create New Password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" required name="cpass" placeholder="Repeat New Password" class="form-control">
                                    </div>

                                    <button type="submit" class="btn text-white btn-success w-100">Change Password</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <footer>
            <p>© 2024.</p>
            
            </footer>
        </div>
    </div>


    <!-- Scripts  -->
    <script src="assets/js/jquery-3.5.1.min.js"></script>

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="assets/plugins/apexchart/chart-data.js"></script>

    <script src="assets/js/script.js"></script>

</body>

</html>