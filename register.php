<?php include('inc/header.php') ?>
<?php include('inc/config.php') ?>
<?php
$error = '';
$success = '';
if(isset($_REQUEST['submit'])){
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $pwd = $_REQUEST['pwd'];
    $dateAdded = date('Y-m-d');
  $token = md5($name);
    if(!empty($name) && !empty($email) && !empty($pwd)){


$sql_check = "SELECT * FROM register where email = '$email'";
$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
 $error = 'Email Already Taken! try with different email';
}else{
             $sql = "INSERT INTO register (name, email, password, date_added, token) VALUES ('$name', '$email', '$pwd', '$dateAdded', '$token')"; 
            if (mysqli_query($conn, $sql)) {
                $success  =  "New Member created successfully";
            } else {
                $success  =  "Error: " . $sql . "<br>" . mysqli_error($conn);
            }



            
$to = "$email";
$subject = "Verification Email";
$txt = "Click here to verify Email ";
$txt .= "<a href='http://localhost/social_network/activate.php?token=".$token."'>Click Here</a>";
$headers = "MIME-Version: 1.0" . "\n";
$headers .= "Content-Type: text/html; charset=UTF-8" . "\n";
$headers = "From: test@gmail.com";

mail($to,$subject,$txt,$headers);

$name = '';
$email = '';
$pwd = '';



        }
    }else{
        $error = 'All fields are compulsory';
    }

}


?>




<div class="mt-5">
<h1 class="text-center">Register Yourself</h1>

<?php echo $error; ?>
<?php echo $success; ?>

<form action="register.php" method='post'>
<div class="form-group">
    <label for="email">Name:</label>
    <input type="text" class="form-control" placeholder="Enter email" name="name" value='<?php echo (isset($name)) ? $name: ''  ?>'>
  </div>
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