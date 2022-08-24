<?php
session_start();
require_once 'pdo.php';
if(!isset($_SESSION['landlord_id']) || !isset($_REQUEST['id'])){
  die('Access Denied');
}
if (isset($_POST['cancel'])){
  header("Location: index.php");
  return;
}
//echo $_SESSION['landlord_id'];
$tid = $_REQUEST['id'];
$li = $_SESSION['landlord_id'];
$s = "SELECT accept,decline from requests where tenant_id = $tid and landlord_id = $li and request = 1";
$tmt = $pdo->query($s);
$r = $tmt->fetch(PDO::FETCH_ASSOC);
if ($r == false){
  $_SESSION['error'] = "Bad value for id";
  header("Location: index.php");
  return;
}

$f = "Select s_no from tenfeedback where landlord_id = $li and tenant_id = $tid ";
$stf = $pdo->query($f);
$rf = $stf->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['accept'])){
  $sql = "UPDATE requests SET accept = 1 , decline = 0 where tenant_id = :tid and landlord_id = :li";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ":tid" => $tid,
    ":li" => $_SESSION['landlord_id']
  ));
  $_SESSION['success'] = "Request Approved";
  header("Location: index.php");
  return;
}
if (isset($_POST['decline'])){
  $sql = "UPDATE requests SET decline = 1 , accept = 0 where tenant_id = :tid and landlord_id = :li";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ":tid" => $tid,
    ":li" => $_SESSION['landlord_id']
  ));
  $_SESSION['success'] = "Request Declined";
  header("Location: index.php");
  return;
}
$s = "Select overall from tenfeedback where tenant_id = $tid";
$st = $pdo->query($s);
$average = 0;
$count = 0;
while($rr = $st->fetch(PDO::FETCH_ASSOC)){
  $average = $average + $rr['overall'];
  $count++ ;
}
if($count == 0){
  $average = "Not Rated Yet";
}
else{
  $average = $average/$count ;
}
//echo $_REQUEST['id'];
$tid = $_REQUEST['id'];
$sq = "Select * from tenant where tenant_id = $tid ";
$stm = $pdo->query($sq);
$ro = $stm->fetch(PDO::FETCH_ASSOC);
$sql = "Select * from tenant_profile where tenant_id = $tid ";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row['status']==1){
  $status = "Single";
}
if ($row['status']==2){
  $status = "Married";
}
echo "<div style='width:25%' class='login2'><h1 class='heading'>Tenant's Profile</h1>";
echo "First Name: <br>".$ro['first_name']."<br><br>";
echo "Last Name: <br>".$ro['last_name']."<br><br>";
echo "Email: <br>".$ro['email']."<br><br>";
echo "Age: <br>".$row['age']."<br><br>";
echo "Gender: <br>".$row['gender']."<br><br>";
echo "Status: <br>".$status."<br><br>";
echo "Contact Number: <br>".$row['phone']."<br><br>";
echo "Address: <br>".$row['address']."<br><br>";
echo "Tenant Rating: <br>".htmlentities($average)."<br>";
echo '<form method="POST">';
if ($r['accept']==1){
  $_SESSION['flag'] = 1;
  $_SESSION['ten'] = 0;
  $_SESSION['lan_id'] = $tid;
  echo '<p style="color:green">Request Accepted</p>';
  if($rf){
    echo '<p style="color:green">Feedback Submitted</p>';
  }
  else{
    echo '<a style="text-decoration:none; margin-right:5px" class="fed" href="tenantfeed.php">Give Feedback</a>';
  }
  echo '<input class="fed" type="submit" name="cancel" value="Cancel"><br><br><br>';
}
else if ($r['decline'] == 1){
  echo '<p style="color:red">Request Declined</p>';
  echo '<input class="fed" type="submit" name="cancel" value="Cancel"><br><br><br>';
}
else{
echo '<input style="margin-right:5px" class="fed" type="submit" name="accept" value="Accept">';
echo '<input style="margin-right:5px"class="fed" type="submit" name="decline" value="Decline">';
echo '<input class="fed" type="submit" name="cancel" value="Cancel"><br><br><br>';

}
echo '</form></div>';
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
