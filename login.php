<?php include('inc/header.php') ?>
<?php include('inc/config.php') ?>
<?php 
$error = '';
$success = '';

if(isset($_REQUEST['submit'])){
     $email = $_REQUEST['email'];
    $pwd = $_REQUEST['pwd'];
     if(!empty($email) && !empty($pwd)){


$sql_check = "SELECT * FROM register where email = '$email' and password = '$pwd' and activated='1'";
$result_check = mysqli_query($conn, $sql_check);
 if (mysqli_num_rows($result_check) == 1) {

    $row_check = mysqli_fetch_assoc($result_check);
     
    $_SESSION['member_id'] = $row_check['id'];
    $_SESSION['member_email'] = $row_check['email'];

     header('location:index.php');

}else{
          
    $error = 'Account is not activated or credentials are wrong';  

}

}

}


?>




<div class="mt-5">
<h1 class="text-center">Login </h1>

<?php echo $error; ?>
<?php echo $success; ?>

<form action="login.php" method='post'>
 
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" class="form-control" placeholder="Enter email" name="email" autocomplete='off' value='<?php echo (isset($email)) ? $email: ''  ?>' >
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" placeholder="Enter password" name="pwd" autocomplete='off' value='<?php echo (isset($pwd)) ? $pwd: ''  ?>'>
  </div>
   
  <button type="submit" name='submit' class="btn btn-primary">Submit</button>
</form>

</div>






<?php include('inc/footer.php') ?>