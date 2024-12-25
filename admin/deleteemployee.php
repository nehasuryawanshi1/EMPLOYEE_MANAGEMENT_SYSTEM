<?php
    require '../dbconnection.php';
    $id = $_GET['id'];
    // sql to delete a record
    $sql = "DELETE FROM new_employee WHERE id =$id";

    if ($conn->query($sql) === TRUE) {
       echo "<SCRIPT type='text/javascript'> //not showing me this
                       alert('New Employee Deleted Successfully!! ');
                      window.location.replace('employee.php');
                     </SCRIPT>";
    } else {
      echo "Error deleting record: " . $conn->error;
    }
?>

   
