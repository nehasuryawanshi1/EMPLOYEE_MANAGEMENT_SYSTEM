<?php
include_once '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $name = mysqli_real_escape_string($conn, trim($_POST['name'] ?? ''));
    $email = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $emp_id = mysqli_real_escape_string($conn, trim($_POST['emp_id'] ?? ''));
    $contact = mysqli_real_escape_string($conn, trim($_POST['contact'] ?? ''));
    $role = mysqli_real_escape_string($conn, trim($_POST['role'] ?? ''));
    $department = mysqli_real_escape_string($conn, trim($_POST['department'] ?? ''));
    $password = mysqli_real_escape_string($conn, trim($_POST['password'] ?? ''));
    $location = mysqli_real_escape_string($conn, trim($_POST['location'] ?? ''));
    $pay_mode = mysqli_real_escape_string($conn, trim($_POST['pay_mode'] ?? ''));
    $bank_name = mysqli_real_escape_string($conn, trim($_POST['bank_name'] ?? ''));
    $acc_number = mysqli_real_escape_string($conn, trim($_POST['acc_number'] ?? ''));
    $ifsc_code = mysqli_real_escape_string($conn, trim($_POST['ifsc_code'] ?? ''));
    $salary = mysqli_real_escape_string($conn, trim($_POST['salary'] ?? ''));

    // Check for required fields
    if (empty($name) || empty($email) || empty($emp_id) || empty($contact) || empty($password) || empty($role) || empty($department)) {
        echo "<script type='text/javascript'>
            alert('Please fill out all required fields.');
            window.history.back();
        </script>";
        exit;
    }

    // Insert query
    $query = "INSERT INTO new_employee (name, email,emp_id, contact, role, department, password, location, pay_mode, bank_name, acc_number, ifsc_code, salary) 
              VALUES ('$name', '$email', '$emp_id', '$contact', '$role', '$department', '$password', '$location', '$pay_mode', '$bank_name', '$acc_number', '$ifsc_code', '$salary')";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Start the session and store the plain password temporarily
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['temp_password'] = $password;

        echo "<script type='text/javascript'>
            alert('New Employee Added Successfully!');
            window.location.replace('employee.php');
        </script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Error: " . mysqli_error($conn) . "');
            window.history.back();
        </script>";
    }
}

// Close the database connection
mysqli_close($conn);
?>
