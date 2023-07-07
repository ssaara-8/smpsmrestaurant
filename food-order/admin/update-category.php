<?php include('partials/menu.php');?>

<div class ="main-content">
    <div class="wrapper">
    <h1>Update Category</h1>

    <br><br>

<?php 
//check if the id is set or not
if(isset($_GET['id']))
{
//echo $_GET['id'];
$id=$_GET['id'];
//create sql to get others

$sql="SELECT * FROM tbl_category WHERE id=$id";

//execute query
$res=mysqli_query($conn,$sql);

//count rows to check if id is valid or not
$count= mysqli_num_rows($res);

if($count == 1)
{
$row =mysqli_fetch_assoc($res);

$title=$row['title'];
$current_image=$row['image_name'];
$featured=$row['featured'];
$active=$row['active'];
}
else{
    //redirect message
    $_SESSION['no-category-found']="<div class ='error'><h3>Category not Found.</h3><div>";
    header('location:'.SITEURL.'admin/manage-category.php');
}

}
else{
    header('location:'.SITEURL.'admin/manage-category.php');
    echo "no";
}

?>


    <!-- add catagory form-->
<form action="" method="POST" enctype="multipart/form-data">
   <table class="tbl-30">
    <tr>
        <td>Title:</td>
        <td>
            <input type="text" name="title" value="<?php echo $title;?>">
        </td>
    </tr>

    <tr>
        <td>Current Image:</td>
        <td>
             <?php
                 if($current_image != "")
                 {
                    //display img
                    ?>
                    <img src="<?php   echo SITEURL;?>images/category/<?php echo $current_image;?>" width="100px">
                    <?php
                 }
                 else
                 {
                    //display msg
                    echo "<div class ='error'><h3>Image Not Added.</h3><div>";
                 }

             ?>
       </td>

    </tr>

    <tr>
        <td>New Image:</td>
        <td>
             <input type="file" name="image">
       </td>

    </tr>


    <tr>
        <td>Featured:</td>
        <td>
            <input <?php if($featured =="Yes"){echo "checked";}?> type="radio" name="featured" value ="Yes"> Yes

            <input <?php if($featured =="No"){echo "checked";}?> type="radio" name="featured" value ="No"> No
        </td>
    </tr>
  
    <tr>
        <td>Active:</td>
        <td>
            <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes

            <input <?php if($featured =="No"){echo "checked";}?> type="radio" name="active" value="No">No
        </td>
    </tr>

    <tr>
        <td >
            <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <input type="submit" name="submit" value="Update Category" class="btn-secondary">
        </td>
    </tr>

   </table>


</form>

<?php 
   
   if(isset($_POST['submit']))
   {
    //echo "clicked";
    // get value from form
    $id=$_POST['id'];
    $title=mysqli_real_escape_string($conn,$_POST['title']);
    $current_image=$_POST['current_image'];
    $featured=$_POST['featured'];
    $active=$_POST['active'];

    //update new img if selected
    //check if img selected or not
    if(isset($_FILES['image']['name']))
    {
       //get img detail
       $image_name=$_FILES['image']['name'];

       //check if img availble
       if($image_name != "")
       {
        //IMG AVAILBLE
        //UPLOAD NEW IMG
         //auto rename our image
     //get extenstion of our image
     $e=explode('.',$image_name);
     $ext = end($e);

     //rename image
     $image_name="Food_Category_".rand(000,999).'.'.$ext;
     
     

    $source_path = $_FILES['image']['tmp_name'];
    
    $destination_path="../images/category/".$image_name;
    
    //upload
    $upload= move_uploaded_file($source_path,$destination_path);

    //check if image uploaded or not
    if($upload==false)
    {
        $_SESSION['upload']="<div class='error'><h3 >Failed To Upload Image</h3></div>";
        //redirect page
        header("location:".SITEURL.'admin/manage-category.php');
        //stop process
        die();
    }


        //REMOVE CURRENT IMG if availble
        if($current_image != "")
        {
        $remove_path="../images/category/".$current_image;
        $remove = unlink($remove_path);

        //check if img is remove or not 
        //if failed to remove display msg and stop
        if($remove==false)
        {
            $_SESSION['failed_remove']="<div class='error'><h3 >Failed To Remove Image</h3></div>";  
            header("location:".SITEURL.'admin/manage-category.php');
            die();
        }
    }

       }
       else{
        $image_name=$current_image;
    }
    }
    else{
        $image_name=$current_image;
    }


    //update db
    $sql2 = "UPDATE tbl_category SET
    title='$title',
    image_name='$image_name',
    featured='$featured',
    active='$active'
    WHERE id=$id
    ";
     

     //execute query
    $res2= mysqli_query($conn,$sql2);

    //redirect manage cg with msg
    //check query execute or not
    if($res2==true)
    {
        //updated
        $_SESSION['update']="<div class ='success'><h3>Category Updated Successfuly.</h3><div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else{
        //failed to update
        $_SESSION['update']="<div class ='error'><h3>Failed To Update Category.</h3><div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }

   }

?>


    </div>
</div>


<?php include('partials/footer.php');?>