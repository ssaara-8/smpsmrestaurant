<?php include('partials/menu.php');?>

<?php
//check if id is set or not
if(isset($_GET['id']))
{
    //get all details
    $id=$_GET['id'];

    //sql query to get food
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

    //execute
    $res2=mysqli_query($conn,$sql2);

    //get value
    $row2 = mysqli_fetch_assoc($res2);

    //get indivitual value
    $title=$row2['title'];
    $description=$row2['description'];
    $price=$row2['price'];
    $current_image=$row2['image_name'];
    $current_category=$row2['category_id'];
    $featured=$row2['featured'];
    $active=$row2['active'];

}
else
{
    //redirect mg food
    header('location:'.SITEURL.'admin/manage-food.php');
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food </h1>
    <br><br>

    <form action="" method="POST" enctype="multipart/form-data">
        
    <table class="tbl-30">
 
    <tr>
        <td>Title:</td>
        <td>
            <input type="text" name="title" value="<?php echo  $title;?>" >
        </td>
    </tr>

    <tr>
        <td>Description:</td>
        <td>
        <textarea name="description"  cols="30" rows="5" ><?php echo  $description;?></textarea>
        </td>
    </tr>

    <tr>
        <td>Price:</td>
        <td>
            <input type="number" name="price" value="<?php echo  $price;?>">
        </td>
    </tr>

    <tr>
        <td>Current Image:</td>
        <td>
            <?php
            //check if img availble 
            if($current_image == "")
            {
                //not available
                echo "<div class ='error'><h3>Image Not Available.</h3><div>";
            }
            else
            {
                //img availble
                ?>
                <img src="<?php echo SITEURL;?>images/food/<?php echo $current_image;?>" width="100px" >
                <?php
            }
            
            ?>
        </td>
    </tr>
   
    <tr>
        <td>Select New Image:</td>
        <td>
            <input type="file" name="image" >
        </td>
    </tr>
    <tr>
        <td>Category:</td>
        <td>
            <select name="category" >
                <?php
                //query to create active cg
                   $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                   //execute query
                   $res=mysqli_query($conn,$sql);
                   //count rows
                   $count=mysqli_num_rows($res);

                   //if cg availble or not
                   if($count>0)
                   {
                    //availble
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $category_title = $row['title'];
                        $category_id = $row['id'];

                        //echo "<option value='$category_id'>$category_title</option>";
                        ?>

                      <option <?php if($current_category == $category_id){echo "selected";}?> value="<?php echo $category_id;?>"><?php echo $category_title;?></option>

                        <?php

                    }
                   }
                   else{
                    //not available
                    echo "<option value='0'>Category Not Available.</option>";
                   }
                ?>
                
            </select>
        </td>
    </tr>

    <tr>
        <td>Featured:</td>
        <td>
            <input <?php if($featured =="Yes"){echo "checked";}?> type="radio" name="featured" value="Yes">Yes
            <input <?php if($featured =="No"){echo "checked";}?> type="radio" name="featured" value="No">No

        </td>
    </tr>

    <tr>
        <td>Active:</td>
        <td>
            <input <?php if($active == "Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes
            <input <?php if($featured =="No"){echo "checked";}?>  type="radio" name="active" value="No">No

        </td>
    </tr>

    <tr>
        <td>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
            <input type="submit" name="submit" value="Update Food" class="btn-secondary">
        </td>
    </tr>

    </table>

    </form>

    <?php
    
    if(isset($_POST['submit'])){
       
        //1.get all details from form
        $id=$_POST['id'];
        $title=mysqli_real_escape_string($conn,$_POST['title']);
        $description=mysqli_real_escape_string($conn,$_POST['description']);
        $price=mysqli_real_escape_string($conn,$_POST['price']);
        $current_image=$_POST['current_image'];
        $category=$_POST['category'];

        $featured=$_POST['featured'];
        $active=$_POST['active'];

        //2.upload img if selected

        //if upload btn clicked or not 
        if(isset($_FILES['image']['name']))
        {
            //clicek
            $image_name=$_FILES['image']['name'];

            //check if file is availble or not

            if($image_name != "")
            {
                //img available
                //rename img
                $e=explode('.',$image_name);
                $ext=end($e);

                $image_name="Food_Name_".rand(000,999).'.'.$ext;

                //get src and dest path
                $source_path  = $_FILES['image']['tmp_name'];
                $destination_path = "../images/food/".$image_name;

                //upload img
                $upload= move_uploaded_file($source_path,$destination_path);

                   //3. removr img if new img is uploaded
                //check if img is uploaded
                if($upload==false)
                {
                    //failed
                    $_SESSION['upload']="<div class='error'><h3>Failed To Upload New Food Image.</h3></div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                    //stop
                    die();
                }
                //remove current img if available
                if($current_image !="")
                {
                    $remove_path="../images/food/".$current_image;

                    $remove = unlink($remove_path);

                    //chek if img remove or not
                    if($remove==false)
                    {
                        $_SESSION['remove-failed']="<div class='error'><h3>Failed To Remove Current Food Image.</h3></div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        die();
                        //failed to remove
                    }
                }
            }
            else
            {
                $image_name= $current_image;
            }
           
        }
        else
        {
            $image_name= $current_image;
        }
       
        //4.update food in db
        $sql3="UPDATE tbl_food SET
        title='$title',
        description='$description',
        price='$price',
        image_name='$image_name',
        category_id='$category',
        featured='$featured',
        active='$active'
        WHERE id=$id
        ";
        //execute
        $res3=mysqli_query($conn,$sql3);

        //checl
        if($res3==true)
        {
            //updated
            $_SESSION['update']="<div class='success'><h3> Food Updated Successfuly.</h3></div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //failed
            $_SESSION['update']="<div class='error'><h3> Failed to Updated Food.</h3></div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

        //5.redirect to mng fodd with msg
    }
    
    
    ?>

    

    </div>
</div>

<?php include('partials/footer.php');?>