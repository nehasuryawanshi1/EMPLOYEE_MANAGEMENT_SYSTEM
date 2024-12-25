<?php
session_start();
if (empty($_SESSION['user1_session'])) {
    header('Location:login.php');
    exit;
}

$id = $_GET['id'] ?? ''; // Ensure $id is set

// Set the correct time zone
date_default_timezone_set('Asia/Kolkata'); // Adjust to your local time zone

// Get the current date and time
$current_date = date('Y-m-d'); // Format: YYYY-MM-DD
$current_time = date('H:i');  // Format: HH:MM (24-hour format)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Swapra Technologies - Dashboard</title>

    <link rel="shortcut icon" href="../assets/images/pol/logo1.jpeg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&display=swap">
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include 'top.php'; ?>
        <?php include 'sidebar.php'; ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Attendance</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="employee.php">Employee</a></li>
                                <li class="breadcrumb-item active">Attendance</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="insertattendance.php" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="form-title"><span>Employee Attendance</span></h5>
                                        </div>

                                        <input type="hidden" name="emp_id" value="<?php echo htmlspecialchars($id); ?>" class="form-control" required>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="date">Date</label>
                                                <input type="date" name="date" id="date" value="<?php echo $current_date; ?>" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="in_time">In Time</label>
                                                <input type="time" name="in_time" id="in_time" value="<?php echo $current_time; ?>" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="out_time">Out Time</label>
                                                <input type="time" name="out_time" id="out_time" value="<?php echo $current_time; ?>" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
    <div class="d-flex justify-content-start">
        <button type="submit" name="in_btn" class="btn btn-primary mr-2">In</button>
        <button type="submit" name="out_btn" class="btn btn-primary">Out</button>
    </div>
</div>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer>
                <p>Copyright © 2024</p>
            </footer>
        </div>
    </div>

    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/datatables/datatables.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
