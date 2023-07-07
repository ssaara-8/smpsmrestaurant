<?php include('partials-front/menu.php');?>

<?php
  //check if food id is set
  if(isset($_GET['food_id']))
  {
    //get details
    $food_id=$_GET['food_id'];

    //get details of selected food
    $sql="SELECT * FROM tbl_food WHERE id=$food_id";
    //execute
    $res=mysqli_query($conn,$sql);
    //count
    $count=mysqli_num_rows($res);

    //check
    if($count==1)
    {
      //we have data
      //get data 
      $row=mysqli_fetch_assoc($res);
      $title=$row['title'];
      $price=$row['price'];
      $image_name=$row['image_name'];

    }
    else
    {
      //redirect
      header('location'.SITEURL);
    }
  }
  else
  {
    //redirect to home page
    header('location'.SITEURL);
  }

?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="smpsm-order">
      <div class="container">
        <h2 class="text-center text-white">
          Fill this form to confirm your order.
        </h2>

        <form action="" method="POST" class="order">
          <fieldset>
            <legend>Selected Food</legend>

            <div class="food-menu-img">
              <?php
              //check if img is availble or not
              if($image_name==""){
                //not
                echo "<div class='error'><h3>Image Not Available</h3></div>";
              }
              else
              {
                //yes
                ?>
                 <img
                src="<?php echo SITEURL?>images/food/<?php echo $image_name;?>"
                alt="Photo"
                class="img-responsive img-curve"
                width="100px"
                height="100px"
              />

                <?php
              }
              
              ?>
             
            </div>

            <div class="food-menu-desc">
              <h3><?php echo $title;?></h3>

              <input type="hidden" name="food" value="<?php echo $title;?>">

              <p class="food-price">$<?php echo $price;?></p>

              <input type="hidden" name="price" value="<?php echo $price;?>">

              <div class="order-label">Quantity</div>
              <input
                type="number"
                name="qty"
                class="input-responsive"
                value="1"
                required
              />
            </div>
          </fieldset>

          <fieldset>
            <legend>Delivery Details</legend>
            <div class="order-label">Full Name</div>
            <input
              type="text"
              name="full-name"
              placeholder="E.g. SMPSM"
              class="input-responsive"
              required
            />

            <div class="order-label">Phone Number</div>
            <input
              type="tel"
              name="contact"
              placeholder="E.g. 914xxxxxxxx"
              class="input-responsive"
              required
            />

            <div class="order-label">Email</div>
            <input
              type="email"
              name="email"
              placeholder="E.g. smpsmgroup@gmail.com"
              class="input-responsive"
              required
            />

            <div class="order-label">Address</div>
            <textarea
              name="address"
              rows="10"
              placeholder="E.g. Street, City, Country"
              class="input-responsive"
              required
            ></textarea>

            <input
              type="submit"
              name="submit"
              value="Confirm Order"
              class="btn btn-primary"
            />
          </fieldset>
        </form>

        <?php
        //check if  submit btn clicked or not
        if(isset($_POST['submit']))
        {
          //get all details from form
          $food=$_POST['food'];
          $price=$_POST['price'];
          $qty=$_POST['qty'];
          $total= $price * $qty;
          $order_date=date("Y-m-d h:i:sa");
          $status="Ordered";
          $customer_name=mysqli_real_escape_string($conn,$_POST['full-name']);
          $customer_contact=mysqli_real_escape_string($conn,$_POST['contact']);
          $customer_email=mysqli_real_escape_string($conn,$_POST['email']);
          $customer_address=mysqli_real_escape_string($conn,$_POST['address']);


          //save in db
          $sql2="INSERT INTO tbl_order SET
          food='$food',
          price='$price',
          qty=$qty,
          total='$total',
          order_date='$order_date',
          status='$status',
          customer_name='$customer_name',
          customer_contact='$customer_contact',
          customer_email='$customer_email',
          customer_address='$customer_address'
          

          
          ";

          //execute
          $res2=mysqli_query($conn,$sql2);

          //check
          if($res2==true)
          {
            //order saved
            $_SESSION['order']="<div class='success text-center' ><h3>Food Orderd Successfuly.</h3></div>";
            header('location:'.SITEURL);
          }
          else
          {
            //failrd to save
            $_SESSION['order']="<div class='error text-center'><h3>Failed To Order Food.</h3></div>";
            header('location:'.SITEURL);
          }
        }
        
        ?>

 


      </div>
    </section>

    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php');?>