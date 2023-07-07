<?php include('partials/menu.php'); ?>

<div class ="main-content">
    <div class="wrapper">
    <h1>Add Category</h1>

    <br><br>

    <?php 
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);   
             }

      if(isset($_SESSION['upload']))
       {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);       
             }
    ?>
<br><br>

    <!-- add catagory form-->
  <form action="" method="POST" enctype="multipart/form-data">
   <table class="tbl-30">
    <tr>
        <td>Title:</td>
        <td>
            <input type="text" name="title" placeholder="Category Title">
        </td>
    </tr>


    <tr>
<td>Select Image:</td>
<td>
    <input type="file" name="image">
</td>

    </tr>


    <tr>
        <td>Featured:</td>
        <td>
            <input type="radio" name="featured" value ="Yes"> Yes
            <input type="radio" name="featured" value ="No"> No
        </td>
    </tr>
  
    <tr>
        <td>Active:</td>
        <td>
            <input type="radio" name="active" value="Yes">Yes
            <input type="radio" name="active" value="No">No
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
        </td>
    </tr>

   </table>


  </form>


<!-- #region -->

<?php
//check if submit cliked or not
  if(isset($_POST['submit']))
  {
    //get value from form
    $title= mysqli_real_escape_string($conn,$_POST['title']);
    
    //for radio input type check cliced or not
    if(isset($_POST['featured']))
    {
        $featured= $_POST['featured'];
        //get value 
    }
    else{
        //set defult value
        $featured="No";
    }

    if(isset($_POST['active']))
    {
        $active= $_POST['active'];
        //get value 
    }
    else{
        //set defult value
        $active="No";
    }


    //check if image select ot not
   if(isset($_FILES['image']['name'])){
    //upload image
    $image_name = $_FILES['image']['name'];

//upload image only if iamge is selected
if($image_name != "")
{

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
        header("location:".SITEURL.'admin/add-category.php');
        //stop process
        die();
    }
}
   }
   else{
    //dont upload
    $image_name="";
   }

    // create sql to insert category 
    $sql = "INSERT INTO tbl_category SET
    title='$title',
    image_name='$image_name',
    featured='$featured',
    active='$active'
    ";

    //execute query and save in db
    $res= mysqli_query($conn,$sql) ;

    //check query execute or not
    if($res==true)
    {
        //added
        $_SESSION['add']= "<div class='success'><h3 >Category Added Successfully</h3></div>";
        //redirect page
        header("location:".SITEURL.'admin/manage-category.php');
    }
    else{
        //failed

     $_SESSION['add']= "<div class='error'><h3 >Failed To Add Category</h3></div>";
        //redirect page
        header("location:".SITEURL.'admin/add-category.php');
    }

  }
  
  ?>

    </div>
</div>



<?php include('partials/footer.php'); ?>