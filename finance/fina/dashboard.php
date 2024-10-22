<?php 
session_start(); 
include("conne.php");

if(!$db){
    echo "Disconnected: " . mysqli_connect_error();
    exit;
}

$username = "Guest";
$user_id = null;


if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    
    $user_id = mysqli_real_escape_string($db, $user_id);

    $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($db, $sql);

    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
    } else {
        $username = "Unknown User";
    }
} 


$total_price = 0;
$total_budget = 0;
$budget_left = 0;
$dataPointsBudgetLeft = array();
$dataPointsExpenses = array();

if ($user_id) {
    $sql_track = "
        SELECT track.date, SUM(track.amount) as total_expenses, SUM(track.budget) as total_budget 
        FROM track 
        WHERE track.user_id = '$user_id' 
        GROUP BY YEAR(track.date), MONTH(track.date)
    ";

    $result_track = mysqli_query($db, $sql_track);

    if($result_track && mysqli_num_rows($result_track) > 0) {
        while($st = mysqli_fetch_assoc($result_track)) {
            $date = strtotime($st["date"]) * 1000; 
            $total_price += $st["total_expenses"];
            $total_budget += $st["total_budget"];
            $budget_left = $total_budget - $total_price;

            $dataPointsBudgetLeft[] = array("x" => $date, "y" => $budget_left);
            $dataPointsExpenses[] = array("x" => $date, "y" => $st["total_expenses"]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link rel="icon" href="assets/food-1" type="image/x-icon"/> 
    <title>Financial Management System</title>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Budget Left vs Total Expenses Over Time"
                },
                axisY: {
                    title: "Amount",
                    valueFormatString: "#,##0.##",
                    prefix: "P"
                },
                data: [
                    {
                        type: "spline",
                        name: "Budget Left",
                        showInLegend: true,
                        markerSize: 5,
                        xValueFormatString: "MMM YYYY",
                        yValueFormatString: "P#,##0.##",
                        xValueType: "dateTime",
                        dataPoints: <?php echo json_encode($dataPointsBudgetLeft, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "spline",
                        name: "Total Expenses",
                        showInLegend: true,
                        markerSize: 5,
                        xValueFormatString: "MMM YYYY",
                        yValueFormatString: "P#,##0.##",
                        xValueType: "dateTime",
                        dataPoints: <?php echo json_encode($dataPointsExpenses, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });

            chart.render();
        }
    </script>
    <style>
        #chartContainer {
            height: 400px; 
            width: 500px; 
            margin: 20px auto;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2>Sidebar</h2>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="tracker.php">Tracker</a></li>
                <li><a href="add.php">Add</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="login.php">Logout</a></li>
            </ul>
        </div>
        <div class="main">
            <div class="header">Welcome <?php echo $username; ?></div>
            <div class="info">
                <div class="budgetcard">
                    <p>Budget Left:</p>
                    <div class="val">
                        <label for="">P</label>
                        <label for="totalexpenses"><?php echo number_format($budget_left, 2); ?></label>
                    </div>
                </div>
                <div class="totalcard">
                    <p>Total Expenses:</p>
                    <div class="val">
                        <label for="">P</label>
                        <label for="totalexpenses"><?php echo number_format($total_price, 2); ?></label>
                    </div>
                </div>
            </div>
            <div id="chartContainer"></div>
        </div>
    </div>
</body>
</html>
