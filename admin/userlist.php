<?php
session_start();
if (empty($_SESSION['admin_session'])) {
header('Location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>park - Dashboard</title>

    <link rel="shortcut icon" href="../assets/images/logo/logo.jpg">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
   
    <!-- DataTables CSS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/jquery.dataTables.min.css">
    
    <!-- Experto to Exel -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js">
    </script>
    <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js">
    </script>
  <style>
        * {
            box-sizing: border-box;
        }

        #myInput {
            background-image: url('/css/searchicon.png');
            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 7px 20px 7px 40px;
            border: 1px solid #ddd;
            /* margin-bottom: 12px; */
        }
    </style>
</head>
<!--  userdata userdataid fnm emailid corsid ctnum address usernm passwrd  -->
<body>
    <div class="main-wrapper">
      
    
    <?php include 'top.php'; ?>
    <?php include 'sidebar.php'; ?>

    
        <div class="page-wrapper">
           <div class="content container-fluid">
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Unpaid User</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Unpaid User</li>
                                </ul>
                            </div>
                            <div class="col-lg-3" style="border:0px solid; font-size:20px;">			
				<!-- <a class="btn btn-primary" onclick="exportTableToExcel('tblData')">Download</a> -->
			</div>
                        </div>
                    

                        <style>
                            table {
                                border-collapse: collapse;
                                border-spacing: 0;
                                width: 100%;
                                border: 1px solid #ddd;
                            }

                            th,
                            td {
                                text-align: left;
                                padding: 8px;
                            }

                            tr:nth-child(even) {
                                background-color: #f2f2f2
                            }
                        </style>
                        <script>
                            function exportTableToExcel(tblData, filename = 'userlist.php') {
                                var downloadLink;
                                var dataType = 'application/vnd.ms-excel';
                                var tableSelect = document.getElementById(tblData);
                                var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

                                // Specify file name
                                filename = filename ? filename + '.xls' : 'excel_data.xls';

                                // Create download link element
                                downloadLink = document.createElement("a");

                                document.body.appendChild(downloadLink);

                                if (navigator.msSaveOrOpenBlob) {
                                    var blob = new Blob(['\ufeff', tableHTML], {
                                        type: dataType
                                    });
                                    navigator.msSaveOrOpenBlob(blob, filename);
                                } else {
                                    // Create a link to the file
                                    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

                                    // Setting the file name
                                    downloadLink.download = filename;

                                    //triggering the function
                                    downloadLink.click();
                                }
                            }
                        </script>














                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="table-responsive">
                                 
                                        <table class="table table-hover table-center mb-0 datatable" id="tblData">
                                        <div class="col-lg-4 d-flex justify-conten-between " style="border:0px solid; font-size:20px; text-align:right; float: right;">
                                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
                                            <script>
                                                $(document).ready(function() {
                                                    $("#myInput").on("keyup", function() {
                                                        var value = $(this).val().toLowerCase();
                                                        $("#tblData tr").filter(function() {
                                                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                                        });
                                                    });
                                                });
                                            </script>

                                            <input id="myInput" type="text" placeholder="Search..">
                                        </div> 
                                        <thead>
                                                <tr>
                                                    <!-- user_Id  -->  

                                                    <th>#</th>
                                                    <th>Full Name</th>
                                                    <th>Email ID</th>
                                                    <th>City</th>
                                                    <th>Area</th>
                                                    <th>Class ID</th>
                                                  
                                                    <th class="text-right">Pay Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php include '../dbconn.php';
                                        $sql = "SELECT * FROM `userdata` INNER JOIN payment ON userdata.userdataid = payment.uid WHERE payment.payment_status='pending'";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                          // output data of each row
                                             $srno = 1;
                                          while($row = $result->fetch_assoc()) {
                                            
                                        ?>
                                                <tr>
                                                    <td scope="row"><?= $srno ?> </td>
                                                    <td><?php echo $row["fullname"] ?></td>
                                                    <td><?php echo $row["emailid"] ?></td>
                                                    <td><?php echo $row["city"] ?></td>
                                                    <td><?php echo $row["area"] ?></td>
                                                    
                                                     <td><?php echo $row["classid"] ?></td>
                                                    
                                                    <td>
                                                    <?php  $userid=$row["userdataid"]; 
                                                     $paystatus = mysqli_fetch_assoc(mysqli_query($conn, "SELECT payment_status FROM payment WHERE uid=$userid"))['payment_status'];
                                                    if ($paystatus=="complete") { ?>
                                                           <span class="badge badge-success" style="margin-left: 0px;">Complte</span> 
                                                    <?php } else { ?>
                                                    <span class="badge badge-danger" style="margin-left: 0px;">Pending</span>
                                                   <?php }
                                                    
                                                    ?>  
                                                    </td>
                                                   <!--   <td>
                                                    <h2 class="table-avatar">
                                                        <a href=""class="avatar avatar-sm mr-2">
                                                        <img class="avatar-img rounded-circle"src="<?php //echo $row["Image"] ?>"
                                                        alt="User Image"></a>
                                                    </h2>
                                                </td> -->
                                                     <td class="text-right">
                                                        <div class="actions">
                                                          <!--  <a href="userdetail.php?id=<?php //echo  $row["user_Id"] ?>" class="btn btn-sm bg-success-light mr-2">
                                                                <i class="fas fa-shield-alt"></i>
                                                            </a>-->
                                                            <a href="deleteuser.php?id=<?php echo  $row["userdataid"] ?>" class="btn btn-sm bg-danger-light" onClick="javascript: return confirm('Please confirm deletion');">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td> 
                                                </tr>
                                    <?php   
                                          $srno++; 
                                            }
                                        } else {
                                          echo "0 results";
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
                <p>Copyright © 2023 SSQUAREIT.</p>
            </footer>
        </div>
    </div>


  
<!-- Scripts  -->
        <script src="assets/js/jquery-3.5.1.min.js"></script>

        <script src="assets/js/popper.min.js"></script>
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <script src="assets/plugins/datatables/datatables.min.js"></script>

        <script src="assets/js/script.js"></script>

</body>

</html>