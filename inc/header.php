<?php 
session_start();
?>

<!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

 </head>
 <body>

 <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#">social</a>

  <!-- Links -->
  <ul class="navbar-nav ml-auto">
<?php 

if(isset($_SESSION['member_id'])){

?>


    <li class="nav-item">
      <a class="nav-link" href="#">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="timeline.php?id=<?php echo $_SESSION['member_id'] ?>">Timeline</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="profile.php">Profile</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Message</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="notification.php">Notification</a>
    </li>
      <li class="nav-item">
      <a class="nav-link" href="logout.php">Logout</a>
    </li>

    <?php } else {?>

        <li class="nav-item">
      <a class="nav-link" href="register.php">Register</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="login.php">Login</a>
    </li>
        <?php }  ?>


    <!-- Dropdown -->
    <!-- <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Dropdown link
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Link 1</a>
        <a class="dropdown-item" href="#">Link 2</a>
        <a class="dropdown-item" href="#">Link 3</a>
      </div>
    </li> -->
  </ul>
</nav>

 <div class="container">
 