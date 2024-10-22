<?php
    include("conne.php");
    $date = $_GET["date"];
    $note = $_GET["note"];
    mysqli_query($db,"DELETE FROM track where note='".$note."'") or die(mysqli_error());
    echo "<script>
        alert('Deleted Successfully');
        window.open('tracker.php','_self');
        </script>";
?>