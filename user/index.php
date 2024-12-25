<?php
session_start();
if (empty($_SESSION['user1_session'])) {
    // header('Location:login.php');
}
include '../dbconnection.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Muurgighar</title>
    <link rel="shortcut icon" href="assets/img/logo1.jpg">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/img/logo1.jpg">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <style type="text/css">
    .card-body {
        cursor: pointer;
    }

    #package-message {
        color: red;
        display: none;
    }
    </style>
    <div class="main-wrapper">
        <?php include 'top.php'; ?>
        <?php include 'sidebar.php'; ?>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Welcome <?php echo $_SESSION['user1_session']['name'] ?>!</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                        <!-- <div class='col-auto text-right float-right ml-auto'>
                            <a href='packages.php' class='btn btn-primary' style='font-family: system-ui;'>Get A New
                                Test Package + </a>
                        </div>
                    </div> -->
                </div>

                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='card card-table'>
                            <div class='card-body'>
                                <div class='table-responsive'>
                                    <!-- Search Field -->
                                    <!-- <div class="mb-3">
                        <input type="text" id="myInput" placeholder="Search..." class="form-control" style="display: inline-block; width: auto;">
                    </div> -->
                                    <!-- <table class='table table-hover table-center mb-0 datatable' id='tblData'>
                                        <thead>
                                            <tr>
                                                <th>Sr.No</th>
                                                <th>Subject Name</th>
                                                <th>Amount</th>
                                                <th>Category Name</th>
                                                <th class='text-right'>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include '../dbconnection.php';
                                            $id = $_SESSION['user1_session']['id'];

                                            $sql = "SELECT testpackages.*, userregistration.*
                            FROM testpackages
                            JOIN userregistration ON testpackages.user_id = userregistration.id
                            WHERE testpackages.user_id = '$id'
                            ORDER BY testpackages.id DESC";

                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                $srno = 1;
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $srno; ?></td>
                                                <td><?php echo $row['subject_name']; ?></td>
                                                <td>
                                                    <?php
                                                            if ($row['amount'] == 0) {
                                                                echo "Free";
                                                            } else {
                                                                echo $row['amount'];
                                                            }
                                                            ?>
                                                </td>
                                                <td><?php echo $row['category_name']; ?></td>
                                                <td class='text-right'>
                                                    <div class='actions'>
                                                        <a class='btn btn-sm bg-success-light mr-2'
                                                            href="viewsubjecttesttt.php?id=<?php echo $row["package_id"]; ?>&&category_name=<?php echo $row["category_name"]; ?>"><i
                                                                class='fas fa-eye'></i> View test</a>
                                                        <?php if ($row['amount'] != 0) { ?>
                                                        <a class='btn btn-sm bg-success-light mr-2'
                                                            href="invoicetestpackage.php?id=<?php echo $row["package_id"]; ?>&&user_id=<?php echo $row["user_id"]; ?>&&category_name=<?php echo $row["category_name"]; ?>&&invoice_no=<?php echo $row["invoice_no"]; ?>">
                                                            Invoice</a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                                    $srno++;
                                                }
                                            } else {
                                                echo '<tr><td colspan="5" class="text-center">Data Not Found!</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table> -->
                                </div>
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