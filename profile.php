<?php include('inc/header.php') ?>
<?php include('inc/config.php') ?>
<?php


$user_id = $_SESSION['member_id'];


$sql_displayValues = "SELECT * FROM profile where user_id = '$user_id'";
$result_displayValues = mysqli_query($conn, $sql_displayValues);

 $row_displayValues = mysqli_fetch_assoc($result_displayValues);
$about = $row_displayValues['about'];
$gender = $row_displayValues['gender'];
$dob = $row_displayValues['dob'];
$education1 = $row_displayValues['education1'];
$education2 = $row_displayValues['education2'];
$education3 = $row_displayValues['education3'];
$country = $row_displayValues['country']; 
$profile_pic = $row_displayValues['profile_pic']; 

 

$error = '';
$success = '';

if(isset($_REQUEST['submit'])){

    $about_fetched = $_REQUEST['about'];
    $gender_fetched = $_REQUEST['gender'];
    $dob_fetched = $_REQUEST['dob'];
    $edu1_fetched = $_REQUEST['edu1'];
    $edu2_fetched = $_REQUEST['edu2'];
    $edu3_fetched = $_REQUEST['edu3'];
    $country_fetched = $_REQUEST['country']; 
    $dateAdded_fetched = date('Y-m-d');

  
    if(!empty($about_fetched) && !empty($gender_fetched) && !empty($dob_fetched)&& !empty($edu1_fetched)&& !empty($edu2_fetched)&& !empty($edu3_fetched)&& !empty($country_fetched)){


        
$sql_check_isavail = "SELECT * FROM profile where user_id = '$user_id'";
$result_check_isavail = mysqli_query($conn, $sql_check_isavail);

// var_dump($_FILES['picture']); 
$fileName = $_FILES['profile_pic']['name'];
$tempLocation = $_FILES['profile_pic']['tmp_name'];
$newfileName = rand(9999,1000).date('ymdhis').$fileName;  
move_uploaded_file($tempLocation,'images/'.$newfileName);



if (mysqli_num_rows($result_check_isavail) == 1) {
    // update query
    $sql_update = "UPDATE profile SET profile_pic='$newfileName',
     about='$about_fetched', dob='$dob_fetched', gender='$gender_fetched', education1='$edu1_fetched', education2='$edu2_fetched', education3='$edu3_fetched', country='$country_fetched'
      WHERE user_id='$user_id'";

if (mysqli_query($conn, $sql_update)) {
  echo "Record updated successfully";
  
$sql_displayValues = "SELECT * FROM profile where user_id = '$user_id'";
$result_displayValues = mysqli_query($conn, $sql_displayValues);

 $row_displayValues = mysqli_fetch_assoc($result_displayValues);
$about = $row_displayValues['about'];
$gender = $row_displayValues['gender'];
$dob = $row_displayValues['dob'];
$education1 = $row_displayValues['education1'];
$education2 = $row_displayValues['education2'];
$education3 = $row_displayValues['education3'];
$country = $row_displayValues['country']; 
$profile_pic = $row_displayValues['profile_pic']; 

} else {
  echo "Error updating record: " . mysqli_error($conn);
}

      
}else{


 
    $sql = "INSERT INTO profile (profile_pic, user_id, about, gender, dob, education1, education2, education3, country, date_added) 
    VALUES ('$newfileName','$user_id', '$about_fetched', '$gender_fetched', '$dob_fetched', '$edu1_fetched', '$edu2_fetched', '$edu3_fetched', '$country_fetched', '$dateAdded_fetched')"; 
              if (mysqli_query($conn, $sql)) {
                  $success  =  "Profile Created";
                  
$sql_displayValues = "SELECT * FROM profile where user_id = '$user_id'";
$result_displayValues = mysqli_query($conn, $sql_displayValues);

 $row_displayValues = mysqli_fetch_assoc($result_displayValues);
$about = $row_displayValues['about'];
$gender = $row_displayValues['gender'];
$dob = $row_displayValues['dob'];
$education1 = $row_displayValues['education1'];
$education2 = $row_displayValues['education2'];
$education3 = $row_displayValues['education3'];
$country = $row_displayValues['country']; 
$profile_pic = $row_displayValues['profile_pic']; 

              } else {
                  $success  =  "Error: " . $sql . "<br>" . mysqli_error($conn);
              }
  

    
}




              


 
    }
    else{
        $error = 'All fields are compulsory';
    }

}


?>




<div class="mt-5">
<h1 class="text-center">Edit Your Profile</h1>

<?php echo $error; ?>
<?php echo $success; ?>

<form action="profile.php" method='post' enctype='multipart/form-data'>
<div class="row">
<div class="col-6">
<div class="form-group">
        <label for="profile_pic">Add Profile Pic:</label>
        <input type="file" class='form-control' name='profile_pic'>
    </div>
</div>
<div class="col-6">
<?php if(isset($profile_pic)) {?>
<img src="<?php echo isset($profile_pic) ? "images/".$profile_pic : '' ?>" alt="" height=300 width=300><br>
<?php } ?>
</div>
</div>

    <div class="form-group">
        <label for="about">About:</label>
        <textarea  id="" cols="30" rows="3" class='form-control' name='about'><?php echo (isset($about)) ? "$about" : ""?></textarea>
    </div>
    <div class="form-group">
        <label for="gender">Select Gender:</label> 
       <input type="radio" name='gender' value='m' <?php echo (isset($gender) && $gender=='m') ? "checked" : ""?>> Male
       <input type="radio" name='gender' value='f' <?php echo (isset($gender) && $gender=='f') ? "checked" : ""?>> Female
    </div>
    <div class="form-group">
        <label for="gender">Select DOB:</label> 
       <input type="date" name='dob' class='form-control' value='<?php echo (isset($dob)) ? "$dob" : ""?>'>
    </div>
    <div class="form-group">
        <label for="gender">Add Education:</label> 
       <input type="text" name='edu1' class='form-control' value='<?php echo (isset($education1)) ? "$education1" : ""?>'>
       <input type="text" name='edu2' class='form-control' value='<?php echo (isset($education2)) ? "$education2" : ""?>'>
       <input type="text" name='edu3' class='form-control' value='<?php echo (isset($education3)) ? "$education3" : ""?>'>
    </div>
     
    <div class="form-group">
        <label for="gender">Select Country:</label> 
      
      <select name="country" id="" name='country'>
      <?php
      
      $sql_country = "SELECT * FROM countries";
$result_country = mysqli_query($conn, $sql_country);  
    while($row = mysqli_fetch_assoc($result_country)) {
       echo "<option value='".$row['num_code']."'>" .$row['en_short_name']."</option>";

    }  
      ?>
      
      </select>
    </div>
     
     
 

  <!-- <input type="text" class="form-control" placeholder="Enter email" name="name" value='<?php echo (isset($name)) ? $name: ''  ?>'> -->

  <button type="submit" name='submit' class="btn btn-primary">Submit</button>
</form>

</div>






<?php include('inc/footer.php') ?>