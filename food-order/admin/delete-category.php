<?php

include('../config/constants.php');


//echo "delet";
//check id and image name are sent or not
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
//get value and delete
//echo "get value ";
$id=$_GET['id'];
$image_name=$_GET['image_name'];

//remove physical image file is availble
if($image_name != "")
{
    //its availble remove it
    $path="../images/category/".$image_name;
    //remove
    $remove=unlink($path);

    //if failed to remove img error and stop process
    if($remove == false)
    {
      //set the session massage 
      $_SESSION['remove'] ="<div class='error'><h3>Failed To Delete Category Image.</h3></div>";
      //redirect
      header('location:'.SITEURL.'admin/manage-category.php');
      //stop
      die();
    }
}

//delete from db 
$sql="DELETE FROM tbl_category WHERE id=$id ";

//execute query
$res = mysqli_query($conn,$sql);

//check if data delete from db or not
if($res==true)
{
    //set success message and redirect
    $_SESSION['delete']="<div class='success'><h3 >Category Deleted Successfully.</h3></div>";
    //redirect to manage ct
    header('location:'.SITEURL.'admin/manage-category.php');
     
}
else{
    
     //set success message and redirect
     $_SESSION['delete']="<div class='error'><h3 >Failed to Delete Category .</h3></div>";
     //redirect to manage ct
     header('location:'.SITEURL.'admin/manage-category.php');

}

//redirect to mange category with message

}
else
{
//redirect to manage category page
header('location:'.SITEURL.'admin/manage-category.php');
}
?>