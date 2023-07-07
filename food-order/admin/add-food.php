<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>
        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

               <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" placeholder="Title Of The Food">
                        </td>
                    </tr>

                    <tr>
                        <td>Description:</td>
                        <td>
                            <textarea name="description"  cols="30" rows="5" placeholder="Description Of The Fod"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price:</td>
                        <td>
                            <input type="number" name="price" >
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image:</td>
                        <td>
                            <input type="file" name="image" >
                        </td>
                    </tr>

                    <tr>
                        <td>Category:</td>
                        <td>
                            <select name="category" >

                                 <?php 
                                 //create to display cg in db

                                 //1.create sql to get all
                                   $sql="SELECT * FROM tbl_category WHERE active ='Yes'";
                                   
                                   //execute query
                                   $res= mysqli_query($conn,$sql);

                                   //count rows to check if we have cg or not
                                   $count= mysqli_num_rows($res);

                                   if($count>0)
                                   {
                                    //we have cg
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                     //get details
                                     $id=$row['id'];
                                     $title=$row['title'];
                                     

                                     ?>
                                        <option value="<?php echo $id;?>"> <?php echo $title;?></option>

                                     <?php

                                    }
                                   }
                                   else
                                   {
                                    //we dont have cg
                                    ?>
                                     <option value="0">No Category Found</option>
                                    
                                    <?php
                                   }
                                 //2.display on 
                                 ?>
                               
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="Yes">Yes
                            <input type="radio" name="featured" value="No">No
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
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                        </td>
                    </tr>
               </table>



        </form>

        <?php
        
         //check if btn cliked or not
         if(isset($_POST['submit']))
         {
            
            //add food in db
            //1.get data from form 
            $title=mysqli_real_escape_string($conn,$_POST['title']);
            $description=mysqli_real_escape_string($conn,$_POST['description']);
            $price=mysqli_real_escape_string($conn,$_POST['price']);
            $category=$_POST['category'];
            $image_name=$_FILES['image_name'];

            //if radio btn cliced or not
            if(isset($_POST['featured'])){
                $featured=$_POST['featured'];
                
            }
            else{
                $featured="No";
            }

            if(isset($_POST['active'])){
                $active=$_POST['active'];
            }
            else{
                $active="No";
            }


            //2.upload img if selected

            //check select img is clicked or not upload if img selected
            if(isset($_FILES['image']['name']))
            {
               
               //get details
               $image_name=$_FILES['image']['name'];

               if($image_name != "")
               {
                
                //rename img 
                $e=explode('.',$image_name);
                $ext=end($e);

                //create new name for img
                $image_name="Food_Name_".rand(000,999).".".$ext;

                //upload img
                //get src path
                $src=$_FILES['image']['tmp_name'];
                $dst="../images/food/".$image_name;

                //upload food img
                $upload=move_uploaded_file($src,$dst);

                //check if img upload or not
                if($upload==false)
                {
                    //error msg
                    $_SESSION['upload']="<div class='error'><h3>Failed To Upload Image.</h3></div>";
                    header('location:'.SITEURL.'admin/add-food.php');
                    //stop
                    die();
                }
               }
               
            }
            else
               {
                   $image_name="";
               }
            //3.insert into db

            $sql2 = " INSERT INTO tbl_food SET
            title='$title',
            description ='$description',
            
            price='$price' ,
            image_name='$image_name',
            category_id=$category,
            featured='$featured',
            active='$active'

            ";

            //execute query

            $res2= mysqli_query($conn,$sql2);

            //check
            //4.redirect with msg to mnge fod pg
            if($res2 == true)
            {
             //data insert sucessfuly
             $_SESSION['add']="<div class='success'><h3>Food Aded Successfuly.</h3></div>";
             header('location:'.SITEURL.'admin/manage-food.php');
            }
            else
            {
             //failed to insert
             $_SESSION['add']="<div class='error'><h3>Failed To Add Food.</h3></div>";
             header('location:'.SITEURL.'admin/manage-food.php');
            }
            
         }     
        ?>


    </div>
</div>

<?php include('partials/footer.php'); ?>