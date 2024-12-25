<?php
session_start();
include_once '../dbconnection.php';

// Check if email and password are set
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM new_employee WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $dbpass = $row["password"];
        
        // Use password_verify for hashed passwords
       
            $_SESSION['user1_session'] = $row;
            header('Location: index.php');
            exit();
       
    } else {
        echo "<script type='text/javascript'>alert('Wrong details.'); window.location.replace('login.php');</script>";
    }

    $stmt->close();
} else {
    echo "<script type='text/javascript'>alert('Please fill in all fields.'); window.location.replace('login.php');</script>";
}

$conn->close();
?>
