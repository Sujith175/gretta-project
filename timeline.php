<?php include('inc/header.php'); ?>
<?php include('inc/config.php'); 



$id =  $_REQUEST['id']; 

$sql_register = "SELECT * FROM register where id = '$id'";
$result_register = mysqli_query($conn, $sql_register);  

$row_register = mysqli_fetch_assoc($result_register); 

$name =  $row_register['name'];
$email =  $row_register['email'];


$sql_profile = "SELECT * FROM profile where user_id = '$id'";
$result_profile = mysqli_query($conn, $sql_profile);  

    $row_profile = mysqli_fetch_assoc($result_profile); 
  $about =  $row_profile['about'];
  $gender =   $row_profile['gender'];
  $dob =   $row_profile['dob'];
  $education1 =   $row_profile['education1'];
  $profile_pic =   $row_profile['profile_pic']; 

?>
<div class="row">
<div class="col-4">
<div class="row mt-5">
<div class="col-12 text-center pb-3">
<img src="images/<?php echo $profile_pic; ?>" alt="" height=200 width=200>
</div>
 
<div class="col-6">
Name:
</div>
<div class="col-6">
<?php echo $name; ?>
</div>
<div class="col-6">
about:
</div>
<div class="col-6">
<?php echo $about; ?>
</div>
<div class="col-6">
gender:
</div>
<div class="col-6">
<?php echo $gender; ?>

</div>
<div class="col-6">
Dob:
</div>
<div class="col-6">
<?php echo $dob; ?>

</div>
<div class="col-6">
education1:
</div>
<div class="col-6">
<?php echo $education1; ?>

</div>
<div class="col-12 pt-2">
<?php
   $sendFrom= $_SESSION["member_id"]; 
$sql_CheckReq = "SELECT * FROM requests where sendingfrom = '$sendFrom' and sendingto = '$id' and accepted='0'";

$result_CheckReq = mysqli_query($conn, $sql_CheckReq);   
if (mysqli_num_rows($result_CheckReq) > 0) {
  echo "Request Already Sent";
}else{
  if(  $sendFrom == $id){

  }else{

  ?>

<button class='btn btn-primary' id='sendReq' onclick='sendAction(1,"<?php echo $id ?>")'>Send Friend Request</button>

<?php
}
} 
?>



</div>
</div>

</div>
<div class="col-8">

</div>
</div>
 
<script>
function sendAction(constant,id){
   $.post(`handler/action.php?action=sendReq&id=${id}`,function(res){
      
       if(res=='Request send, saved into DB'){
$('#sendReq').hide()
$('#sendReq').parent().html('Request Send Successfully')
       }
   })
}
</script>
 

<?php include('inc/footer.php') ?>