<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

<br><br>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter Your Userame"></td>
                </tr>
            
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter Your Password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary ">
                    </td>
                </tr>

            </table>
 

        </form>

    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php 
//process value from form and save in DB

//check whether button is clicked or no

if(isset($_POST['submit']))
{
    //button clicked
    //echo "//button clicked";

    //get Data
    $full_name=mysqli_real_escape_string($conn,$_POST['full_name']);
    $username=mysqli_real_escape_string($conn,$_POST['username']);
    $password=md5($_POST['password']);

    //SQL Query to sava data in DB
    $sql="INSERT INTO tbl_admin SET
          full_name='$full_name',
          username='$username',
          password='$password'
    
    ";

    //execute query and save data to DB
    
    $res=mysqli_query($conn,$sql) or die(mysqli_error());

    //check data is insert or not and dispay massage
    if($res == TRUE){
        //data insert
        //create session variable to display message
        $_SESSION['add']= "<div class='success'><h3 >Admin Added Successfully</h3></div>";
        //redirect page
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else{
        //failed
        //create session variable to display message
        $_SESSION['add']= "<div class='error'><h3 >Failed To Add Admin</h3></div>";
        //redirect page
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    
}


?>