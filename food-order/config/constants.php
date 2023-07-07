<?php 

    // start session
    SESSION_start();

   // create to store non repeate values
   define('SITEURL','http://localhost/food-order/');
   define('LOCALHOST','localhost');
   define('DB_USERNAME','root');
   define('DB_PASSWORD','');
   define('DB_NAME','food-order');


    $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());//DB connection username and password
    $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error()); //selsecting DB
?>