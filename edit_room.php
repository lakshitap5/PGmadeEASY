<?php
session_start();
require_once "other.php";
require_once "pdo.php";
if ( ! isset($_SESSION['landlord_id']) || ! isset($_REQUEST['id']) ) {
    die('Access Denied');
}
if (isset($_POST['cancel'])){
  header("Location: view_room.php");
  return;
}
if (isset($_POST['submit'])){
  $msg = validateroom();
  if (is_string($msg)){
    $_SESSION["error"] = $msg;
    header("Location: edit_room.php?id=".$_REQUEST['id']);
    return;
  }
  else{
    $stm = $pdo->prepare('DELETE from rooms where room_id = :r_id and landlord_id = :l_id');
    $stm->execute(array(
     ':l_id' => $_SESSION['landlord_id'],
   ':r_id' => $_REQUEST['id']));

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
     $_SESSION['success'] = "Rooms Updated Successfully";
     header("Location: index.php");
     return;
  }
}
$sql = "SELECT * FROM rooms where room_id = :r and landlord_id = :l_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
  ':l_id' => $_SESSION['landlord_id'],
  ":r" => $_REQUEST['id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row == false)
{
  $_SESSION["error"]="Bad Value for room_id";
  header("Location: index.php");
  return;
}
?>
<Doctype html>
<html>
<head>
  <meta charset="utf-8" lang="en"/>
    <title>
        Edit Room Details
    </title>
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

  <div style="width:30%" class="addroom">
  <h1 class="heading">
      Edit Room Details
  </h1>
  <?php
  flashMessages();
  ?>
    <form method="POST">
        <label >Name : <br><input type="text" name="rname" value="<?= htmlentities($row['room_name']) ?>"></label>
        <p><strong>Note:</strong> This Name will appear to the tenant</p>
        <label >City : <br><input type="text" name="City" value="<?= htmlentities($row['city']) ?>"><br><br></label>
        <label >Address : <br><textarea style="width:100%" name="Address" rows="3" cols="50"><?= htmlentities($row['address']) ?></textarea><br><br></label>
        <?php
        if ($row['pgtype']==1){
        echo 'PG Type : <br><label><input type="radio" name="pgtype" value="1" checked="checked">Full house to be rented</label>';
      echo '<label><input type="radio" name="pgtype" value="0"> Only some rooms to be rented<br><br></label>';}
        else{
          echo 'PG Type : <br><label><input type="radio" name="pgtype" value="1">Full house to be rented</label>';
        echo '<label><input type="radio" name="pgtype" value="0" checked="checked"> Only some rooms to be rented<br><br></label>';}
        ?>
        <label >Number of Rooms : <br><input type="number" name="rooms" value="<?= htmlentities($row['no_rooms']) ?>"><br><br></label>
        <label >Person Capacity : <br><input type="number" name="capacity" value="<?= htmlentities($row['no_persons']) ?>"><br><br></label>
        Available for :<br>
        <?php
        if ($row['boys']==1)
        {
          echo '<label><input type="checkbox" name="boys" value="1" checked>Boys</label>';
        }
        else{
          echo '<label><input type="checkbox" name="boys" value="1">Boys</label>';
        }
        if ($row['girls']==1)
        {
          echo '<label><input type="checkbox" name="girls" value="1" checked>Girls</label>';
        }
        else{
          echo '<label><input type="checkbox" name="girls" value="1">Girls</label>';
        }
        if ($row['family']==1)
        {
          echo '<label><input type="checkbox" name="family" value="1" checked>Family <br><br></label>';
        }
        else{
          echo '<label><input type="checkbox" name="family" value="1">Family <br><br></label>';
        }
        ?>
        <label >Number of Washrooms : <br><input type="number" name="washrooms" value="<?= htmlentities($row['washrooms']) ?>"><br><br></label>
        <?php
        if ($row['furnished']==1){
        echo 'Fully Furnished : <br><label><input type="radio" name="furnished" value="1" checked="checked">Yes</label>';
        echo '<label><input type="radio" name="furnished" value="0">No<br><br></label>';
      }
      else{
        echo 'Fully Furnished : <br><label><input type="radio" name="furnished" value="1">Yes</label';
        echo '<label><input type="radio" name="furnished" value="0" checked="checked">No<br><br></label>';
      }
      if ($row['ac']==1){
      echo 'Air Conditioned : <br><label><input type="radio" name="ac" value="1" checked="checked">Yes</label>';
      echo '<label><input type="radio" name="ac" value="0">No<br><br></label>';
    }
    else{
      echo 'Air Conditioned : <br><label><input type="radio" name="ac" value="1">Yes</label>';
      echo '<label><input type="radio" name="ac" value="0" checked="checked">No<br><br></label>';
    }
    if ($row['power']==1){
    echo 'Power Backup : <br><label><input type="radio" name="Power" value="1" checked="checked">Yes</label>';
    echo '<label><input type="radio" name="Power" value="0">No<br><br></label>';
  }
  else{
    echo 'Power Backup : <br><label><input type="radio" name="Power" value="1">Yes</label>';
    echo '<label><input type="radio" name="Power" value="0" checked="checked">No<br><br></label>';
  }
  if ($row['food']==1){
  echo 'Food Services : <label><br><input type="radio" name="Food" value="1" checked="checked">Yes</label>';
  echo '<label><input type="radio" name="Food" value="0">No<br><br></label>';
}
else{
  echo 'Food Services : <label><br><input type="radio" name="Food" value="1">Yes</label>';
  echo '<label><input type="radio" name="Food" value="0" checked="checked">No<br><br></label>';
}
if ($row['kitchen']==1){
echo 'With Kitchen : <label><br><input type="radio" name="kitchen" value="1" checked="checked">Yes</label>';
echo '<label><input type="radio" name="kitchen" value="0">No<br><br></label>';
}
else{
  echo 'With Kitchen : <label><br><input type="radio" name="kitchen" value="1">Yes</label>';
  echo '<label><input type="radio" name="kitchen" value="0" checked="checked">No<br><br></label>';
}
if ($row['gas']==1){
echo 'Gas Connection : <label><br><input type="radio" name="Gas" value="1" checked="checked">Yes</label>';
echo '<label><input type="radio" name="Gas" value="0">No<br><br></label>';
}
else{
  echo 'Gas Connection : <label><br><input type="radio" name="Gas" value="1">Yes</label>';
  echo '<label><input type="radio" name="Gas" value="0" checked="checked">No<br><br></label>';
}
if ($row['elec_meter']==1){
echo 'Separate electricity meter : <label><br><input type="radio" name="electricity_meter" value="1" checked="checked">Yes</label>';
echo '<label><input type="radio" name="electricity_meter" value="0">No<br><br></label>';
}
else{
  echo 'Separate electricity meter : <label><br><input type="radio" name="electricity_meter" value="1">Yes</label>';
  echo '<label><input type="radio" name="electricity_meter" value="0" checked="checked">No<br><br></label>';
}
if ($row['water_meter']==1){
  echo 'Separate water connection : <label><br><input type="radio" name="water_connection" value="1" checked="checked">Yes</label>';
  echo '<label><input type="radio" name="water_connection" value="0">No<br><br></label>';
}
else{
  echo 'Separate water connection : <label><br><input type="radio" name="water_connection" value="1">Yes</label>';
  echo '<label><input type="radio" name="water_connection" value="0" checked="checked">No<br><br></label>';
}
?>
        <label>Room Description : <br><textarea style="width:100%" name="room_description" rows="3" cols="50"><?= htmlentities($row['room_desc']) ?></textarea><br><br></label>
        <label>Rent per Month (in INR) : <br><input type="Number" name="rent" value="<?= htmlentities($row['rent']) ?>"><br><br></label>
        <input style="margin-right: 5px" class="fed" type="submit" name="submit" value="Submit" style="width:170px;"/>
        <input style="margin-right: 5px" class="fed" type="submit" name="cancel" value="cancel" style="width:170px;"/>
    </form>
    <div>
</body>
</html>
