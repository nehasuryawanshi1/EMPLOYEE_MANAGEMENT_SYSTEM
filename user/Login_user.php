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
    <title>Swapra Technologies</title>
    <link rel="shortcut icon" href="assets/img/logo.jpg">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/img/logo.jpg">
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
                            <h3 class="page-title active">All Details</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Details</li>
                            </ul>
                        </div>
                        <!-- <div class="col-auto text-right float-right ml-auto">
                            <a class="btn btn-primary" onclick="exportTableToExcel('tblData')">Download</a>
                            <a href="addservices.php" class="btn btn-primary">Add Services <i
                                    class="fas fa-plus"></i></a>
                        </div> -->

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


                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center mb-0 datatable" id="tblData">
                                        <div class="col-lg-4 d-flex justify-conten-between "
                                            style="border:0px solid; font-size:20px; text-align:right; float: right;">
                                            <script
                                                src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
                                            </script>
                                            <script>
                                            $(document).ready(function() {
                                                $("#myInput").on("keyup", function() {
                                                    var value = $(this).val().toLowerCase();
                                                    $("#tblData tr").filter(function() {
                                                        $(this).toggle($(this).text()
                                                            .toLowerCase().indexOf(value) >
                                                            -1)
                                                    });
                                                });
                                            });
                                            </script>

                                            <input id="myInput" type="text" placeholder="Search..">
                                        </div>
                                        <thead>
                                            <tr>
                                                <!--     course_id   -->
                                                <th>#</th>
                                                
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Contact</th>
                                                <th>Role</th>
                                                <th>Department</th>
                                                <th>Salary Rate</th>
                                                <th>Password</th>
                                                

                                                <th class="text-right">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php include '../dbconnection.php';
                                            $id = $_SESSION['user1_session'] ['id'];
                                        $sql = "SELECT * FROM new_employee ORDER BY new_employee.id DESC";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                          // output data of each row
                                             $srno = 1;
                                          while($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr>
                                                <td scope="row"><?= $srno ?> </td>
                                                

                                                <!-- <td>
                                                    <img src="../admin/image/<?//php echo $row["image"] ?>"
                                                        style="height: 200px; " alt="...">
                                                </td> -->

                                                <td><?php echo $row["name"] ?></td>

                                                <td><?php echo $row["email"] ?></td>

                                                <td><?php echo $row["contact"] ?></td>

                                                <td><?php echo $row["role"] ?></td>

                                                <td><?php echo $row["department"] ?></td>

                                                <td><?php echo $row["salary_rate"] ?></td>

                                                <td><?php echo $row["password"] ?></td>




                                                


                                                <td class="text-right">
                                                    <div class="actions">
                                                        <a href="insertattendance.php?id=<?php echo $row["id"] ?>"
                                                            class="btn btn-md bg-success-light">
                                                            <i class="fas fa-eye"></i>Attendance
                                                        </a>

                                                    </div>
                                                </td>

                                                <!-- <td class="text-right">
                                                    <div class="actions">


                                                        <a href="deleteservices.php?id=<?php echo  $row["id"] ?>"
                                                            class="btn btn-md bg-danger-light"
                                                            onClick="javascript: return confirm('Please confirm deletion');">
                                                            <i class="fas fa-trash"></i>Delete
                                                        </a>
                                                    </div>
                                                </td> -->


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


    <script>
    (function(document) {
        'use strict';

        var LightTableFilter = (function(Arr) {

            var _select;

            function _onSelectEvent(e) {
                _select = e.target;

                var tables = document.getElementsByClassName(_select.getAttribute('data-table'));
                var e = document.getElementById("selectL");
                var value = e.options[e.selectedIndex].text;

                //	document.write(e.selectedIndex)
                Arr.forEach.call(tables, function(table) {
                    Arr.forEach.call(table.tBodies, function(tbody) {
                        if (e.selectedIndex != 0)
                            Arr.forEach.call(tbody.rows, _filterSelect);
                        else
                            location.reload();
                    });
                });
            }


            function _filterSelect(row) {

                var text_select = row.textContent.toLowerCase(),
                    val_select = _select.options[_select.selectedIndex].value.toLowerCase();
                row.style.display = text_select.indexOf(val_select) === -1 ? 'none' : 'table-row';

            }

            return {
                init: function() {

                    var selects = document.getElementsByClassName('select-table-filter');

                    Arr.forEach.call(selects, function(select) {
                        select.onchange = _onSelectEvent;
                    });
                }
            };
        })(Array.prototype);

        document.addEventListener('readystatechange', function() {
            if (document.readyState === 'complete') {
                LightTableFilter.init();
            }
        });

    })(document);


    getPagination('.tabs');




    function getPagination(table) {
        var lastPage = 1;

        $('#maxRows')
            .on('change', function(evt) {
                $('.paginationprev').html(''); // reset pagination

                lastPage = 1;
                $('.pagination')
                    .find('li')
                    .slice(1, -1)
                    .remove();
                var trnum = 0; // reset tr counter
                var maxRows = parseInt($(this).val()); // get Max Rows from select option

                if (maxRows == 5000) {
                    $('.pagination').hide();
                } else {
                    $('.pagination').show();
                }

                var totalRows = $(table + ' tbody tr').length; // numbers of rows
                $(table + ' tr:gt(0)').each(function() {
                    // each TR in  table and not the header
                    trnum++; // Start Counter
                    if (trnum > maxRows) {
                        // if tr number gt maxRows

                        $(this).hide(); // fade it out
                    }
                    if (trnum <= maxRows) {
                        $(this).show();
                    } // else fade in Important in case if it ..
                }); //  was fade out to fade it in
                if (totalRows > maxRows) {
                    // if tr total rows gt max rows option
                    var pagenum = Math.ceil(totalRows / maxRows); // ceil total(rows/maxrows) to get ..
                    //	numbers of pages
                    for (var i = 1; i <= pagenum;) {
                        // for each page append pagination li
                        $('.pagination #prev')
                            .before(
                                '<li data-page="' +
                                i +
                                '">\
                            <span>' +
                                i++ +
                                '<span class="sr-only">(current)</span></span>\
                          </li>'
                            )
                            .show();
                    } // end for i
                } // end if row count > max rows
                $('.pagination [data-page="1"]').addClass('active'); // add active class to the first li
                $('.pagination li').on('click', function(evt) {
                    // on click each page
                    evt.stopImmediatePropagation();
                    evt.preventDefault();
                    var pageNum = $(this).attr('data-page'); // get it's number

                    var maxRows = parseInt($('#maxRows').val()); // get Max Rows from select option

                    if (pageNum == 'prev') {
                        if (lastPage == 1) {
                            return;
                        }
                        pageNum = --lastPage;
                    }
                    if (pageNum == 'next') {
                        if (lastPage == $('.pagination li').length - 2) {
                            return;
                        }
                        pageNum = ++lastPage;
                    }

                    lastPage = pageNum;
                    var trIndex = 0; // reset tr counter
                    $('.pagination li').removeClass('active'); // remove active class from all li
                    $('.pagination [data-page="' + lastPage + '"]').addClass(
                        'active'); // add active class to the clicked
                    // $(this).addClass('active');					// add active class to the clicked
                    limitPagging();
                    $(table + ' tr:gt(0)').each(function() {
                        // each tr in table not the header
                        trIndex++; // tr index counter
                        // if tr index gt maxRows*pageNum or lt maxRows*pageNum-maxRows fade if out
                        if (
                            trIndex > maxRows * pageNum ||
                            trIndex <= maxRows * pageNum - maxRows
                        ) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        } //else fade in
                    }); // end of for each tr in table
                }); // end of on click pagination list
                limitPagging();
            })
            .val()
            .change();
    }

    function limitPagging() {
        // alert($('.pagination li').length)

        if ($('.pagination li').length > 7) {
            if ($('.pagination li.active').attr('data-page') <= 3) {
                $('.pagination li:gt(5)').hide();
                $('.pagination li:lt(5)').show();
                $('.pagination [data-page="next"]').show();
            }
            if ($('.pagination li.active').attr('data-page') > 3) {
                $('.pagination li:gt(0)').hide();
                $('.pagination [data-page="next"]').show();
                for (let i = (parseInt($('.pagination li.active').attr('data-page')) - 2); i <= (parseInt($(
                        '.pagination li.active').attr('data-page')) + 2); i++) {
                    $('.pagination [data-page="' + i + '"]').show();

                }

            }
        }
    }
    </script>

    <!-- Scripts  -->
    <script src="assets/js/jquery-3.5.1.min.js"></script>

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="assets/plugins/datatables/datatables.min.js"></script>

    <script src="assets/js/script.js"></script>

</body>

</html>