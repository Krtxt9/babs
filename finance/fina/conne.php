<?php
    $db = mysqli_connect("localhost","root","","finance"); //finance name ng database
    if(mysqli_connect_errno()){
        echo "Failed to connect to the database ".mysqli_connect_error();
    }
    else{
        echo "";
    }
?>