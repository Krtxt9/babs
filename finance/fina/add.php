<?php
session_start();
include("conne.php");

// Check if user_id is set in session
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id']; // Get user_id from session
    $date = $_POST["date"];
    $note = isset($_POST["note"]) ? $_POST["note"] : ""; 
    $budget = $_POST["budget"];
    $amount = $_POST["amount"];

    // Check if the combination of date and note already exists for the logged-in user
    $check_query = "SELECT * FROM track WHERE user_id = $user_id AND date = '$date' AND note = '$note'";
    $check_result = mysqli_query($db, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If a record with the same date and note exists, display an error message
        echo "<script>
            alert('A record with the same date and note already exists.');
            window.location.href='add.php';  
        </script>";
    } else {
        // If the combination of date and note doesn't exist, insert the new record
        $insert_query = "INSERT INTO track(user_id, date, note, budget, amount) VALUES ('$user_id', '$date', '$note', '$budget', '$amount')";
        mysqli_query($db, $insert_query) or die(mysqli_error($db));
        echo "<script>
            alert('Inserted Successfully');
            window.location.href='add.php'; 
        </script>";
    }
}

if (isset($_POST['return'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="add.css">
    <link rel="icon" href="assets/food-1" type="image/x-icon"/> 
    
    <title>Financial Compass: Navigating your Budgeting Journey with an Interactive Website</title>
</head>
<body>
    <div class="container">
        <form method="POST">
            <div class="login-box">
                <div class="headertext">
                    <p>Add to Tracker</p>
                </div>
                <div class="input">
                    <input type="date" class="field" name="date">
                   
                </div>
                <div class="input">
                    <input type="text" class="field" name="note" placeholder="Note" >
                    
                </div>
                <div class="input">
                    <input type="number" class="field" name="budget" placeholder="Budget" >
                    
                </div>
                <div class="input">
                    <input type="number" class="field" name="amount" placeholder="Expenditure" >
                    
                </div>
                
                <div class="input">
                    <button type="submit" name="submit" class="input-submit">Add</button>
                    <button type="submit" class="input-submit" name="return" style="background-color: red;">Cancel</button>
                </div>
            
            </div>
        </form>
    </div>
</body>
</html>
