<?php include('inc/header.php'); ?>
<?php include('inc/config.php'); 
?>




<div class="row">
<div class="col-4">
<h3 class='pb-3'>Friends List</h3>
<?php

 $s_id = $_SESSION['member_id'];
  $sql_friendsList_get = "SELECT * FROM friends where user1 = '$s_id' or user2 = '$s_id'";

  $result_friensList_get = mysqli_query($conn, $sql_friendsList_get);   
   
  while($row_friensList_get = mysqli_fetch_assoc($result_friensList_get)) {
 $myFriend = $row_friensList_get['user1'];
// fetch name
$sql_getName = "SELECT * FROM register where id = '$myFriend'";
$result_getName = mysqli_query($conn, $sql_getName);   
 $row_getName = mysqli_fetch_assoc($result_getName); 
//  fetch proflle pic
$sql_ProfilePic = "SELECT * FROM profile where user_id = '$myFriend'";
$result_ProfilePic = mysqli_query($conn, $sql_ProfilePic);   
 $row_ProfilePic = mysqli_fetch_assoc($result_ProfilePic);
// echo $row_ProfilePic['profile_pic'];
// echo $row_getName['name'];

?>

<div class="row">
<div class="col-4">
<img src="images/<?php echo $row_ProfilePic['profile_pic']?>" alt="" height=50 width=50>
</div>
<div class="col-4">
<h6 class='text-uppercase'><?php echo $row_getName['name']; ?></h6>
</div>
</div>

<?php
  }



?>
</div>
<div class="col-8">
<h3 class='pb-3'>Notifications</h3>

<?php
  $id = $_SESSION['member_id']; 
  $sql_Noti = "SELECT * FROM notifications where noti_To = '$id'";


  $result_noti = mysqli_query($conn, $sql_Noti);   
   

  


  while($row_noti = mysqli_fetch_assoc($result_noti)) {
     $noti_From = $row_noti['noti_From'];
     $noti_To = $row_noti['noti_To'];
    $sql_FriendsList = "SELECT * FROM friends where user1 = '$noti_From' and user2 = '$noti_To' or  user1 = '$noti_To' and user2 = '$noti_From'";

      $result_FriendsList = mysqli_query($conn, $sql_FriendsList);   

      if (mysqli_num_rows($result_FriendsList) > 0) {
      
      }else{

      ?>


    <!-- -->
    <div class="card">
    <div class="card-body">
    
<div class="alert alert-success d-flex justify-content-between">
  <strong><?php  echo $row_noti['message']; ?></strong>  
</div>
    </div>
    </div>


<?php
}


 }  


 
?>
 
</div>
</div>

<script>
$('.btnAccept').click(function(){
  type = $(this).attr('data-type');
  reqsendingfrom = $(this).attr('data-reqsendingfrom');
   button= $(this)
$.post(`handler/action.php?action=RequestSection&sentRequest=${reqsendingfrom}&type=${type}`,function(res){
  alert(res)
    if(res == 'success_accepted'){
    console.log(button.parent())
      
    button.parent().parent().text('You accepted the friend request from '+reqsendingfrom)
    } 
})
})

$('.btnReject').click(function(){
  type = $(this).attr('data-type');
  reqsendingfrom = $(this).attr('data-reqsendingfrom');
   button= $(this)
$.post(`handler/action.php?action=RequestSection&sentRequest=${reqsendingfrom}&type=${type}`,function(res){
  alert(res)
    if(res == 'success_Reject'){
    console.log(button.parent())
      
    button.parent().parent().text('You Rejected the friend request from ' + reqsendingfrom)
    } 
})
})



 
</script>

<?php include('inc/footer.php') ?>