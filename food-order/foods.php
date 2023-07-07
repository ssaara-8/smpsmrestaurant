<?php include('partials-front/menu.php');?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
      <div class="container">

        <form action="<?php echo SITEURL;?>food-search.php" method="POST">
          <input
            type="search"
            name="search"
            placeholder="Search for Food.."
            required
          />
          <input
            type="submit"
            name="submit"
            value="Search"
            class="btn btn-primary"
          />
        </form>
      </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
      <div class="container">
        <h2 class="text-center">Foods Menu</h2>


        <?php
        //display food active
        $sql="SELECT * FROM tbl_food WHERE active='Yes' ";
        //execute
        $res=mysqli_query($conn,$sql);

        //count
        $count=mysqli_num_rows($res);

        //check if food av or not
        if($count>0)
        {
          //foods available
          while($row=mysqli_fetch_assoc($res))
          {
            //get value 
            $id=$row['id'];
            $title=$row['title'];
            $description=$row['description'];
            $price=$row['price'];
            $image_name=$row['image_name'];
            ?>

     <div class="food-menu-box">
          <div class="food-menu-img">

          <?php
          //check if img availble
          if($image_name=="")
          {
            //image not availble
            echo "<div class='error'><h3>Image Not Available.</h3></div>";
          }
          else
          {
            //image availble
            ?>
             <img
              src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>"
              alt="Photo"
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
          //not
          echo "<div class='error'><h3>Food Not Found.</h3></div>";
        }
        
        ?>


       

        

        <div class="clearfix"></div>
      </div>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>