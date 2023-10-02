<?php
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'wustl_inst';
    $DATABASE_PASS = 'wustl_pass';
    $DATABASE_NAME = 'mod3_blog';
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if($con == false){
        die('Failed to Connect: ' . mysqli_connect_error());
    }
?>