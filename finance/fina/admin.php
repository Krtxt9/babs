<?php
session_start();
include("conne.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$query = "
    SELECT u.user_id, u.username, u.email, u.role, 
           SUM(t.budget) AS budget, 
           SUM(t.amount) AS amount 
    FROM user u 
    LEFT JOIN track t ON u.user_id = t.user_id 
    GROUP BY u.user_id, u.username, u.email, u.role";

$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>User Management</title>
</head>
<body>
    <div class="navbar">
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="User_Dashboard.php"> User Dashboard</a>
            <a href="#"> User Activities</a>
            <a href="login.php">Logout</a> 
        </nav>
    </div>
    
    <div class="content">
        <h2>User Management</h2>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Budget</th>
                    <th>Expenses</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td><?php echo isset($row['budget']) ? $row['budget'] : 'N/A'; ?></td>
                        <td><?php echo isset($row['amount']) ? $row['amount'] : 'N/A'; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
