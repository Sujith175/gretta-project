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
        <button class="btn btn-primary" onclick="reqAction(1,'.$reqSendingFrom.')">Accept</button> 
        <button class="btn btn-success" onclick="reqAction(2,'.$reqSendingFrom.')">Reject</button>';




     $sql_notification = "INSERT INTO notifications (noti_From, noti_To, message, is_read, date_added) VALUES ('$reqSendingFrom', '$reqSendingTo', '$message', '0', '$dateAdded_now')"; 

      
      if (mysqli_query($conn, $sql_notification) && mysqli_query($conn, $sql)) {
         $success  =  "Request send, saved into DB";
     } else {
         $success  =  "Error: " . $sql . "<br>" . mysqli_error($conn);
     }

echo $success;

}
else if($_REQUEST['action']==='RequestSection'){
     
    
}

?>