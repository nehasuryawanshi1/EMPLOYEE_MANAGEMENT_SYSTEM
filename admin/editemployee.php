<?php
session_start();
if (empty($_SESSION['admin_session'])) {
    header('Location:login.php');
}

// Include database connection
include_once '../dbconnection.php';

// Fetch the service details based on ID
$new_employee_id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM new_employee WHERE id = ?");
$query->bind_param("i", $new_employee_id);
$query->execute();
$result = $query->get_result();
$new_employee = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Swapra Technologies - Dashboard</title>

    <link rel="shortcut icon" href="../img/logop.png">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap">
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
                            <h3 class="page-title">Update New Employee</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="employee.php">New Employee</a></li>
                                <li class="breadcrumb-item active">Update New Employee</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="updateemployee.php" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="form-title"><span>New Employee Information</span></h5>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $new_employee['id']; ?>">


                                        
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="<?php echo $new_employee['name']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" name="email" class="form-control"
                                                    value="<?php echo $new_employee['email']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Employee ID</label>
                                                <input type="text" name="emp_id" class="form-control"
                                                    value="<?php echo $new_employee['emp_id']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Contact</label>
                                                <input type="text" name="contact" class="form-control"
                                                    value="<?php echo $new_employee['contact']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Role</label>
                                                <input type="text" name="role" class="form-control"
                                                    value="<?php echo $new_employee['role']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <input type="text" name="department" class="form-control"
                                                    value="<?php echo $new_employee['department']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <input type="text" name="location" class="form-control"
                                                    value="<?php echo $new_employee['location']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="text" name="password" class="form-control"
                                                    value="<?php echo $new_employee['password']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Pay Mode</label>
                                                <input type="text" name="pay_mode" class="form-control"
                                                    value="<?php echo $new_employee['pay_mode']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Bank Name</label>
                                                <input type="text" name="bank_name" class="form-control"
                                                    value="<?php echo $new_employee['bank_name']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Account Number</label>
                                                <input type="text" name="acc_number" class="form-control"
                                                    value="<?php echo $new_employee['acc_number']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>IFSC Code</label>
                                                <input type="text" name="ifsc_code" class="form-control"
                                                    value="<?php echo $new_employee['ifsc_code']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Salary</label>
                                                <input type="text" name="salary" class="form-control"
                                                    value="<?php echo $new_employee['salary']; ?>" required>
                                            </div>
                                        </div>




                                        <div class="col-12">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <footer>
                <p>Copyright © 2024.</p>
            </footer>
        </div>
    </div>

    <script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>
    <!-- Scripts  -->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/datatables/datatables.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html><?php
include_once '../dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from POST request
    $reference_code = $_POST['reference_code'];
    $id = $_POST['id']; // Assuming the ID is also passed in the POST request

    // Check if $conn is a valid connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement to update the record
    $stmt = $conn->prepare("UPDATE `reference_code` SET `reference_code` = ? WHERE `id` = ?");

    // Check if prepare() was successful
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $reference_code, $id);

    if ($stmt->execute()) {
        echo "<SCRIPT type='text/javascript'>
                  alert('Reseller updated successfully!!');
                  window.location.replace('referencecode.php');
              </SCRIPT>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>
