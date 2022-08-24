<?php
session_start();
require_once 'pdo.php';
require_once 'other.php';
if ( ! isset($_SESSION['landlord_id']) || ! isset($_SESSION['lan_id']) || !isset($_SESSION['flag'])) {
    die('Access Denied');
}
//echo $_SESSION['landlord_id'];
//echo $_SESSION['tenant_id'];
$l_id = $_SESSION['lan_id'];

if (isset($_POST['cancel'])){
  unset($_SESSION['lan_id']);
  if($_SESSION['flag']==1){
    header("Location: notify.php?id=".$l_id);
  }
  else if($_SESSION['ten']==1){
  header("Location: viewlandlord.php?id=".$l_id);
}
  return;
}
if ($_SESSION['flag']==1){
$flag = 0;
}
if ($_SESSION['ten']==1){
  $flag = 1;
}
if(isset($_POST['submit'])){
  if($_POST['locality']<1 || $_POST['price']<1 || $_POST['hygiene']<1 || $_POST['facilities']<1 || $_POST['overall']<1 || strlen($_POST['remarks'])<1){
    $_SESSION['error'] = "All Fields are required";
    header("location: feedback.php");
    return;
  }
  if(strlen($_POST['remarks'])>400){
    $_SESSION['error'] = "400 letters limit exceeded";
    header("location: feedback.php");
    return;
  }
  else{
    if($_SESSION['flag']==1){
      $stmt = $pdo->prepare('INSERT INTO tenfeedback (landlord_id, tenant_id,personality, nature, hygiene, cooperate, overall , remarks)
       VALUES (:lid, :tid, :lo, :pr, :hy, :fa, :ov, :re)');
      $stmt->execute(array(
       ':lid' => $_SESSION['landlord_id'],
       ':tid' => $l_id,
       ':lo' => $_POST['locality'],
       ':pr' => $_POST['price'],
       ':hy' => $_POST['hygiene'],
       ':fa' => $_POST['facilities'],
       ':ov' => $_POST['overall'],
       ':re' => $_POST['remarks']));
       $_SESSION['success'] = "Thanks for your Feedback";
       unset($_SESSION['lan_id']);
         header("Location: notify.php?id=".$l_id);
       return;
    }
    else if ($_SESSION['ten']==1){
    $stmt = $pdo->prepare('INSERT INTO feedback (landlord_id, tenant_id,locality, price, hygiene, facilities, overall , remarks, flag)
     VALUES (:lid, :tid, :lo, :pr, :hy, :fa, :ov, :re, :fl)');
    $stmt->execute(array(
     ':lid' => $l_id,
     ':tid' => $_SESSION['tenant_id'],
     ':lo' => $_POST['locality'],
     ':pr' => $_POST['price'],
     ':hy' => $_POST['hygiene'],
     ':fa' => $_POST['facilities'],
     ':ov' => $_POST['overall'],
     ':re' => $_POST['remarks'],
   ':fl' => $flag));
     $_SESSION['success'] = "Thanks for your Feedback";
     unset($_SESSION['lan_id']);
     header("Location: viewlandlord.php?id=".$l_id);
     return;
   }
  }
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset = "UTF-8">
   <title> Feedback</title>
   <link rel="stylesheet" href="pg.css">
  </head>
<body>
  <div class='ripple-background'>
    <div class='circle xxlarge shade1'></div>
    <div class='circle xlarge shade2'></div>
    <div class='circle large shade3'></div>
    <div class='circle mediun shade4'></div>
    <div class='circle small shade5'></div>
  </div>

<div style="width:30%" class="login2">
<h1 class="heading">Feedback</h1>
<?php
flashMessages();
 ?>

<form method="POST">

 Personality :<br><br>
 <label><input type="radio" name="locality" value="5">Very Good</label>
 <label><input type="radio" name="locality" value="4">Good</label>
 <label><input type="radio" name="locality" value="3">Average</label>
 <label><input type="radio" name="locality" value="2">Poor</label>
 <label><input type="radio" name="locality" value="1">Very Poor</label>  <br><br>
 Nature :<br><br>
 <label><input type="radio" name="price" value="5">Very Good</label>
 <label><input type="radio" name="price" value="4">Good</label>
 <label><input type="radio" name="price" value="3">Average</label>
 <label><input type="radio" name="price" value="2">Poor</label>
 <label><input type="radio" name="price" value="1">Very Poor</label> <br><br>
 Self Hygiene :<br><br>
 <label><input type="radio" name="hygiene" value="5">Very Good</label>
 <label><input type="radio" name="hygiene" value="4">Good</label>
 <label><input type="radio" name="hygiene" value="3">Average</label>
 <label><input type="radio" name="hygiene" value="2">Poor</label>
 <label><input type="radio" name="hygiene" value="1">Very Poor</label> <br><br>
 Co-operativeness :<br><br>
 <label><input type="radio" name="facilities" value="5">Very Good</label>
 <label><input type="radio" name="facilities" value="4">Good</label>
 <label><input type="radio" name="facilities" value="3">Average</label>
 <label><input type="radio" name="facilities" value="2">Poor</label>
 <label><input type="radio" name="facilities" value="1">Very Poor</label> <br><br>
 Overall :<br><br>
 <label><input type="radio" name="overall" value="5">Very Good</label>
 <label><input type="radio" name="overall" value="4">Good</label>
 <label><input type="radio" name="overall" value="3">Average</label>
 <label><input type="radio" name="overall" value="2">Poor</label>
 <label><input type="radio" name="overall" value="1">Very Poor</label> <br><br>
 <label>Remarks :<br><textarea style="width:100%" type="text" name="remarks" rows="3" cols="50"></textarea></label><br>
 <input style="margin-right: 5px" class="fed" type="submit" class="sub" name="submit" value="Submit" style="width: 150px;">
 <input style="margin-right: 5px" class="fed" type="submit" name="cancel" value="Back" style="width: 150px;"><br><br><br>
</form>
</div>

</body>
</html>
