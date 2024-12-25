<?php
include_once '../dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $emp_id = $_POST['emp_id'];
    $date = $_POST['date'];
    $in_time = $_POST['in_time'];
    $out_time = $_POST['out_time'];

    // Check if the "In" button was clicked
    if (isset($_POST['in_btn'])) {
        // Insert query for "In" time
        $query = "INSERT INTO employee_attendance (emp_id, date, in_time, out_time) 
                  VALUES ('$emp_id', '$date', '$in_time', '')"; // Out time is initially empty

        // Execute the query
        if (mysqli_query($conn, $query)) {
            // Start the session if it's not started yet
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Store the success message and redirect
            echo "<script type='text/javascript'>
                alert('Attendance Added Successfully!');
                window.location.replace('registereduser.php');
            </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Check if the "Out" button was clicked
    if (isset($_POST['out_btn'])) {
        // Fetch the ID of the attendance record for this employee and date
        $query = "SELECT id FROM employee_attendance 
                  WHERE emp_id = '$emp_id' AND date = '$date' AND out_time = ''";  // Look for the record with empty 'out_time'

        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            // Get the ID of the matching record
            $row = mysqli_fetch_assoc($result);
            $attendance_id = $row['id'];

            // Update query for "Out" time
            $query = "UPDATE employee_attendance 
                      SET out_time = '$out_time',
                      attendance_status = 'Present'
                      WHERE id = '$attendance_id'";

            // Execute the query
            if (mysqli_query($conn, $query)) {
                echo "<script type='text/javascript'>
                    alert('Out Time Updated Successfully!');
                    window.location.replace('registereduser.php');
                </script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "No attendance record found for this employee on the selected date with an empty 'Out' time.";
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
