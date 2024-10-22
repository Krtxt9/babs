<?php
include("conne.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css"> 
    <link rel="icon" href="C:\xampp\htdocs\finance\fina\SAD.jpg" type="image/x-icon"/> 
    
    <title>Financial Compass: Navigating your Budgeting Journey with an Interactive Website</title>
</head>
<body>
    <div class="container">
        <form method="POST">
            <div class="login-box">
                <div class="headertext">
                    <p>Sign Up</p>
                </div>
        
                <div class="input">
                    <input type="text" class="field" name="username" placeholder="Username" required>
                </div>
                <div class="input">
                    <input type="email" class="field" name="email" placeholder="Email" required>
                </div>
                <div class="input">
                    <input type="password" class="field" name="password" placeholder="Password" required>
                </div>
                <div class="input">
                    <label for="role" style="color: white;">Select Role:</label>
                    <select name="role" id="role" class="field" required>
                        <option value="" disabled selected>Select your role</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="forget-pass">
                    <a href="login.php">Already have an account?</a>
                </div>
                <div class="input">
                    <button type="submit" name="submit" class="input-submit">Sign Up</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST["submit"])) {
    
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    
    
    $myquery = mysqli_query($db, "SELECT * FROM user WHERE username='" . $username . "' AND email='" . $email . "'") or die(mysqli_error($db)); 
    $row = mysqli_num_rows($myquery);
    
    if ($row > 0) {
        echo "<script>
        alert('User Already Exists!');
        window.location.href='signup.php'; 
        </script>";
    } else {
        
        mysqli_query($db, "INSERT INTO user(username, email, password, role) VALUES('" . $username . "', '" . $email . "', '" . $password . "', '" . $role . "')") or die(mysqli_error($db)); 
        echo "<script>
            alert('User Inserted Successfully');
            window.location.href='login.php'; 
            </script>";
    }
}
?>
