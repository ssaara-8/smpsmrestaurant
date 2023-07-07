<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
      <h1>Update Admin</h1>
      <br><br>

      <?php 
      //get id of selected admin
      $id =$_GET['id'];
      //create sql query to get detail
      $sql="SELECT * from tbl_admin WHERE id=$id";

      //execute query
      $res=mysqli_query($conn,$sql);
      
      //check if wquery execute or not
      if($res==true){
        $count =mysqli_num_rows($res);
        if($count ==1){
        // echo"Admin Available";
        $row =mysqli_fetch_assoc($res);
        $full_name=$row['full_name'];
        $username=$row['username'];
        }
        else{
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
      }
      ?>
      <form action="" method="POST">

      <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name;?>"></td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" value="<?php echo $username;?>"></td>
                </tr>
            
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id"value="<?php echo $id;?>" >
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary ">
                    </td>
                </tr>

            </table>

      </form>
    </div>
</div>

<?php 

 //check if submit btn clicked or not
 if(isset($_POST['submit'])){
   //echo"btn clicek";
    //Get all the value from form to update

     $id =$_POST['id'];
     $full_name=mysqli_real_escape_string($conn,$_POST['full_name']);
     $username=mysqli_real_escape_string($conn, $_POST['username']);

     //create sql to update admin
   
     $sql="UPDATE tbl_admin SET
     full_name ='$full_name',
     username ='$username' 
      WHERE id ='$id' ";

    //execute query
    $res=mysqli_query($conn,$sql);

    //check
    if($res==true){
        $_SESSION['update'] = "<div class='success'><h3>Admin Update Successfully.</h3></div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
        else{
            $_SESSION['update']="<div class='error'><h3>Failed To Update Admin.</h3></div>";

            header('location:'.SITEURL.'admin/manage-admin.php');
        }
      

 }


?>
<?php include('partials/footer.php');?>