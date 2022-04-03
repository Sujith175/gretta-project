<?php include('inc/header.php'); ?>
<?php include('inc/config.php'); 
?>




<?php
echo $_SESSION['member_id'];
echo  $_SESSION['member_email'];
?>

<a href="logout.php">Logout</a>

<?php include('inc/footer.php') ?>