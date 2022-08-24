<?php
require_once "pdo.php";
session_start();
if ( ! isset($_SESSION['landlord_id']) || ! isset($_REQUEST['id']) ) {
    die('Access Denied');
}
if (isset($_POST['room_id']) && isset($_POST['delete']))
{
    $stm = $pdo->prepare('DELETE from rooms where room_id = :r_id and landlord_id = :l_id');
    $stm->execute(array(
     ':l_id' => $_SESSION['landlord_id'],
   ':r_id' => $_REQUEST['id']));
  $_SESSION["success"]="Record Deleted Successfully";
  header('Location: index.php');
  return;
}
if (! isset($_REQUEST['id']))
{
  $_SESSION["error"]="Missing room id";
  header("location: index.php");
  return;
}
  $sql = "SELECT room_name, room_id FROM rooms where room_id = :r and landlord_id = :lid";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ":lid" => $_SESSION['landlord_id'],
    ":r"=>$_REQUEST['id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row == false)
  {
    $_SESSION["error"]="Bad Value for room id";
    header("Location: index.php");
    return;
  }

 ?>
<html>
<head>
<title>Delete Room </title>
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

  <div class="login2">
  <p> Confirm: Deleting <?= htmlentities($row['room_name']);?> <p>
    <form method="POST">
      <input type = "hidden" name = "room_id" value = "<?= htmlentities($row['room_id']) ?>">
    <input style="text-decoration:none; margin-right:5px" class="fed" type = "submit" name="delete" value = "Delete" style="width:88px;">
    <a style="text-decoration:none" class="fed" href="view_room.php">Cancel</a>
    </form>
  </div>
</body>
</html>
