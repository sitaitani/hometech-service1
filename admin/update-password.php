<?php include('partials/menu.php'); ?>

<div class="main-content">
  <div class= "wrapper">
  <h1>Change Password </h1>
  <br><br>

  <?php
        if(isset($_GET['id']))
        {
          $id=$_GET['id'];
        }
        ?>

  <form action="" method="POST">
    <table class="tbl-30">
      <tr>
        <td>Current Password:</td>
        <td>
          <input type="password" name="current_password" placeholder="Current Password">
        </td>
      </tr>
      <tr>
        <td>New Password:</td>
        <td>
          <input type="password" name="new_password" placeholder="New Password">
        </td>
      </tr>
      
      <tr>
        <td>Confirm Password:</td>
        <td>
          <input type="password" name="confirm_password" placeholder="Confirm Password">
        </td>
      </tr>
      <tr>
      <td colspan="2">
      <input type="hidden" name="id" value="<?php echo $id; ?>">


      <input type="submit" name="submit" value="Change password" class="btn-secondary" >
      
      </td>
      
      </tr>

    </table>
  
  
  
  </form>

</div>

<?php
//check whether the submit button is clicked on not
if(isset($_POST['submit']))
{
  //echo "Button Clicked";
  //get the data from form
  $id=$_POST['id'];
  
  $current_password = md5($_POST['current_password']);
  $new_password = md5($_POST['new_password']);
  $confirm_password = md5($_POST['confirm_password']);
  //check wheather the user with current password exits or not
  $sql ="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
  //execute the query
  $res = mysqli_query($conn, $sql);

  if($res==TRUE)
  {
    //check wether data is available or not
    $count=mysqli_num_rows($res);
    if($count==1)
    {
      //user Exists and password can be changed
      //echo"user found";

      //check whether the new password and confirm password match or not
      if($new_password==$confirm_password)
      {
        //update the password
        //echo "password match";
        $sql2= "UPDATE tbl_admin SET
          password='$new_password'
          WHERE id=$id

        
         ";
         //execute te query
         $res2 = mysqli_query($conn, $sql2);
         //check whether the query executed
         if($res2==true)
         {
           //Display success message
           $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully.</div>";
           //redirect te user
           header("location:".SITEURL.'/admin/manage-admin.php');
         }
         else{
           //display error message
           $_SESSION['change-pwd'] = "<div class='error'>Failed to Chage password.</div>";
           //redirect te user
           header("location:".SITEURL.'/admin/manage-admin.php');
           
         }

      }
      else{
        //Redric to manage admin page with error message
        $_SESSION['pwd-not-match'] = "<div class='error'>password did not match.</div>";
        //redirect te user
        header("location:".SITEURL.'/admin/manage-admin.php');
      }
    }
    else
    {
        //user does not Exists set message and 
        $_SESSION['user-not-found'] = "<div class='error'>user not found.</div>";
        //redirect te user
        header("location:".SITEURL.'/admin/manage-admin.php');
    }
  }
  //check wheather  the new password and confirm password match or not
  //change password if all is true

}
?>


<?php include('partials/footer.php'); ?>