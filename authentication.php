<?php
    $conn = mysqli_connect('localhost', 'root', '', 'boosted');
    if(!$conn){
        die("Database Connection Failed!" . mysqli_error());
    }
    /* else {
        echo "Database Connection Successful!";
    } */
?>