<?php
include_once '../dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from POST request
    $name = $_POST['name'];
    $email = $_POST['email'];
    $emp_id = $_POST['emp_id'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];
    $department = $_POST['department'];
    $location = $_POST['location'];
    $password = $_POST['password'];
    $pay_mode = $_POST['pay_mode'];
    $bank_name = $_POST['bank_name'];
    $acc_number = $_POST['acc_number'];
    $ifsc_code = $_POST['ifsc_code'];
    $salary = $_POST['salary'];
    $id = $_POST['id'];

    // Check if $conn is a valid connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement to update the record
    $stmt = $conn->prepare("UPDATE `new_employee` SET 
        `name` = ?, 
        `email` = ?,
        `emp_id` = ?, 
        `contact` = ?, 
        `role` = ?, 
        `department` = ?, 
        `location` = ?,
        `password` = ?,
        `pay_mode` = ?,
        `bank_name` = ?,
        `acc_number` = ?,
        `ifsc_code` = ?,
        `salary` = ?
        WHERE `id` = ?");

    // Check if prepare() was successful
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters - use "s" (string) for string fields and "d" (double) for salary, and "i" (integer) for ID
    $stmt->bind_param(
        "ssssssssssssdi", 
        $name, 
        $email, 
        $emp_id, 
        $contact, 
        $role, 
        $department, 
        $location, 
        $password, 
        $pay_mode, 
        $bank_name, 
        $acc_number, 
        $ifsc_code, 
        $salary, 
        $id
    );

    try {
        // Execute the statement
        if ($stmt->execute()) {
            echo "<script type='text/javascript'>
                alert('Employee updated successfully!');
                window.location.replace('employee.php');
            </script>";
        } else {
            throw new Exception("Error executing statement: " . $stmt->error);
        }
    } catch (Exception $e) {
        echo "<script type='text/javascript'>
            alert('Error updating employee: " . addslashes($e->getMessage()) . "');
        </script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
