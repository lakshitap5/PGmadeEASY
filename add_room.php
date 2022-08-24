<?php
session_start();
require_once "other.php";
require_once "pdo.php";
if ( ! isset($_SESSION['landlord_id']) ) {
    die('Access Denied');
}
if (isset($_POST['cancel'])){
  header("Location: index.php");
  return;
}
if (isset($_POST['submit'])){
  $msg = validateroom();
  if (is_string($msg)){
    $_SESSION['error'] = $msg;
    header("Location: add_room.php");
    return;
  }
  else{
    $stmt = $pdo->prepare('INSERT INTO rooms (landlord_id, city, address, pgtype, no_rooms, no_persons, boys,
    girls, family, washrooms, furnished, ac, power, food, kitchen, gas, elec_meter, water_meter, room_desc, rent, room_name)
     VALUES (:lid, :city, :ad, :pg, :room, :per, :boys, :girls, :family, :wash, :fur, :ac, :po, :food, :kit, :gas, :elec, :water, :rdesc, :rent, :rname)');
    $stmt->execute(array(
     ':lid' => $_SESSION['landlord_id'],
     ':rname' => $_POST['rname'],
     ':city' => $_POST['City'],
     ':ad' => $_POST['Address'],
     ':pg' => $_POST['pgtype'],
     ':room' => $_POST['rooms'],
     ':per' => $_POST['capacity'],
     ':boys' => $_POST['boys'],
     ':girls' => $_POST['girls'],
     ':family' => $_POST['family'],
     ':wash' => $_POST['washrooms'],
     ':fur' => $_POST['furnished'],
     ':ac' => $_POST['ac'],
     ':po' => $_POST['Power'],
     ':food' => $_POST['Food'],
     ':kit' => $_POST['kitchen'],
     ':gas' => $_POST['Gas'],
     ':elec' => $_POST['electricity_meter'],
     ':water' => $_POST['water_connection'],
     ':rdesc' => $_POST['room_description'],
     ':rent' => $_POST['rent']));
     $_SESSION['success'] = "Rooms Added Successfully";
     header("Location: index.php");
     return;
  }
}
?>
<Doctype html>
<html>
<head>
  <meta charset="utf-8" lang="en"/>
    <link rel="stylesheet" href="pg.css">
    <title>
        Add Room Details
    </title>
</head>
<body>
  <div style="width:30%" class="addroom">
  <h1 class="heading">
      Add Room Details
  </h1>
  <?php
  flashMessages();
  ?>
    <form method="POST">
        <label >Name : <br><input type="text" name="rname" ></label>
        <p><strong>Note:</strong> This Name will appear to the tenant</p>
        <label >City : <br><input type="text" name="City" ><br><br></label>
        <label >Address : <br><textarea style="width:100%" name="Address" rows="3" cols="50"></textarea><br><br></label>
        PG Type : <label><br><input type="radio" name="pgtype" value="1">Full house to be rented</label>
        <label><input type="radio" name="pgtype" value="0"> Only some rooms to be rented<br><br></label>
        <label >Number of Rooms : <br><input type="number" name="rooms"><br><br></label>
        <label >Person Capacity : <br><input type="number" name="capacity"><br><br></label>
        Available for :
        <label><br><input type="checkbox" name="boys" value="1">Boys</label>
        <label><input type="checkbox" name="girls" value="1"> Girls</label>
        <label><input type="checkbox" name="family" value="1">Family <br><br></label>
        <label >Number of Washrooms : <br><input type="number" name="washrooms"><br><br></label>
        Fully Furnished : <br><label><input type="radio" name="furnished" value="1">Yes</label>
        <label><input type="radio" name="furnished" value="0">No<br><br></label>
        Air Conditioned : <br><label><input type="radio" name="ac" value="1">Yes</label>
        <label><input type="radio" name="ac" value="0">No<br><br></label>
        Power Backup : <br><label><input type="radio" name="Power" value="1">Yes</label>
        <label><input type="radio" name="Power" value="0">No<br><br></label>
        Food Services : <br><label><input type="radio" name="Food" value="1">Yes</label>
        <label><input type="radio" name="Food" value="0">No<br><br></label>
        With Kitchen : <br><label><input type="radio" name="kitchen" value="1">Yes</label>
        <label><input type="radio" name="kitchen" value="0">No<br><br></label>
        Gas Connection : <br><label><input type="radio" name="Gas" value="1">Yes</label>
        <label><input type="radio" name="Gas" value="0">No<br><br></label>
        Separate electricity meter : <br><label><input type="radio" name="electricity_meter" value="1">Yes</label>
        <label><input type="radio" name="electricity_meter" value="0">No<br><br></label>
        Separate water connection : <br><label><input type="radio" name="water_connection" value="1">Yes</label>
        <label><input type="radio" name="water_connection" value="0">No<br><br></label>
        <label>Room Description : <br><textarea style="width:100%" name="room_description" rows="3" cols="50"></textarea><br><br></label>
        <label>Rent per Month (in INR) : <br><input type="Number" name="rent"><br><br></label>
        <input style="margin-right: 5px" class="fed" type="submit" name="submit" value="Submit" style="width:170px;"/>
        <input style="margin-right: 5px" class="fed" type="submit" name="cancel" value="cancel" style="width:170px;"/>
    </form>

    <div class='ripple-background'>
      <div class='circle xxlarge shade1'></div>
      <div class='circle xlarge shade2'></div>
      <div class='circle large shade3'></div>
      <div class='circle mediun shade4'></div>
      <div class='circle small shade5'></div>
    </div>


</body>

</html>
