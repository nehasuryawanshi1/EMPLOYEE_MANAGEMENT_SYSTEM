<?php
// Include your database connection file
include '../dbconnection.php';

if(isset($_POST['upload'])) {
    $id = $_POST['ID'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];

    // Update query
    $sql = "UPDATE jobs SET title='$title', description='$description', image='$image' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // File upload
        $target_dir = "image/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
      }   if ($conn->query($sql)) {
        echo "<SCRIPT type='text/javascript'> //not showing me this
                                        alert('Job Post Updated successfully!!');
                                        window.location.replace('jobpost.php');
                                        </SCRIPT>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>    