<?php
session_start();
require_once 'pdo.php';
require_once 'other.php';
if (!isset($_SESSION['tenant_id']) || !isset($_REQUEST['id']) || strlen($_REQUEST['id'])<1){
  die('Access Denied');
}
flashMessages();
//echo $_SESSION['tenant_id'];
$lid = $_REQUEST['id'];
if(isset($_POST['back'])){
  unset($_SESSION['landlord_id']);
  header('location: index.php');
  return;
}
//echo $lid;
//echo $_SESSION['tenant_id'];
$tid = $_SESSION['tenant_id'];
$s = "Select accept , decline from requests where landlord_id = $lid and tenant_id = $tid ";
$st = $pdo->query($s);
$r = $st->fetch(PDO::FETCH_ASSOC);
//echo $r['accept'];
$f = "Select s_no,flag from feedback where landlord_id = $lid and tenant_id = $tid ";
$stf = $pdo->query($f);
$rf = $stf->fetch(PDO::FETCH_ASSOC);
//echo $r['decline'];
if ($r['accept']==1 and $r['decline']==0){
  $_SESSION['ten'] = 1;
  $_SESSION['flag'] = 0;
$_SESSION['lan_id'] = $lid ;
$sq = "Select * from landlord where landlord_id = $lid ";
$stm = $pdo->query($sq);
$ro = $stm->fetch(PDO::FETCH_ASSOC);
$sql = "Select * from landlord_profile where landlord_id = $lid ";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo "<div style='width:25%' class='login2'><h1 class='heading'>Landlord's Profile</h1>";
echo "First Name: ".$ro['first_name']."<br><br>";
echo "Last Name: ".$ro['last_name']."<br><br>";
echo "Email: ".$ro['email']."<br><br>";
echo "Age: ".$row['age']."<br><br>";
echo "Gender: ".$row['gender']."<br><br>";
echo "Contact Number: ".$row['phone']."<br><br>";
echo "Address: ".$row['address']."<br><br>";
if ($rf){
  echo '<p style="color:green">Feedback Submitted<p>';
}
else{
echo '<a style="text-decoration:none;margin-right: 5px" class="fed" href="feedback.php">Give Feedback</a>';
}
echo '   ';
echo '<form method="POST"><input style="text-decoration:none;margin-right: 5px" class="fed" type="submit" name="back" value="Back"></Form>';
echo '<br><br>';
}
else{
  $_SESSION['error'] = "Sorry you can only View Details of Landlord who has accepted your Request";
  header("location: index.php");
  return;
}
echo '</div>';
 ?>
 <html>
 <head>
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
</body>
