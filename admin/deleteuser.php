<?php
    require '../dbconn.php';
    $id = $_GET['id'];
    // sql to delete a record
    $sql = "DELETE FROM userdata WHERE userdataid =$id";

    if ($conn->query($sql) === TRUE) {
       echo "<SCRIPT type='text/javascript'> //not showing me this
                       alert('User Deleted Successfully!! ');
                      window.location.replace('userlist.php');
                     </SCRIPT>";
    } else {
      echo "Error deleting record: " . $conn->error;
    }
?>

   
