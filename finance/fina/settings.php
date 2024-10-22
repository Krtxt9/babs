
<?php
    session_start(); 
    include("conne.php");

    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM user WHERE user_id = $user_id";
        $result = mysqli_query($db, $sql);
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username = $row['username'];
            $email = $row['email'];
            $password = $row['password'];
        }
    }

    if(isset($_POST['submit'])) {
        // Process form submission
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $update_query = "UPDATE user SET username='$username', email='$email', password='$password' WHERE user_id='$user_id'";
        $update_result = mysqli_query($db, $update_query);
        if($update_result) {
            // Redirect to a success page or display a success message
            echo "<script>
            alert('User details updated successfully.');
            window.location.href='dashboard.php'; 
            </script>";
        } else {
            // Handle update failure
            echo "<script>
            alert('Failed to update user details.');
            window.location.href='dashboard.php'; 
            </script>";
        }
    }
    if(isset($_POST['return'])) {
        
        echo "<script>
        window.location.href='dashboard.php'; 
        </script>";
        
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
        <form method="POST">
            <div class="login-box">
                <div class="headertext">
                    <p>Settings</p>
                </div>
                <div class="input">
                    <input type="text" class="field" name="username" id="username" value="<?php echo isset($username) ? $username : ''; ?>" required>
                </div>
                <div class="input">
                    <input type="email" class="field" name="email" id="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
                </div>
                <div class="input">
                    <input type="text" class="field" name="password" id="password"  value="<?php echo isset($password) ? $password : ''; ?>" required>
                </div>
                
                <div class="input" >
                    <button type="submit" class="input-submit" name="submit">Save</button>
                    <button type="submit" name="return"  class="input-submit" style="background-color: red;">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

