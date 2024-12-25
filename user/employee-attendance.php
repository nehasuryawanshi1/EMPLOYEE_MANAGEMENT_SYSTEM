<?php
session_start();
if (empty($_SESSION['user1_session'])) {
    header('Location:login.php');
}
$id = $_SESSION['user1_session']['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Attendance - Swapra Technologies</title>
    <link rel="shortcut icon" href="../assets/images/pol/logo1.jpeg">
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style1.css">
</head>

<body>
    <div class="main-wrapper">
        <?php include 'top.php'; ?>
        <?php include 'sidebar.php'; ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <?php
                include '../dbconnection.php';
                $id = $_SESSION['user1_session']['id'];

                // Get current month and year from URL parameters or use current date
                $month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
                $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

                // Calculate previous and next month/year
                $prevMonth = $month - 1;
                $prevYear = $year;
                if ($prevMonth < 1) {
                    $prevMonth = 12;
                    $prevYear--;
                }

                $nextMonth = $month + 1;
                $nextYear = $year;
                if ($nextMonth > 12) {
                    $nextMonth = 1;
                    $nextYear++;
                }

                // Fetch attendance data for the current month
                $firstDay = "$year-$month-01";
                $lastDay = date('Y-m-t', strtotime($firstDay));

                $sql = "SELECT *, 
                       TIMESTAMPDIFF(MINUTE, in_time, out_time) AS worked_minutes,
                       TIME(in_time) AS in_time_only,
                       TIME(out_time) AS out_time_only,
                       DATE(date) as attendance_date
                FROM employee_attendance 
                WHERE emp_id = '$id' 
                AND date BETWEEN '$firstDay' AND '$lastDay'";

                $result = $conn->query($sql);

                // Initialize counters
                $fullDays = 0;
                $halfDays = 0;
                $lateMarks = 0;
                $totalMinutesWorked = 0;
                $attendanceData = [];

                // Process attendance data
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $workedMinutes = $row['worked_minutes'] ?? 0;
                        $inTime = $row['in_time_only'] ?? '00:00:00';
                        $outTime = $row['out_time_only'] ?? '00:00:00';
                        $date = $row['attendance_date'];
                        $totalMinutesWorked += $workedMinutes;

                        $attendanceData[$date] = [
                            'status' => '',
                            'in_time' => $inTime,
                            'out_time' => $outTime,
                            'worked_hours' => number_format($workedMinutes / 60, 1)
                        ];

                        // Check attendance status
                        if ($workedMinutes >= 525) {
                            $fullDays++;
                            $attendanceData[$date]['status'] = 'present';
                        } elseif ($workedMinutes >= 240) {
                            $halfDays++;
                            $attendanceData[$date]['status'] = 'half-day';
                        }

                        if (strtotime($inTime) > strtotime('09:45:00')) {
                            $lateMarks++;
                            $attendanceData[$date]['status'] = 'late';
                        }
                    }
                }

                // Do not modify Late Marks and Half Days for display
                $displayLateMarks = $lateMarks;
                $displayHalfDays = $halfDays;

                // For salary calculation, treat every 3 late marks as 1 half day
                $additionalHalfDaysForLateMarks = floor($lateMarks / 3); // 3 late marks = 1 half day
                $halfDays += $additionalHalfDaysForLateMarks;

                $totalHours = number_format($totalMinutesWorked / 60, 1);
                ?>

                <div class="month-container">
                    <div class="month-header">
                        <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>" class="nav-btn">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                        <h2 class="month-title">
                            <?php echo date('F Y', strtotime("$year-$month-01")); ?>
                        </h2>
                        <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>" class="nav-btn">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>

                    <!-- Statistics -->
                    <div class="stats-container">
                        <div class="stat-box" style="background-color: #e7f6e7;">
                            <div class="stat-number"><?php echo $fullDays; ?></div>
                            <div class="stat-label">Present Days</div>
                        </div>
                        <div class="stat-box" style="background-color: #e1f0ff;">
                            <div class="stat-number"><?php echo $displayLateMarks; ?></div>
                            <div class="stat-label">Late Marks</div>
                        </div>
                        <div class="stat-box" style="background-color: #fff3e0;">
                            <div class="stat-number"><?php echo $displayHalfDays; ?></div>
                            <div class="stat-label">Half Days</div>
                        </div>
                        <div class="stat-box" style="background-color: #ffe7e7;">
                            <div class="stat-number">
                                <?php echo date('t', strtotime($firstDay)) - $fullDays - $displayHalfDays; ?></div>
                            <div class="stat-label">Absent Days</div>
                        </div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="calendar-grid">
                        <?php
                        // Week days header
                        $weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                        foreach ($weekDays as $day) {
                            echo "<div class='week-day'>$day</div>";
                        }

                        // Get first day of month and total days
                        $firstDayOfMonth = date('w', strtotime($firstDay));
                        $totalDays = date('t', strtotime($firstDay));

                        // Empty cells before start of month
                        for ($i = 0; $i < $firstDayOfMonth; $i++) {
                            echo "<div class='calendar-day'></div>";
                        }

                        // Days of the month
                        for ($day = 1; $day <= $totalDays; $day++) {
                            $date = date('Y-m-d', strtotime("$year-$month-$day"));
                            $dayData = $attendanceData[$date] ?? null;
                            $statusClass = $dayData ? ' ' . $dayData['status'] : '';

                            echo "<div class='calendar-day$statusClass'>";
                            echo "<div class='day-number'>$day</div>";

                            if ($dayData) {
                                echo "<div class='attendance-info'>";
                                echo "<small>" . ucfirst($dayData['status']) . "</small>";
                                echo "</div>";

                                echo "<div class='tooltip-content'>";
                                echo "<strong>Date:</strong> $date<br>";
                                echo "<strong>Status:</strong> " . ucfirst($dayData['status']) . "<br>";
                                echo "<strong>In Time:</strong> {$dayData['in_time']}<br>";
                                echo "<strong>Out Time:</strong> {$dayData['out_time']}<br>";
                                echo "<strong>Hours:</strong> {$dayData['worked_hours']}";
                                echo "</div>";
                            }

                            echo "</div>";
                        }
                        ?>
                    </div>
                    <div class="col-md-6 text-right">
                        <form action="generate_salary_slip.php" method="POST">
                            <input type="hidden" name="employee_id" value="<?php echo $id; ?>">
                            <input type="hidden" name="month" value="<?php echo $month; ?>">
                            <input type="hidden" name="year" value="<?php echo $year; ?>">
                            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 16px;">
                                Generate Salary Slip
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>