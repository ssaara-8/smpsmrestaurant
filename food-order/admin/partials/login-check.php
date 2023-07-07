<?php
if(!isset($_SESSION['user'])){
$_SESSION['no-login-message']="<div class='error text-center'><h3>Please Login To Access Admin.</h3></div>";
header('location:'.SITEURL.'admin/login.php');
}

?>