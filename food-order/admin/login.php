<?php include('../config/constants.php')?>


<html>
<head>
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css"></link>
</head>
<body>
    <br><br><br><br>
    <div class="login">
        <h1 class="text-center ">Login</h1><br><br>

        <?php 
        if(isset($_SESSION['login'])){
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if(isset($_SESSION['no-login-message'])){
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <br><br>
          <!-- ligin form stats here-->
          <form action="" method="POST" class="text-center">
           <h4> Username</h4>  <br>
            <input type="text" name="username" placeholder="Enter Username">
            <br><br>
            <h4>Password</h4> <br>
            <input type="password" name="password" placeholder="Enter Password">
            <br>
            <br>

            <input type="submit" name="submit" value="login" class="btn-primary">
          </form>
          <br><br><br>
        <p class="text-center">Created by - <a href="#">SMPSM</a></p>
    </div>
    
</body>
</html>

<?php

//check submit clicked or not
if(isset($_POST['submit'])){
    //1.get data from login form
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5($_POST['password']);

    //2.sqlcheck username and psw exist or not
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    
    //3.execuet query
    $res= mysqli_query($conn,$sql);

    //4 count rows exist or not
    $count = mysqli_num_rows($res);

    if($count){
         //user not available
         $_SESSION['login'] = "<div class='success'><h3>Login Successfully.</h3></div>";
         $_SESSION['user']=$username;

         header('location:'.SITEURL.'admin/');
    }
    else{
        //user not availble
        $_SESSION['login'] = "<div class='error text-center'><h3>login Failed.</h3></div>";
        header('location:'.SITEURL.'admin/login.php');
    }

}


?>