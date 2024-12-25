<?php
session_start();
if (empty($_SESSION['user1_session'])) {
    header('Location:login.php');
}
$id = $_GET['id'];
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

    <style>
    .month-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        max-width: 1200px;
    }

    .month-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 0 20px;
    }

    .month-title {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .month-navigation {
        display: flex;
        gap: 15px;
    }

    .nav-btn {
        background: linear-gradient(135deg, #6B8DD6 0%, #8E37D7 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        font-size: 16px;
    }

    .nav-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }

    .week-day {
        text-align: center;
        font-weight: 600;
        color: #666;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 10px;
        font-size: 14px;
    }

    .calendar-day {
        aspect-ratio: 1;
        border-radius: 12px;
        padding: 10px;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
    }

    .calendar-day:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .day-number {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .attendance-info {
        font-size: 12px;
        color: #666;
    }

    .present {
        background: linear-gradient(135deg, #e7f6e7 0%, #c3e6cb 100%);
    }

    .late {
        background: linear-gradient(135deg, #e1f0ff 0%, #b8daff 100%);
    }

    .half-day {
        background: linear-gradient(135deg, #fff3e0 0%, #ffeeba 100%);
    }

    .absent {
        background: linear-gradient(135deg, #ffe7e7 0%, #f5c6cb 100%);
    }

    .tooltip-content {
    display: none;
    position: absolute;
    background: white;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    min-width: 200px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
}

    .calendar-day:hover .tooltip-content {
        display: block;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-box {
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .stat-box:hover {
        transform: translateY(-5px);
    }

    .stat-number {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 8px;
        background: linear-gradient(135deg, #6B8DD6 0%, #8E37D7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stat-label {
        font-size: 16px;
        color: #666;
    }

    @media (max-width: 768px) {
        .month-container {
            padding: 15px;
            margin: 10px;
        }

        .calendar-grid {
            gap: 8px;
        }

        .day-number {
            font-size: 14px;
        }

        .attendance-info {
            font-size: 10px;
        }

        .month-title {
            font-size: 20px;
        }

        .nav-btn {
            padding: 8px 15px;
            font-size: 14px;
        }
    }
    </style>
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
                            <div class="stat-number"><?php echo $lateMarks; ?></div>
                            <div class="stat-label">Late Marks</div>
                        </div>
                        <div class="stat-box" style="background-color: #fff3e0;">
                            <div class="stat-number"><?php echo $halfDays; ?></div>
                            <div class="stat-label">Half Days</div>
                        </div>
                        <div class="stat-box" style="background-color: #ffe7e7;">
                            <div class="stat-number">
                                <?php echo date('t', strtotime($firstDay)) - $fullDays - $halfDays; ?></div>
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