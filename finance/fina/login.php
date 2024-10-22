<?php
session_start();
include("conne.php"); // Make sure your database connection is established here

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch user details based on email and password
    $myquery = mysqli_query($db, "SELECT * FROM user WHERE `email` = '$email' AND password = '$password'");
    $row = mysqli_fetch_assoc($myquery);

    if (!$row) {
        echo "<script>
            alert('Wrong Email or Password!');
            window.location.href='login.php'; 
            </script>";
    } else {
        // Set session variables
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username']; // Store the username in session
        $_SESSION['role'] = $row['role']; // Store the role in session

        // Redirect based on role
        if ($row['role'] === 'admin') {
            header("Location: admin.php"); // Redirect to admin dashboard
        } else {
            header("Location: dashboard.php"); // Redirect to user dashboard
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="C:\xampp\htdocs\finance\fina\SAD.jpg" type="image/x-icon"/> 
    <title>Financial Compass: Navigating your Budgeting Journey with an Interactive Website</title>
</head>
<body>
    <div class="container">
        <form action="login.php" method="POST">
            <div class="login-box">
                <div class="headertext">
                    <p>Login</p>
                </div>
                <div class="input">
                    <input type="text" class="field" name="email" id="email" placeholder="Email" required>
                </div>
                <div class="input">
                    <input type="password" class="field" name="password" id="password" placeholder="Password" required>
                </div>
                <div class="forget-pass">
                    <a href="signup.php">Doesn't have an account?</a>
                </div>
                <div class="input">
                    <button type="submit" class="input-submit" name="submit">Login</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
