<?php include('inc/header.php'); ?>
<?php include('inc/config.php'); 
?>




<div class="row">
<div class="col-4">

</div>
<div class="col-8">
<?php
  $id = $_SESSION['member_id']; 
  $sql_Noti = "SELECT * FROM notifications where noti_To = '$id'";


  $result_noti = mysqli_query($conn, $sql_Noti);   
   

  


  while($row_noti = mysqli_fetch_assoc($result_noti)) {
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


 
?>
 
</div>
</div>

<script>
function reqAction(type,sentRequest){
$.post(`handler/action.php?action=RequestSection&sentRequest=${sentRequest}&type=${type}`,function(res){
    alert(res)
})
}
</script>

<?php include('inc/footer.php') ?>