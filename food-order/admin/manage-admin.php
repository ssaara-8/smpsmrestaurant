
<?php include('partials/menu.php');?>

    <!-- main content section start -->
    <div class="main-content">
     <diV class="wrapper ">
        <h1>Manage Admin </h1> <br/>
 
        <br>
           <?php 
           if(isset($_SESSION['add']))
           {
               echo $_SESSION['add'];
               unset($_SESSION['add']);
            }

            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if(isset($_SESSION['user-not-found'])){
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
            }
            if(isset($_SESSION['pwd-not-match'])){
                echo $_SESSION['pwd-not-match'];
                unset($_SESSION['pwd-not-match']);
            }
            if(isset($_SESSION['cange-pwd'])){
                echo $_SESSION['cange-pwd'];
                unset($_SESSION['cange-pwd']);
            }

            ?>
          <br><br><br>

        <!-- Button to add admin -->
        <a href="add-admin.php" class ="btn-primary">Add Admin </a>
         <br/>
    
       <br/><br/>
        <table class=" tbl-full" >
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>



            <?php
            //query to get all admin
            $sql ="SELECT * FROM tbl_admin";
            //execute the query
            $res=mysqli_query($conn,$sql);

            //chechk if query is execute or not

            if($res==TRUE)
            {
                //count rows to check if we have data on DB or not
                $count= mysqli_num_rows($res);
                //fun to get rows


                $sn=1;
                //check

                if($count>0){
                 //we have data in DB
                 while($rows = mysqli_fetch_assoc($res)){
                    //get all data from DB
                    $id=$rows['id'];
                    $full_name =$rows['full_name'];
                    $username = $rows['username'];
                     
                    //Display values in our table
                    ?>


             <tr>
              <td><?php echo $sn++;?></td>
              <td><?php echo $full_name;?></td>
              <td><?php echo $username;?></td>
              <td>
                <a href="<?php echo SITEURL ;?>admin/update-password.php?id=<?php echo $id ;?>"class="btn-primary">Change Password</a>
                <a href="<?php echo SITEURL ;?>admin/update-admin.php?id=<?php echo $id ;?>" class="btn-secondary">Update Admin</a>
                <a href="<?php echo SITEURL ;?>admin/delete-admin.php?id=<?php echo $id ;?>" class="btn-danger">Delete Admin</a>
              </td>
           </tr>
 

                    <?php
                 }

                }

                else{

                }
            }
            ?>


           

        </table>   


     </diV>
    </div>
    <!-- menu content end -->

    <?php include('partials/footer.php');?>