<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_id'])) {
    // Database connection
    require_once '../dbconnection.php';
    
    // Get POST data
    $employeeId = $_POST['employee_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Format dates
    $firstDayOfMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
    $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));
    $monthName = date('F', strtotime($firstDayOfMonth));

    // Fetch employee details
    $employeeSql = "SELECT * FROM new_employee WHERE id = ?";
    $stmt = $conn->prepare($employeeSql);
    $stmt->bind_param("s", $employeeId);
    $stmt->execute();
    $employeeResult = $stmt->get_result();
    $employee = $employeeResult->fetch_assoc();

    // Fetch attendance data
    // Fetch attendance data
$attendanceSql =  "SELECT *, 
TIMESTAMPDIFF(MINUTE, in_time, out_time) AS worked_minutes,
TIME(in_time) AS in_time_only,
TIME(out_time) AS out_time_only
FROM employee_attendance 
WHERE emp_id = ? 
AND MONTH(date) = ? 
AND YEAR(date) = ? 
AND date BETWEEN ? AND ?";

$stmt = $conn->prepare($attendanceSql);
$stmt->bind_param("sssss", $employeeId, $month, $year, $firstDayOfMonth, $lastDayOfMonth);
$stmt->execute();
$attendanceResult = $stmt->get_result();

    // Calculate attendance metrics
    $presentDays = 0;
    $fullDays = 0;
    $halfDays = 0;
    $lateMarks = 0;
    $totalMinutesWorked = 0;
    $totalDays = date('t', strtotime($firstDayOfMonth));

    while ($row = $attendanceResult->fetch_assoc()) {
        $workedMinutes = $row['worked_minutes'] ?? 0;
        $inTime = $row['in_time_only'] ?? '00:00:00';
        $totalMinutesWorked += $workedMinutes;

        if ($workedMinutes >= 525) { // 8.75 hours
            $fullDays++;
            $presentDays++;
        } elseif ($workedMinutes >= 240) { // 4 hours
            $halfDays++;
            $presentDays += 0.5;
        }

        if (strtotime($inTime) > strtotime('09:45:00')) {
            $lateMarks++;
        }
    }

    // Calculate salary components
    $basicPay = 3200.00;
    $hra = 800.00;
    $conveyance = 1200.00;
    $educationAllowance = 800.00;
    $washingAllowance = 400.00;
    $medicalAllowance = 800.00;
    $personalAllowance = 800.00;
    $specialAward = 0.00;
    $incentive = 0.00; // Special Pay

    $monthlyGross = 8000.00;

    // Calculate deductions
    $professionTax = 210.00;
    $canteenDeduction = 0.00;
    $lateMarkDeduction = 0.00;
    $unpaidLeaves = 173.91;
    $halfDayDeduction = 0.00;
    $otherDeductions = 100;

    $totalDeduction = $professionTax + $lateMarkDeduction + 
                     $unpaidLeaves + $halfDayDeduction + $otherDeductions;
    $totalSalary = $monthlyGross - $totalDeduction;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/pol/logo1.jpeg">

    <title>Salary Slip</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f5f5f5;
    }

    .salary-slip {
        width: 800px;
        margin: 0 auto;
        border: 1px solid #000;
        background-color: white;
        padding: 1px;
    }

    .header {
        text-align: left;
        border-bottom: 1px solid #000;
        padding: 10px;
    }

    .header img {
        height: 50px;
    }

    .header-address {
        font-size: 12px;
        margin-top: 5px;
    }

    .title {
        text-align: center;
        font-weight: bold;
        padding: 5px;
        border-bottom: 1px solid #000;
    }

    .employee-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-bottom: 1px solid #000;
        font-size: 12px;
    }

    .info-item {
        padding: 5px;
        border-right: 1px solid #000;
    }

    .info-item:last-child {
        border-right: none;
    }

    .attendance-info {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        border-bottom: 1px solid #000;
        font-size: 12px;
    }

    .attendance-item {
        padding: 5px;
        border-right: 1px solid #000;
    }

    .attendance-item:last-child {
        border-right: none;
    }

    .salary-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-bottom: 1px solid #000;
    }

    .earnings,
    .deductions {
        padding: 10px;
    }

    .earnings {
        border-right: 1px solid #000;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        padding: 3px 0;
        font-size: 12px;
    }

    .highlight {
        background-color: #FFD700;
    }

    .total-row {
        background-color: #90EE90;
        font-weight: bold;
    }

    .footer {
        padding: 10px;
        font-size: 11px;
        text-align: center;
        border-top: 1px solid #000;
    }

    .download-btn-style {
        background: linear-gradient(135deg, #00bfff, #1e90ff);
        /* Gradient background */
        color: white;
        /* Text color */
        padding: 12px 30px;
        /* Padding for size */
        font-size: 16px;
        /* Font size */
        font-weight: bold;
        /* Bold text */
        border: none;
        border-radius: 50px;
        /* Rounded corners */
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        /* Smooth transition for hover effects */
    }

    .download-btn-style i {
        font-size: 18px;
        /* Icon size */
    }

    .download-btn-style:hover {
        background: linear-gradient(135deg, #1e90ff, #00bfff);
        /* Inverted gradient on hover */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        /* Hover shadow */
    }

    .download-btn-style:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(29, 161, 242, 0.6);
        /* Blue outline on focus */
    }




    @media (min-width: 260px) and (max-width: 780px) {
        #download-btn {
            margin-left: -270px !important;
        }

        #comments {
            display: inline !important;
        }
    }
    </style>
</head>

<body>
    <div class="salary-slip">
        <div class="header">
            <img src="../assets/images/pol/logo1.jpeg" alt="Swapra Technologies">
            <div class="header-address">Neeta Tower Kasarwadi Pune-411012</div>
        </div>

        <div class="title">Salary slip for the month of <?php echo htmlspecialchars($monthName . ' ' . $year); ?></div>

        <div class="employee-info">
            <div class="info-item">
                <div>Name: <?php echo htmlspecialchars($employee['name']); ?></div>
                <div>Designation: <?php echo htmlspecialchars($employee['role']); ?></div>
                <div>Location: <?php echo htmlspecialchars($employee['location'] ?? ''); ?></div>
            </div>
            <div class="info-item">
                <div>EMP ID: <?php echo htmlspecialchars($employee['emp_id']); ?></div>
                <div>ESI No.: <?php echo htmlspecialchars($employee['esi_no'] ?? 'No'); ?></div>
                <div>P.F. No.: <?php echo htmlspecialchars($employee['pf_no'] ?? 'No'); ?></div>
            </div>
            <div class="info-item">
                <div>Pay Mode: <?php echo htmlspecialchars($employee['pay_mode']); ?></div>
                <div>Bank A/c No.: <?php echo htmlspecialchars($employee['acc_number']); ?></div>
                <div>IFSC CODE: <?php echo htmlspecialchars($employee['ifsc_code']); ?></div>
            </div>
        </div>

        <div class="attendance-info">
            <div class="attendance-item">
                <div>Full Day: <?php echo $fullDays; ?></div>
            </div>
            <div class="attendance-item">
                <div>Half Day:<?php echo $halfDays; ?> </div>
            </div>
            <div class="attendance-item">
                <div>Late Mark: <?php echo $lateMarks; ?></div>
            </div>
            <div class="attendance-item">
                <div>Total Working Days: <?php echo $lateMarks; ?></div>
            </div>
        </div>

        <div class="salary-details">
            <div class="earnings">
                <div class="detail-row highlight">
                    <span>Basic Pay</span>
                    <span><?php echo number_format($basicPay, 2); ?></span>
                </div>
                <div class="detail-row">
                    <span>H.R.A</span>
                    <span><?php echo number_format($hra, 2); ?></span>
                </div>
                <div class="detail-row highlight">
                    <span>Conveyance</span>
                    <span><?php echo number_format($conveyance, 2); ?></span>
                </div>
                <div class="detail-row">
                    <span>Education Allowance</span>
                    <span><?php echo number_format($educationAllowance, 2); ?></span>
                </div>
                <div class="detail-row highlight">
                    <span>Washing Allowance</span>
                    <span><?php echo number_format($washingAllowance, 2); ?></span>
                </div>
                <div class="detail-row">
                    <span>Medical Allowance</span>
                    <span><?php echo number_format($medicalAllowance, 2); ?></span>
                </div>
                <div class="detail-row highlight">
                    <span>Personal Allowance</span>
                    <span><?php echo number_format($personalAllowance, 2); ?></span>
                </div>
                <div class="detail-row">
                    <span>Special Award</span>
                    <span><?php echo number_format($specialAward, 2); ?></span>
                </div>
                <div class="detail-row highlight">
                    <span>Incentive (Special Pay)</span>
                    <span><?php echo number_format($incentive, 2); ?></span>
                </div>
                <div class="detail-row">
                    <span>Monthly Gross</span>
                    <span><?php echo htmlspecialchars($employee['salary']); ?></span>
                </div>
            </div>

            <div class="deductions">
                <div class="detail-row highlight">
                    <span>Profession Tax</span>
                    <span><?php echo number_format($professionTax, 2); ?></span>
                </div>
                <div class="detail-row">
                    <span>Canteen</span>
                    <span><?php echo number_format($canteenDeduction, 2); ?></span>
                </div>
                <div class="detail-row highlight">
                    <span>Late Mark</span>
                    <span><?php echo $lateMarks; ?></span>
                </div>
                <div class="detail-row">
                    <span>Unpaid leaves</span>
                    <span><?php echo number_format($unpaidLeaves, 2); ?></span>
                </div>
                <div class="detail-row highlight">
                    <span>Half Day</span>
                    <span><?php echo $halfDays; ?> </span>
                </div>
                <div class="detail-row">
                    <span>Other Deductions</span>
                    <span><?php echo number_format($otherDeductions, 2); ?></span>
                </div>
                <div class="detail-row">
                    <span>Total Deduction</span>
                    <span><?php echo number_format($totalDeduction, 2); ?></span>
                </div>
                <div class="detail-row total-row">
                    <span>Net Salary</span>
                    <span><?php echo number_format($totalSalary, 2); ?></span>
                </div>
            </div>
        </div>



        <div class="footer">
            Note: This is computer generated copy therefore no need to sign.
        </div>
    </div><br><br>

    <!-- <div id="download-btn" class="download-btn text-center mt-4">
        <form action="download_salary_slip.php" method="POST">
            <input type="hidden" name="employee_id" value="<?php echo $employeeId; ?>">
            <button type="submit"
                class="btn btn-primary btn-lg shadow-lg rounded-pill d-flex align-items-center justify-content-center download-btn-style"
                style="margin-left: 570px;">
                <i class="fas fa-download mr-2"></i>
                <span class="font-weight-bold">Download PDF</span>
            </button>
        </form>
    </div> -->


</body>

</html>
<?php
} else {
    echo '<div class="alert">Invalid Request</div>';
}
?>