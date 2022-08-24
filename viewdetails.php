<?php
session_start();
require_once 'pdo.php';
if (!isset($_SESSION['tenant_id']) || !isset($_REQUEST['id']) || !isset($_SESSION['search'])){
  die('Access Denied');
}
//echo $_SESSION['tenant_id'];
if (isset($_POST['cancel'])){
  header("Location: view.php");
  return;
}
//echo $_REQUEST['id'];
$name = $_SESSION['search'];
$rid = $_REQUEST['id'];
$sql = "Select * from rooms where room_id = $rid order by rent ";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$lan_id = $row['landlord_id'];
$s = "Select overall from feedback where landlord_id = $lan_id";
$st = $pdo->query($s);
$average = 0;
$count = 0;
while($r = $st->fetch(PDO::FETCH_ASSOC)){
  $average = $average + $r['overall'];
  $count++ ;
}
if($count == 0){
  $average = "Not Rated Yet";
}
else{
  $average = $average/$count ;
}

$lid = $row['landlord_id'];
$rname = $row['room_name'];
//echo $lid;
if (isset($_POST['request'])){
$st = $pdo->prepare('INSERT INTO requests (landlord_id , tenant_id , request ,room) VALUES (:l_id , :t_id , :req, :ro)');
   $st->execute(array(
     ":l_id" => $lid,
     ":t_id" => $_SESSION['tenant_id'],
     ":req" => 1,
     ":ro" => $rname
   ));
   $_SESSION['success'] = "Request Sent Successfully";
   header("Location: index.php");
   return;
}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 <title>View details</title>
 <link rel="stylesheet" href="pg.css"/>
 </head>
 <body>
   <div class='ripple-background'>
     <div class='circle xxlarge shade1'></div>
     <div class='circle xlarge shade2'></div>
     <div class='circle large shade3'></div>
     <div class='circle mediun shade4'></div>
     <div class='circle small shade5'></div>
   </div>

   <div style="width:25%" class="addroom">
     <h1 class="heading">Room Details</h1>

   <p>Name: <br><?= htmlentities($row['room_name'])?></p>
   <p>Address: <br><?= htmlentities($row['address'])?></p>
   <p>City: <br><?= htmlentities($row['city'])?></p>
   <p>Number of Persons Allowed: <br><?= htmlentities($row['no_persons'])?></p>
   <p>Number of Rooms: <br><?= htmlentities($row['no_rooms'])?></p>
   <p>Number of persons per room: <br><?= htmlentities($row['no_persons']/$row['no_rooms'])?></p>
   <p>Number of Washooms: <br><?= htmlentities($row['washrooms'])?></p>
   <?php
   $pg = "dbh";
   if ($row['pgtype'] == 1){
     $pg = "Full House to be rented";
   }
   else{
     $pg = "Only some portion need to be rented";
   }
   echo '<p>PG Type: <br>'.$pg.'</p>';
   echo '<p>PG for: <br>';
   if ($row['boys'] == 1){
     $boy = "Boys ";
     echo $boy;
   }
   if ($row['girls'] == 1){
     $girl = "Girls ";
     echo $girl;
   }
   if ($row['family'] == 1){
     $family = "Family ";
     echo $family;
   }
   echo '</p>';
   if ($row['furnished'] == 1){
     $fur = "Yes, Fully Furnished";
   }
   else{
     $fur = "Not Furnished";
   }
   echo '<p>Furnished: <br>'.$fur.'</p>';
   if ($row['ac'] == 1){
     $ac = "AC";
   }
   else{
     $ac = "Non AC";
   }
   echo '<p>Room Type: <br>'.$ac.'</p>';
   if ($row['power'] == 1){
     $power = "Yes";
   }
   else{
     $power = "No";
   }
   echo '<p>Power Generator: <br>'.$power.'</p>';
   if ($row['food'] == 1){
     $food = "Yes, Tiffin Service Available";
   }
   else{
     $food = "No";
   }
   echo '<p>Food Services: <br>'.$food.'</p>';
   if ($row['kitchen'] == 1){
     $kitchen = "Yes, separate kitchen available";
   }
   else{
     $kitchen = "separate kitchen not available";
   }
   echo '<p>Kitchen: <br>'.$kitchen.'</p>';
   if ($row['gas'] == 1){
     $gas = "Yes";
   }
   else{
     $gas = "No";
   }
   echo '<p>Gas Connection: <br>'.$gas.'</p>';
   if ($row['elec_meter'] == 1){
     $meter = "Yes, submeter available";
   }
   else{
     $meter = "No";
   }
   echo '<p>Separate Electricity Meter: <br>'.$meter.'</p>';
   if ($row['water_meter'] == 1){
     $water = "Yes, separate water connection available";
   }
   else{
     $water = "No";
   }
   echo '<p>Separate Water Connection: <br>'.$water.'</p>';
    ?>
    <p>Room Description: <br><?= htmlentities($row['room_desc'])?></p>
    <p>Rent: Rs.<br><?= htmlentities($row['rent'])?> per month</p>
    <p>Overall Rating (out of 5): <br><?= htmlentities($average)?></p>
<form method="post">
  <input style="margin-right: 5px" class="fed" type="submit" name="request" value="Send Request" style="width:170px;"/>
  <input style="margin-right: 5px" class="fed" type="submit" class="sub" name="cancel" value="Cancel" style="width:170px;"/><br><br><br>
<br>
</form>
</div>
 </body>
 </html>
