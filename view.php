<?php
require_once 'pdo.php';
session_start();
if(!isset($_SESSION['outfind']) && !isset($_SESSION['search'])){
  die('Access Denied');
}
if ( isset($_POST['find']) && strlen($_POST['search'])>1 && isset($_SESSION['outfind'])) {
    $_SESSION['search1'] = $_POST['search'];
    header('Location: view.php');
    return;
}
else if (isset($_POST['find']) && strlen($_POST['search'])>1){
  $_SESSION['search'] = $_POST['search'];
  header('Location: view.php');
  return;
}
if (isset($_SESSION['search'])){
  $search = $_SESSION['search'];
}
else if (isset($_SESSION['search1'])){
  $search = $_SESSION['search1'];
}
else {
  $search = $_SESSION['outfind'];
}
if ( isset($_POST['back'])) {
    header('Location: index.php');
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>View Rooms</title>
<meta charset="utf-8" lang="en"/>
    <link rel="stylesheet" href="pg.css">
    <title>
        View Rooms
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      .addroom{
        margin-left:5%;
        text-align:left;
        border: none;
        width:28.5%;
        margin-top: 30px;
      }
      .notbold{
        font-weight:normal;
      }
      li{
        list-style-type:none;
      }
      .shazam1{
        font-size:100%;
        border-width:4px;
        border-color:#D3D3D3;
      }

      .bigbox{
        clear:both;
        background-image:linear-gradient(#D3D3D3,#e7e3e3);
        padding:5px;
        border-style:solid;
        border-width:1px;
        border-color:grey;
        margin-bottom:20px;
      }
      .box{
        float:right;
      }
      .box2{
        float:left;
      }
      .rest{
      clear:both;
      }
       .box3{
        margin-bottom:50px;
      }

.back2
{
 background-color:rgb(50, 171, 192);
 padding:2px 8px;
 color:whitesmoke;
 border-style: solid;
 border-width:  1px;
 border-color:white;
 border-radius:5px;
}

    </style>
</head>
<body>
<form method="POST">
<div style="margin-left:27% ;margin-top:120px;width:100%">
<div style="margin-left:22.5%" class="wrap">
  <div class="search">
  <input type="text" name="search" class="searchTerm" value="<?= $search ?>" >
  <button type="submit" name="find" value="Search" class="searchButton">
  <i class="fa fa-search"></i></button>
  <input type="submit" class="back2" name="back" value="Back"/>
</div>
</div>
</form>
<div class="addroom">
<?php
if (isset($_SESSION['search'])){
echo '<h2>Showing all rooms Located in '.$_SESSION['search']."</h2><br>";
$name = $_SESSION['search'];
$sql = "Select * from rooms where city = '$name' order by rent ";
$count = 1;
$stmt = $pdo->query($sql);
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
  echo '<div class="bigbox">';
    echo '<div class="box2">';
      echo '<h3>'. $count++ .".  " . "Name: ";
      echo $row['room_name'];
      echo '</h3>';
    echo '</div>';
    echo '<div class ="box">';
      echo '<h3>';
      echo "Rent: Rs.";
      echo $row['rent'];
      echo '</h3>';
    echo '</div>';
    echo '<div class="rest">';
      echo '<h3 class="notbold">';
      //echo '<span class="tab2"></span>';
      echo $row['address'];
      echo '</h3>';
    echo '</div>';
    echo '<div class="box3">';
      echo '<li style="float:right"><a class="shazam1" href="viewdetails.php?id='.$row['room_id'].'">View Details</a></li>';
    echo '</div>';
    //Secho $row['landlord_id']."\t";
    echo "<br>";
  echo '</div>';
  }
    echo '<ul>';
    echo '<li><a class="shazam" href="index.php">Back</a></li>';
    echo '<li style="float:right"><a class="shazam" href="logout.php">Logout</a></li>';
    echo '</ul>';
  echo'<br>';

}
else {
  echo '<h2>Showing all rooms Located in '.$search."</h2><br>";
  $sql = "Select * from rooms where city = '$search' order by rent ";
  $count = 1;
  $stmt = $pdo->query($sql);
  while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  {
    echo '<div class="bigbox">';
    echo '<div class="box2">';
      echo '<h3>'. $count++ .".  " . "Name: ";
      echo $row['room_name'];
      echo '</h3>';
    echo '</div>';
    echo '<div class ="box">';
      echo '<h3>';
      echo "Rent: Rs.";
      echo $row['rent'];
      echo '</h3>';
    echo '</div>';
    echo '<div class="rest">';
      echo '<h3 class="notbold">';
      //echo '<span class="tab2"></span>';
      echo $row['address'];
      echo '</h3>';
    echo '</div>';
    //Secho $row['landlord_id']."\t";
    echo "<br>";
  echo '</div>';
  }
    echo '<ul>';
    echo '<li><a class="shazam" href="index.php">Back</a></li>';
    echo '<li style="float:right"><a class="shazam" href="login.php">Login</a></li>';
    echo '</ul>';
  echo'<br>';

  }
?>
</div>
</div>
<div class='ripple-background'>
<div class='circle xxlarge shade1'></div>
<div class='circle xlarge shade2'></div>
<div class='circle large shade3'></div>
<div class='circle mediun shade4'></div>
<div class='circle small shade5'></div>
</div>
</html>
</body>
</html>
