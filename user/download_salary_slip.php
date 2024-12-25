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
    
    // Get current month date range
    $firstDayOfMonth = date('Y-m-01');
    $lastDayOfMonth = date('Y-m-t');
    
    include '../dbconnection.php';
    
    // Fetch current month's attendance
    $sql = "SELECT *, 
                   TIMESTAMPDIFF(MINUTE, in_time, out_time) AS worked_minutes,
                   TIME(in_time) AS in_time_only,
                   TIME(out_time) AS out_time_only
            FROM employee_attendance 
            WHERE emp_id = '$employeeId'
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
        $employeeDesignation = $employee['designation'] ?? 'N/A';
        $employeeID = $employee['emp_id'] ?? 'N/A';
        $monthlySalary = $employee['salary'] ?? 0;
        $payMode = $employee['pay_mode'] ?? 'N/A';

        // Calculate salary
        $workingDaysInMonth = date('t');
        $dailyRate = $monthlySalary / $workingDaysInMonth;
        $totalSalary = $totalDaysWorked * $dailyRate;

        // Create PDF
        $pdf = new SalarySlipPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Salary Slip - ' . date('F Y'), 0, 1, 'C');
        
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(10);

        // Employee Details
        $pdf->Cell(40, 10, 'Employee Name:', 0, 0);
        $pdf->Cell(0, 10, $employeeName, 0, 1);
        
        $pdf->Cell(40, 10, 'Employee ID:', 0, 0);
        $pdf->Cell(0, 10, $employeeID, 0, 1);
        
        $pdf->Cell(40, 10, 'Designation:', 0, 0);
        $pdf->Cell(0, 10, $employeeDesignation, 0, 1);

        $pdf->Cell(40, 10, 'Pay Mode:', 0, 0);
        $pdf->Cell(0, 10, $payMode, 0, 1);
        
        $pdf->Ln(10);
        
        // Attendance Details
        $pdf->Cell(40, 10, 'Monthly Salary:', 0, 0);
        $pdf->Cell(0, 10, 'Rs. ' . number_format($monthlySalary, 2), 0, 1);

        $pdf->Cell(40, 10, 'Full Days:', 0, 0);
        $pdf->Cell(0, 10, $fullDays . ' days', 0, 1);

        $pdf->Cell(40, 10, 'Half Days:', 0, 0);
        $pdf->Cell(0, 10, $halfDays . ' days', 0, 1);

        $pdf->Cell(40, 10, 'Late Marks:', 0, 0);
        $pdf->Cell(0, 10, $lateMarks . ' marks', 0, 1);

        $pdf->Cell(40, 10, 'Total Days Worked:', 0, 0);
        $pdf->Cell(0, 10, number_format($totalDaysWorked, 2) . ' days', 0, 1);

        $pdf->Ln(10);

        // Total Salary
        $pdf->Cell(40, 10, 'Net Salary:', 0, 0);
        $pdf->Cell(0, 10, 'Rs. ' . number_format($totalSalary, 2), 0, 1);

        // Output PDF
        $pdf->Output('D', 'Salary_Slip_' . $employeeName . '_' . date('F_Y') . '.pdf');
    } else {
        echo '<div class="alert alert-danger text-center">No attendance data found for current month.</div>';
    }
} else {
    echo '<div class="alert alert-danger text-center">Invalid Request</div>';
}
?>
