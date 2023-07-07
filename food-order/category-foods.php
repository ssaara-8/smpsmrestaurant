<?php include('partials-front/menu.php');?>

<?php
//check if id passed or not 
if(isset($_GET['category_id']))
{
  //is set
  $category_id=$_GET['category_id'];

  //get category tite based on category id
  $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

  //execute
  $res=mysqli_query($conn,$sql);
  //get value
  $row=mysqli_fetch_assoc($res);
  //get title
  $category_title=$row['title'];

}
else
{
  //not pased
  //redirect home page
  header('location:'.SITEURL);
}



?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
      <div class="container">
        <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title;?>"</a></h2>
      </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
      <div class="container">
        <h2 class="text-center">Food Menu</h2>
        <?php
        //sql get food
        $sql2="SELECT * FROM tbl_food WHERE category_id=$category_id";

        //execute
        $res2=mysqli_query($conn,$sql2);

        //count rows
        $count2 = mysqli_num_rows($res2);
        
        //check 
        if($count2>0)
        {
        //food availble
        while($row2=mysqli_fetch_assoc($res2))
        {
          $id=$row2['id'];
          $title=$row2['title'];
          $price=$row2['price'];
          $description=$row2['description'];
          $image_name=$row2['image_name'];
          ?>

        <div class="food-menu-box">
          <div class="food-menu-img">

           <?php
           //check if img available
           if($image_name=="")
           {
            //not
            echo "<div class='error'><h3>Image Not Available</h3></div>";
           }
           else
           {
            //yes
            ?>

            <img
              src="<?php echo SITEURL?>images/food/<?php echo $image_name;?>"
              alt="Chicke Hawain Pizza"
              class="img-responsive img-curve"
              width="120px"
              height="120px"
            />


            <?php
           }
           
           ?>

            
          </div>

          <div class="food-menu-desc">
            <h4><?php echo $title;?></h4>
            <p class="food-price">$<?php echo $price;?></p>
            <p class="food-detail">
              <?php echo $description;?>
            </p>
            <br />

            <a href="<?php echo SITEURL;?>order.php?food_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
          </div>
        </div>


          <?php
        }
        }
        else
        {
          //not availble
          echo "<div class='error'><h3>Food Not Available</h3></div>";
        }
        
        ?>

        

       

        <div class="clearfix"></div>
      </div>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>
