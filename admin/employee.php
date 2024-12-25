<?php
session_start();
if (empty($_SESSION['admin_session'])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Swapra Technologies - Dashboard</title>

    <link rel="shortcut icon" href="../assets/images/pol/logo1.jpeg">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap">
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- DataTables CSS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css">
    
    <!-- Export to Excel -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    .navbar {
        background-color: #343a40;
    }

    .navbar-brand {
        color: #fff !important;
        font-weight: 600;
    }

    .navbar-nav .nav-link {
        color: #adb5bd !important;
    }

    .navbar-nav .nav-link:hover {
        color: #fff !important;
    }

    .page-header {
        background-color: #a5bdd7;
        color: #fff;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .page-header h3 {
        font-weight: 600;
        font-size: 1.5rem;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0;
    }

    .breadcrumb-item {
        color: #007bff;
    }

    .breadcrumb-item.active {
        color: #343a40;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .card-body {
        padding: 20px;
    }

    .table {
        font-size: 0.875rem;
        background-color: #fff;
        border-radius: 10px;
    }

    .table th, .table td {
        padding: 12px;
        text-align: center;
    }

    .table thead {
        background-color: #f1f1f1;
    }

    .table thead th {
        font-weight: 600;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }

    .pagination {
        justify-content: center;
    }

    .input-group {
        margin-bottom: 20px;
    }

    .input-group input {
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 10px;
    }

    .input-group input:focus {
        border-color: #007bff;
    }

    footer {
        background-color: #343a40;
        color: #fff;
        text-align: center;
        padding: 15px;
        border-radius: 5px;
        margin-top: 30px;
    }

    .action-btns {
        display: flex;
        justify-content: space-evenly;
    }

    .action-btns a,
    .action-btns form button {
        padding: 8px 20px;
        border-radius: 5px;
        font-size: 14px;
        margin: 0 5px;
    }

    .action-btns a {
        color: #fff;
    }

    .action-btns a.bg-success-light {
        background-color: #28a745;
    }

    .action-btns a.bg-success-light:hover {
        background-color: #218838;
    }

    .action-btns a.bg-danger-light {
        background-color: #dc3545;
    }

    .action-btns a.bg-danger-light:hover {
        background-color: #c82333;
    }

    .action-btns form button {
        background-color: #007bff;
        color: #fff;
    }

    .action-btns form button:hover {
        background-color: #0056b3;
    }

    .table-search {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .table-search input {
        width: 300px;
    }
    </style>
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
                            <h3 class="page-title active">All New Employee</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">All New Employee</li>
                            </ul>
                        </div>
                        <div class="col-auto text-right float-right ml-auto">
                            <a href="addemployee.php" class="btn btn-primary">Add New Employee <i
                                    class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-search">
                                    <input type="text" id="myInput" class="form-control" placeholder="Search..">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0 datatable" id="tblData">
                                        <thead>
                                            <tr>
                                                <th>SR NO</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Employee ID</th>
                                                <th>Contact</th>
                                                <th>Role</th>
                                                <th>Department</th>
                                                <th>Location</th>
                                                <th>Password</th>
                                                <th>Pay Mode</th>
                                                <th>Bank Name</th>
                                                <th>Account Number</th>
                                                <th>IFSC Code</th>
                                                <th>Salary</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include '../dbconnection.php';
                                            $sql = "SELECT * FROM new_employee ORDER BY new_employee.id DESC";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                $srno = 1;
                                                while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td scope="row"><?= $srno ?></td>
                                                <td><?php echo $row["name"] ?></td>
                                                <td><?php echo $row["email"] ?></td>
                                                <td><?php echo $row["emp_id"] ?></td>
                                                <td><?php echo $row["contact"] ?></td>
                                                <td><?php echo $row["role"] ?></td>
                                                <td><?php echo $row["department"] ?></td>
                                                <td><?php echo $row["location"] ?></td>
                                                <td><?php echo $row["password"] ?></td>
                                                <td><?php echo $row["pay_mode"] ?></td>
                                                <td><?php echo $row["bank_name"] ?></td>
                                                <td><?php echo $row["acc_number"] ?></td>
                                                <td><?php echo $row["ifsc_code"] ?></td>
                                                <td><?php echo $row["salary"] ?></td>
                                                <td class="text-right">
                                                    <div class="action-btns">
                                                        <a href="editemployee.php?id=<?php echo $row["id"] ?>"
                                                            class="btn btn-md bg-success-light mr-2">
                                                            <i class="fas fa-pen"></i> Update
                                                        </a>

                                                        <a href="viewattendance.php?id=<?php echo $row["id"] ?>"
                                                            class="btn btn-md bg-success-light mr-2">
                                                            <i class="fas fa-eye"></i> View Attendance
                                                        </a>

                                                        <!-- <form action="generate_salary_slip.php" method="POST" target="_blank">
                                                            <input type="hidden" name="employee_id" value="<?= $row["id"]  ?>">
                                                            <button type="submit" class="btn btn-md bg-success-light">
                                                                <i class="fas fa-file-invoice"></i> Calculate Salary
                                                            </button>
                                                        </form> -->

                                                        <a href="deleteemployee.php?id=<?php echo $row["id"] ?>"
                                                            class="btn btn-md bg-danger-light"
                                                            onClick="javascript: return confirm('Please confirm deletion');">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php   
                                                $srno++; 
                                                }
                                            } else {
                                                echo "No Data In Database";
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

            <footer>
                <p>Copyright © 2024</p>
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
    <script>
    // Search functionality
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tblData tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
    </script>
</body>

</html>
