<?php
include_once '../dbconnection.php';

// Sanitize and validate GET parameters
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
$maincategory = isset($_GET['maincategory']) ? mysqli_real_escape_string($conn, $_GET['maincategory']) : '';
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$subproduct_id = isset($_GET['subproduct_id']) ? intval($_GET['subproduct_id']) : 0;
$plant_id = isset($_GET['plant_id']) ? intval($_GET['plant_id']) : 0;

// Prepare the SQL query
$sql = "UPDATE buy 
        SET approval_status='cancelled' 
        WHERE id=? AND user_id=? AND maincategory=? AND product_id=? AND subproduct_id=? AND plant_id=?";

// Create a prepared statement
if ($stmt = mysqli_prepare($conn, $sql)) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "iissii", $id, $user_id, $maincategory, $product_id, $subproduct_id, $plant_id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<script type='text/javascript'>
                alert('Cancelled successfully!!');
                window.location.replace('enquiry.php');
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
hiiiiiiiiiiii