<?php
require('fpdf/fpdf.php');

class SalarySlipPDF extends FPDF {
    function Header() {
        // Empty header to override default
    }
    
    function Footer() {
        // Empty footer to override default
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_id'])) {
    $employeeId = $_POST['employee_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Get first and last day of the month based on the year and month passed
    $firstDayOfMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
    $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

    include '../dbconnection.php';
    
    // Fetch current month's attendance
    $sql = "SELECT *, 
                   TIMESTAMPDIFF(MINUTE, in_time, out_time) AS worked_minutes,
                   TIME(in_time) AS in_time_only,
                   TIME(out_time) AS out_time_only
            FROM employee_attendance 
            WHERE emp_id = '$employeeId' 
            AND MONTH(date) = '$month' 
            AND YEAR(date) = '$year'
            AND date BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";
            
    $result = $conn->query($sql);

    // Initialize variables
    $fullDays = 0;
    $halfDays = 0;
    $lateMarks = 0;
    $totalMinutesWorked = 0;

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $workedMinutes = $row['worked_minutes'] ?? 0;
            $inTime = $row['in_time_only'] ?? '00:00:00';
            $outTime = $row['out_time_only'] ?? '00:00:00';
            $totalMinutesWorked += $workedMinutes;

            if ($workedMinutes >= 525) {
                $fullDays++;
            } elseif ($workedMinutes >= 240 && $workedMinutes <= 480) {
                $halfDays++;
            }

            if (strtotime($inTime) > strtotime('09:45:00')) {
                $lateMarks++;
            }
        }

        // Calculate adjusted half days from late marks
        $adjustedHalfDays = $halfDays + intdiv($lateMarks, 3);
        $totalDaysWorked = $fullDays + ($adjustedHalfDays / 2);

        // Fetch employee details
        $employeeSql = "SELECT * FROM new_employee WHERE id='$employeeId'";
        $employeeResult = $conn->query($employeeSql);
        $employee = $employeeResult->fetch_assoc();

        $employeeName = $employee['name'] ?? 'N/A';
        $employeeDesignation = $employee['role'] ?? 'N/A';
        $employeeID = $employee['emp_id'] ?? 'N/A';
        $monthlySalary = $employee['salary'] ?? 0;
        $payMode = $employee['pay_mode'] ?? 'N/A';

        // Calculate salary
        $workingDaysInMonth = date('t', strtotime($firstDayOfMonth));
        $dailyRate = $monthlySalary / $workingDaysInMonth;
        $totalSalary = $totalDaysWorked * $dailyRate;

        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip</title>
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <style>
    .salary-slip {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .header {
        background: #f8f9fa;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .details-row {
        margin-bottom: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .label {
        font-weight: bold;
        color: #555;
    }

    .value {
        color: #333;
    }

    .total-row {
        background: #e9ecef;
        padding: 10px;
        margin-top: 20px;
        border-radius: 5px;
    }

    .download-btn {
        margin-top: 20px;
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="salary-slip">
            <div class="header text-center">
                <?php
    // Convert numeric month to word format
    $monthName = DateTime::createFromFormat('!m', $month)->format('F'); // 'F' gives the full month name
    ?>
                <h2>Salary Slip - <?php echo $monthName . ' ' . $year; ?></h2>
            </div>

            <div class="employee-details">
                <div class="row details-row">
                    <div class="col-md-3 label">Employee Name:</div>
                    <div class="col-md-9 value"><?php echo $employeeName; ?></div>
                </div>
                <div class="row details-row">
                    <div class="col-md-3 label">Employee ID:</div>
                    <div class="col-md-9 value"><?php echo $employeeID; ?></div>
                </div>
                <div class="row details-row">
                    <div class="col-md-3 label">Designation:</div>
                    <div class="col-md-9 value"><?php echo $employeeDesignation; ?></div>
                </div>
                <div class="row details-row">
                    <div class="col-md-3 label">Pay Mode:</div>
                    <div class="col-md-9 value"><?php echo $payMode; ?></div>
                </div>
            </div>

            <div class="attendance-details mt-4">
                <h4 class="mb-3">Attendance & Salary Details</h4>
                <div class="row details-row">
                    <div class="col-md-3 label">Monthly Salary:</div>
                    <div class="col-md-9 value">Rs. <?php echo number_format($monthlySalary, 2); ?></div>
                </div>
                <div class="row details-row">
                    <div class="col-md-3 label">Working Days:</div>
                    <div class="col-md-9 value"><?php echo $workingDaysInMonth; ?> days</div>
                </div>
                <div class="row details-row">
                    <div class="col-md-3 label">Full Days:</div>
                    <div class="col-md-9 value"><?php echo $fullDays; ?> days</div>
                </div>
                <div class="row details-row">
                    <div class="col-md-3 label">Half Days:</div>
                    <div class="col-md-9 value"><?php echo $halfDays; ?> days</div>
                </div>
                <div class="row details-row">
                    <div class="col-md-3 label">Late Marks:</div>
                    <div class="col-md-9 value"><?php echo $lateMarks; ?> marks</div>
                </div>
                <div class="row details-row">
                    <div class="col-md-3 label">Total Days Worked:</div>
                    <div class="col-md-9 value"><?php echo number_format($totalDaysWorked, 2); ?> days</div>
                </div>
            </div>

            <div class="row total-row">
                <div class="col-md-3 label">Net Salary:</div>
                <div class="col-md-9 value"><strong>Rs. <?php echo number_format($totalSalary, 2); ?></strong></div>
            </div>

            <div class="download-btn">
                <form action="download_salary_slip.php" method="POST">
                    <input type="hidden" name="employee_id" value="<?php echo $employeeId; ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-download"></i> Download PDF
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
    } else {
        echo '<div class="alert alert-danger text-center">No attendance data found for current month.</div>';
    }
} else {
    echo '<div class="alert alert-danger text-center">Invalid Request</div>';
}
?>