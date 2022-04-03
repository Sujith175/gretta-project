<?php include('../inc/config.php'); 
session_start();




if($_REQUEST['action']==='sendReq'){
     $reqSendingTo  = $_REQUEST['id'];
     $reqSendingFrom = $_SESSION['member_id'];
     $dateAdded_now = date('Y-m-d');

     $sql = "INSERT INTO requests (sendingfrom, sendingto, dateAdded) VALUES ('$reqSendingFrom', '$reqSendingTo', '$dateAdded_now')"; 

     $sql_requestFrom_name = "SELECT name FROM register where id = '$reqSendingFrom'";
     $sql_requestTo_name = "SELECT name FROM register where id = '$reqSendingTo'";

     $result_FROM = mysqli_query($conn, $sql_requestFrom_name);   
     $result_TO = mysqli_query($conn, $sql_requestTo_name);   

     $row_name_from = mysqli_fetch_assoc($result_FROM);
     $row_name_TO = mysqli_fetch_assoc($result_TO);

        $message =  
        $row_name_from['name'].' Sent You Request 
        <button class="btn btn-primary btnAccept" data-type="1" data-reqSendingFrom="'.$reqSendingFrom.'">Accept</button> 
        <button class="btn btn-success btnReject" data-type="2" data-reqSendingFrom="'.$reqSendingFrom.'">Reject</button>';




     $sql_notification = "INSERT INTO notifications (noti_From, noti_To, message, is_read, date_added) VALUES ('$reqSendingFrom', '$reqSendingTo', '$message', '0', '$dateAdded_now')"; 

      
      if (mysqli_query($conn, $sql_notification) && mysqli_query($conn, $sql)) {
         $success  =  "Request send, saved into DB";
     } else {
         $success  =  "Error: " . $sql . "<br>" . mysqli_error($conn);
     }

echo $success;

}
else if($_REQUEST['action']==='RequestSection'){
     
   $sentRequest = $_REQUEST['sentRequest'];

//    $sql_check = "SELECT * FROM register where id = '$sentRequest'";
//    $result_check = mysqli_query($conn, $sql_check);
    
   
//        $row_check = mysqli_fetch_assoc($result_check);






   
   $type = $_REQUEST['type'];
   if($type == 1){
    $sql_acceptReq = "UPDATE requests SET accepted='1' WHERE sendingfrom='$sentRequest'";
     $dateNow = date('Y-m-d');
     $MyId = $_SESSION['member_id'];
    $sql_insert_friends = "INSERT INTO friends (user1, user2, date_added) VALUES ('$sentRequest', '$MyId', '$dateNow')"; 




        if (mysqli_query($conn, $sql_acceptReq) and mysqli_query($conn, $sql_insert_friends)) {
                echo "success_accepted";
        }else{
              echo  mysqli_error($conn);
        }  
        
   }else if($type == 2){
    $sql_rejectReq = "UPDATE requests SET accepted='2' WHERE sendingfrom='$sentRequest'";

    if (mysqli_query($conn, $sql_rejectReq)) {
            echo "success_Reject";
    }else{
          echo  mysqli_error($conn);
    }  

   }

}

else if($_REQUEST['action']==='postStatus'){
   
   $dateAdded_now = date('Y-m-d');
   $memID = $_SESSION['member_id'];
   $status = $_REQUEST['status'];
   $postTo = $_REQUEST['postTo'];
   $sql_statusINSERT = "INSERT INTO posts (userid, post_to, post_status, date_added) VALUES ('$memID','$postTo', '$status', '$dateAdded_now')"; 
  
   if (mysqli_query($conn, $sql_statusINSERT)) {

      echo 'success';
   } else {
      $success  =  "Error: " . $sql_statusINSERT . "<br>" . mysqli_error($conn);
  }

   

}

else if($_REQUEST['action']==='fetchAllStatus'){
   // $memID = $_SESSION['member_id'];
   $uid = $_REQUEST['uid'];  
if($uid == $_SESSION['member_id']){
    $s_ID = $_SESSION['member_id'];
   $sql_fetchAllSTATUS = "SELECT * FROM posts where userid = '$s_ID' or post_to = '$s_ID' order by id DESC";
}else{
   $sql_fetchAllSTATUS = "SELECT * FROM posts where userid = '$uid' or post_to = '$uid' order by id DESC";
}

 


   $result_fetchAllSTATUS = mysqli_query($conn, $sql_fetchAllSTATUS);   

 $posts = '';
   while($row_fetchAllSTATUS = mysqli_fetch_assoc($result_fetchAllSTATUS)) {
      $storedID = $row_fetchAllSTATUS['userid'];
      $sql_profilePIC = "SELECT * FROM profile where user_id = '$storedID'"; 
      $result_profilePIC = mysqli_query($conn, $sql_profilePIC);   
      $row_profilePIC = mysqli_fetch_assoc($result_profilePIC);


      $sql_getName = "SELECT * FROM register where id = '$storedID'"; 
      $result_getName = mysqli_query($conn, $sql_getName);   
      $row_getName = mysqli_fetch_assoc($result_getName);
      $postingTo = '';
      $post_to = $row_fetchAllSTATUS['post_to'];
      if($post_to != 0 && $post_to != $_SESSION['member_id']){
         $sql_getName_post = "SELECT * FROM register where id = '$post_to'"; 
         $result_getName_post = mysqli_query($conn, $sql_getName_post);   
         $row_getName_post = mysqli_fetch_assoc($result_getName_post);
          $postingTo = " <small> > </small>" . $row_getName_post['name'];
      }

      $posts .= 
      '
<div class="row mt-4">
   <div class="col-2">
   <img src="images/'. $row_profilePIC['profile_pic'] .'" height=50 width=50>
   </div>
   <div class="col-10">
   <p class="text-uppercase p-0 m-0"><a href="timeline.php?id='. $storedID.'">'. $row_getName['name'] .'</a>
   
   <a href="timeline.php?id='. $post_to.'">'.$postingTo.'</a>
   
   </p>
   
   '. $row_fetchAllSTATUS['post_status'] .'
   
   </div>

   <div class="col-2"></div>
   <div class="col-10 d-flex justify-content-end "> 
      <input type="text" class="form-control" id="comment_input_'.$row_fetchAllSTATUS['id'].'" placeholder="Enter Comment"> 
      <input type="button" value="Save"  id="comment_button_'.$row_fetchAllSTATUS['id'].'">
   </div>
   
   <div class="col-12 text-right">
      <a href="javascript:void(0)" onclick="loadRelatedComment('.$row_fetchAllSTATUS['id'].')">View Comments</a>
      <div id="displayRelatedComment'.$row_fetchAllSTATUS['id'].'">
      </div>
   </div>
</div>
 
<script>
$("#comment_button_'.$row_fetchAllSTATUS['id'].'").click(function(){
   $comment = $("#comment_input_'.$row_fetchAllSTATUS['id'].'").val();
   $.post(`handler/action.php?action=postComment&pid='.$row_fetchAllSTATUS['id'].'&comment=${$comment}`,function(res){
      
      $("#comment_input_'.$row_fetchAllSTATUS['id'].'").val(" ");
      loadRelatedComment('.$row_fetchAllSTATUS['id'].');
   })
})
</script>
';


     

    }

    echo $posts;

}
else if($_REQUEST['action']==='postComment'){
 $comment =  $_REQUEST['comment'];
 $pid = $_REQUEST['pid'];
 $uid = $_SESSION['member_id'];
 $dateAdded_now = date('Y-m-d');
 
 $sql_insertComment = "INSERT INTO comments (post_id, user_id, comment, date_added) VALUES ('$pid', '$uid', '$comment', '$dateAdded_now')"; 
  
   if (mysqli_query($conn, $sql_insertComment)) {

      echo 'success comment Inserted';
   } else {
      $success  =  "Error: " . $sql_statusINSERT . "<br>" . mysqli_error($conn);
  }


}

else if($_REQUEST['action']==='relatedComments'){
   $pid  = $_REQUEST['pid'];
   $sql_relatedComments = "SELECT * FROM comments where post_id = '$pid' order by id DESC";

   $result_relatedComments = mysqli_query($conn, $sql_relatedComments);   

 $comments = '';
   while($row_relatedComments = mysqli_fetch_assoc($result_relatedComments)) {
      $storedID = $row_relatedComments['user_id'];
      $sql_profilePIC = "SELECT * FROM profile where user_id = '$storedID'"; 
      $result_profilePIC = mysqli_query($conn, $sql_profilePIC);   
      $row_profilePIC = mysqli_fetch_assoc($result_profilePIC);

      $comments.= "<div class='row my-2'>
      <div class='col-2'><img src='images/".$row_profilePIC['profile_pic']."' height=30>
      </div><div class='col-8 text-left'>".$row_relatedComments['comment']."</div></div>";

   }
   echo $comments;

}
?>