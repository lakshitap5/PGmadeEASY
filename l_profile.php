<?php
session_start();
require_once "other.php";
require_once "pdo.php";
if ( ! isset($_SESSION['landlord_id']) ) {
    die('Access Denied');
}
$name = $_SESSION["landlord_id"];
$sql = "Select * from landlord where landlord_id = $name";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$sql1 = "Select * from landlord_profile where landlord_id = $name";
$stmt1 = $pdo->query($sql1);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
if ( isset($_POST['submit'])) {
  $gend = isset($_POST["gender"]) ? $_POST['gender']+0 : -1;
  if ( $gend == -1 ) {
      $_SESSION['error'] = "Please select Gender";
      header("Location: l_profile.php");
      return;
  }
  if ($gend == 0){
    $gender = "Male" ;
  }
  else if ($gend == 1){
    $gender = "Female" ;
  }
  else if ($gend == 2){
    $gender = "Other" ;
  }
    $msg = validatelProfile();
    if (is_string($msg)){
      $_SESSION['error'] = $msg;
      header("Location: l_profile.php");
      return;
    }

else {
  $stm = $pdo->prepare('DELETE from landlord_profile where landlord_id = :l_id');
  $stm->execute(array(
   ':l_id' => $_SESSION['landlord_id']));

          $stmt = $pdo->prepare('INSERT INTO landlord_profile (landlord_id, age, gender, phone, address)
           VALUES (:lid, :ag, :ge, :ph, :ad)');
          $stmt->execute(array(
           ':lid' => $_SESSION['landlord_id'],
           ':ag' => $_POST['age'],
           ':ge' => $gender,
           ':ph' => $_POST['phone'],
           ':ad' => $_POST['address']));
           $_SESSION['success'] = "Profile Saved Successfully";
           header("Location: index.php");
           return;

    }
}

?>
<Doctype html>
<html>
<head>
  <meta charset="utf-8" lang="en"/>
  <title>Profile</title>
  <link rel="stylesheet" href="pg.css">
</head>
<body>
  <div style="width:25%" class="login2">
  <h3 class="heading">Complete Profile</h3>
  <?php
  flashMessages();
  ?>
  <form method="POST">
    <label for="fname">First Name</label>
<br>    <input type="text" readonly name="first_name" id="fname" value="<?=htmlentities($row['first_name']) ?>"><br/>
<br>    <label for="lname">Last Name</label>
<br>    <input type="text" readonly name="last_name" id="lname" value="<?=htmlentities($row['last_name']) ?>"><br/>
<br>    <label for="mail">Email</label>
<br>    <input type="email" readonly name="email" id="mail" value="<?=htmlentities($row['email']) ?>"><br/>
<br>    <label for="age">Age (in years)</label>
<br>    <input type="number" name="age" id="age" value="<?=htmlentities($row1['age']) ?>"><br/><br>
    <?php
    if ($row1){
    if ($row1['gender']=="Male")
    {
      echo '<label for="gender">Gender</label>';
      echo '<br><select name="gender" id="gender" style="width:170px;">';
      echo '<option value="-1">Select</option>';
      echo '<option value="0" selected>Male</option>';
      echo '<option value="1">Female</option>';
      echo '<option value="2">Other</option>';
      echo '</select><br/>';
    }
    else if ($row1['gender']=="Female")
    {
      echo '<label for="gender">Gender</label>';
      echo '<br><select name="gender" id="gender" style="width:170px;">';
      echo '<option value="-1">Select</option>';
      echo '<option value="0">Male</option>';
      echo '<option value="1" selected>Female</option>';
      echo '<option value="2">Other</option>';
      echo '</select><br/>';
    }
    else if ($row1['gender']=="Other")
    {
      echo '<label for="gender">Gender</label>';
      echo '<br><select name="gender" id="gender" style="width:170px;">';
      echo '<option value="-1">Select</option>';
      echo '<option value="0" >Male</option>';
      echo '<option value="1">Female</option>';
      echo '<option value="2" selected>Other</option>';
      echo '</select><br/>';
    }
  }
    else {
      echo '<label for="gender">Gender</label>';
      echo '<br><select name="gender" id="gender" style="width:170px;">';
      echo '<option value="-1" selected>Select</option>';
      echo '<option value="0" >Male</option>';
      echo '<option value="1">Female</option>';
      echo '<option value="2">Other</option>';
      echo '</select><br/>';
    }
    ?>
    <br><label for="ph">Mobile Number</label>
    <br><input type="number" name="phone" id="ph" value="<?=htmlentities($row1['phone']) ?>"><br/>
    <?php
    if ($row1)
    {
      echo '<br><label for="address">Address</label>';
      echo '<br><textarea style="width:100%" name="address" id="address" rows="4" cols="50">'. htmlentities($row1["address"]).'</textarea><br/>';
    }
    else {
      echo '<br><label for="address">Address</label>';
      echo '<br><textarea style="width:100%" name="address" id="address" rows="4" cols="50">Not more than 500 words</textarea><br/>';
    }
    ?>
    <br><input style="margin-right: 5px" class="fed" type="submit" name="submit" value="Save Profile"/>
    <input style="margin-right: 5px" class="fed" type="button" onclick="location.href='index.php';" value="Cancel"/><br><br><br>
  </form>
</div>

<div class='ripple-background'>
  <div class='circle xxlarge shade1'></div>
  <div class='circle xlarge shade2'></div>
  <div class='circle large shade3'></div>
  <div class='circle mediun shade4'></div>
  <div class='circle small shade5'></div>
</div>
</body>
</html>
