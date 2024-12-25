<?php
session_start();
if (empty($_SESSION['user1_session'])) {
    header('Location:login.php');
}

include '../dbconnection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Vighnaharta</title>

    <link rel="shortcut icon" href="assets/img/logocoaching.jpg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
<link rel="icon" type="image/png" href="assets/img/logocoaching.jpg">
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
                            <h3 class="page-title">User Login</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">User Login</li>
                            </ul>
                        </div>
                        <div class="col-auto text-right float-right ml-auto">
                            <!--   <a href="#" class="btn btn-outline-primary mr-2"><i class="fas fa-download"></i> Download</a> -->
                            <!-- <a href="add.php" class="btn btn-primary"><i class="fas fa-plus"></i></a> -->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card ">
                            <div class="card-body" style="padding: 0px;">
                                <div class="table-responsive">
                                    <table id="mytable" class="table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <!-- user_Id  -->
                                                <th>#</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Contact Number</th>
                                                <th>Address</th>
                                                <th>Zip/Pin Code</th>
                                                
                                                <th>Login Success</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $sql = "SELECT * FROM order_place";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                $srno = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                     if(!$row['username']==null){?>

                                                    <tr>
                                                        <td><?=$srno?></td>
                                                        <td><?=$row['full_name']?></td>
                                                        <td><?=$row['email_id']?></td>
                                                       <td><?=$row['phone_number']?></td>
                                                       <td><?=$row['address']?></td>
                                                       <td><?=$row['pin_code']?></td>

                                                    <?php 
                                                         if(!$row['username']==null){
                                                   ?>
                                                      <td> <a href='viewprofile.php?id=<?=$row['user_id']?>' class='btn btn-success btn-sm'><i class='fa fa-check'></i></a> </td>
<?php }else{?>
                                                       <td> <a href='viewprofile.php?id=<?=$row['user_id']?>' class='btn btn-danger btn-sm'><i class='fa fa-times'></i></a> </td>
                                                  <?php
}              
                                                  ?>
                                                 

                                                    <?php 
                                                    $srno++;

                                                }}
                                            } else {
                                                echo "Curruntaly No Any Customers";
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- <footer>
                <p>Copyright © 2022 Nucleus - Health & Medical.</p>
            </footer> -->
        </div>
    </div>

    <!-- Scripts  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
        <script>
                 $(document).ready( function () {
                $('#mytable').DataTable();
            } );
        </script>

    <script src="assets/js/jquery-3.5.1.min.js"></script>

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="assets/plugins/datatables/datatables.min.js"></script>

    <script src="assets/js/script.js"></script>

</body>

</html>