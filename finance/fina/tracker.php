<?php 
session_start();
include("conne.php");

if (!$db) {
    echo "Disconnected" . mysqli_connect_error();
} else {
    // Check if user is logged in and set user_id
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Fetch user details
        $sql_username = "SELECT * FROM user WHERE user_id = $user_id";
        $result_username = mysqli_query($db, $sql_username);
        if (mysqli_num_rows($result_username) > 0) {
            $row_username = mysqli_fetch_assoc($result_username);
            $username = $row_username['username'];
        } else {
            $username = "Unknown User";
        }

        // Fetch tracker data for the logged-in user
        $sql_track = "SELECT track.date, track.note, track.amount, track.budget 
                      FROM track 
                      JOIN user ON track.user_id = user.user_id 
                      WHERE track.user_id = $user_id";
        $result_track = mysqli_query($db, $sql_track);

    } else {
        $username = "Guest";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="track.css">
    <link rel="icon" href="C:\xampp\htdocs\finance\fina\SAD.jpg" type="image/x-icon"/> 
    <title>Financial Compass: Navigating your Budgeting Journey with an Interactive Website</title>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2>Sidebar</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="tracker.php">Tracker</a></li>
                <li><a href="add.php">Add</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="login.php">Logout</a></li>
            </ul>
        </div>
        <div class="main">
            <div class="header">Tracker</div>
            <div class="info">
                <table>
                    <thead>
                        <th>Date</th>
                        <th>Note</th>
                        <th>Budget</th>
                        <th>Expenditure</th>
                        <th>Remove</th>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($result_track)) {
                            if(mysqli_num_rows($result_track) > 0) {
                                while($st = mysqli_fetch_assoc($result_track)) {
                                    echo "<tr>";
                                    echo "<td>".$st["date"]."</td>";
                                    echo "<td>".$st["note"]."</td>";
                                    echo "<td>".$st["budget"]."</td>";
                                    echo "<td>".$st["amount"]."</td>";
                                    echo "<td><a href='del.php?note=".$st["note"]."'><button type='button' name='submit' class='button remove-btn'>
                                                <svg class='w-6 h-6 text-gray-800 dark:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                                                    <path fill-rule='evenodd' d='M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm5.757-1a1 1 0 1 0 0 2h8.486a1 1 0 1 0 0-2H7.757Z' clip-rule='evenodd'/>
                                                </svg>
                                            </button></a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'><center>NO DATA EXIST</center></td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                    <tfooter>
                        <?php
                            $sql_track = "SELECT track.date, track.note, track.amount, track.budget FROM track JOIN user ON track.user_id = user.user_id WHERE track.user_id = $user_id";
                            $result_track = mysqli_query($db, $sql_track);
                            $total_price = 0;
                            if(isset($result_track) && mysqli_num_rows($result_track) > 0) {
                                while($st = mysqli_fetch_assoc($result_track)) {
                                    $total_price += $st["amount"];
                                }
                            }
                                
                                
                        ?>
                        <tr>
                            <td colspan="3">Total</td>
                            <td colspan="2"><?php echo $total_price; ?></td>
                                
                            </td>
                        </tr>
                    </tfooter>
                </table>
                
            </div>
        </div>
    </div>
</body>
</html>
