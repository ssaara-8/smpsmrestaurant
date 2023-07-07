<?php 
//include constant.php here
include('../config/constants.php');
// get the id of admin to be deleted
 $id = $_GET['id'];


//create sql query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

// execute query
$res = mysqli_query($conn,$sql);

//check if query excute or not
if($res == true){

//admin deleted
 //echo"Admin Deleted";
//ccreate varaible to dispaly massage
$_SESSION['delete']="<div class='success'><h3 >Admin Deleted Successfully.</h3></div>";
header('location:'.SITEURL.'admin/manage-admin.php');
}
else{
    //failed to delete admin
    //echo "Failed To Delete Admin";
    //ccreate varaible to dispaly massage
$_SESSION['delete']="<div class='error'><h3>Failed To Delete Admin.</h3></div>";
header('location:'.SITEURL.'admin/manage-admin.php');
}
    //redirect to manage admin page with (sucsees or error)


?>