<?php
require_once "pdo.php";
require_once "other.php";
session_start();
unset($_SESSION['ten']);
unset($_SESSION['flag']);
unset($_SESSION['outfind']);
unset($_SESSION['search1']);
unset($_SESSION['search']);
if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}
if ( isset($_POST['find']) && strlen($_POST['search'])>1) {
    $_SESSION['search'] = $_POST['search'];
    header('Location: view.php');
    return;
}
if ( isset($_POST['outfind']) && strlen($_POST['without'])>1) {
    $_SESSION['outfind'] = $_POST['without'];
    header('Location: view.php');
    return;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Index</title>
<link rel="stylesheet" href="pg.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php
flashmessages();
if ( isset($_SESSION["landlord_id"]) ) {
  $name = $_SESSION["landlord_id"];
  $sql = "Select first_name from landlord where landlord_id = $name";
  $stmt = $pdo->query($sql);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $sq = "Select age from landlord_profile where landlord_id = $name";
  $stm = $pdo->query($sq);
  $ro = $stm->fetch(PDO::FETCH_ASSOC);
  if ($ro){
    echo '<ul>';
    echo '<li><a class="shazam" href="l_profile.php">Edit Profile</a></li>';
    echo '<li><a class="shazam" href="add_room.php">Add Rooms</a></li>';
    echo '<li><a class="shazam" href="view_room.php">Your Rooms</a></li>';
    echo '<li style="float:right"><a class="shazam" href="logout.php">Logout</a></li>';
    echo '<li style="float:right"><div class="active" >';
    echo "Welcome ".$row['first_name'];
    echo '</div></li>';
    echo '</ul>';
    echo '<div style="margin-left:32.5%; width:30%" class="whole"><p class="para">Your Requests for your Rooms';
    $s = "Select * from requests where landlord_id = $name";
    $count = 1;
    $st = $pdo->query($s);
    while($rowww = $st->fetch(PDO::FETCH_ASSOC))
    {
      echo '<div class="hah">';
      echo $count++ .")  " ;
      echo "Name: ".$rowww['room']."\t";
      echo '<br><a class="shazam1" href="notify.php?id='.$rowww['tenant_id'].'">View Details</a>';
      echo '</div>';
      echo "<br>";
    }
    echo '</div>';
  }
  else{
  echo '<ul>';
  echo '<li><a class="shazam" href="l_profile.php">Complete Profile</a></li>';
  echo '<li style="float:right"><a class="shazam" href="logout.php">Logout</a></li>';
  echo '<li style="float:right"><div class="active" >';
  echo "Welcome ".$row['first_name'];
  echo '</div></li>';
  echo '</ul>';
  echo '<div class="container" style="margin-top:150px;">';
  echo '<img src="1.png" alt="PGmadeEASY: Turning dreams into reality" class="image">';
  echo '<div class="overlay">';
  echo '<div class="text">Complete Profile to Proceed Further';
  echo '</div>';
  echo '</div>';
  echo '</div>';

  }
}
else if ( isset($_SESSION["tenant_id"]) ) {

  $name = $_SESSION["tenant_id"];
  $sql = "Select first_name from tenant where tenant_id = $name";
  $stmt = $pdo->query($sql);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  //echo "Welcome ".$row['first_name'];
  $sq = "Select age from tenant_profile where tenant_id = $name";
  $stm = $pdo->query($sq);
  $ro = $stm->fetch(PDO::FETCH_ASSOC);
  if ($ro){

    echo '<ul>';
    echo '<li><a class="shazam" href="t_profile.php">Edit Profile</a></li>';
    echo '<li style="float:right"><a class="shazam" href="logout.php">Logout</a></li>';
    echo '<li style="float:right"><div class="active" >';
    echo "Welcome ".$row['first_name'];
    echo '</li>';
    echo '</ul>';
    echo '</div>';

    echo '<form method="POST"><div style="margin-left:34%;width:30%" class="wrap1"><div class="search"><input type="text" name="search" class="searchTerm" placeholder="Enter City" ><button type="submit" name="find" value="Search" class="searchButton"> <i class="fa fa-search"></i></button></div></div></form>';
//    echo '<p><a href="t_profile.php">Edit Profile</a></p>';

    echo '<div class="whole" style="margin-left:32.5%; width:30%"><p class="para">Your Requests Status:';
    $ss = "Select * from requests where tenant_id = $name";
    $count = 1;
    $stt = $pdo->query($ss);
    while($rowwww = $stt->fetch(PDO::FETCH_ASSOC))
    {
      echo '<div class="hah">';
      echo $count++ .")  " ;
      echo "Name: ".$rowwww['room']."\t";
      if ($rowwww['accept']==1){
        echo '<br><span class="spa" > Status:<strong style="color:green"> Request Accepted </strong> </span> ';
        echo '<br><a style="margin:10px" class="shazam1" href="viewlandlord.php?id='.$rowwww['landlord_id'].'">View Details</a>';
      }
      else if ($rowwww['decline']==1){
        echo '<br><span class="spa">Status:<strong style="color:red"> Request Declined</strong></span>';
      }
      else{
          echo '<br><span class="spa">Status: Pending</span>';
      }
      echo '</div>';
      echo "<br>";
    }
    echo '</div>';
  }
  else{

    echo '<ul>';
    echo '<li><a class="shazam" href="t_profile.php">Complete Profile</a></li>';
    echo '<li style="float:right"><a class="shazam" href="logout.php">Logout</a></li>';
    echo '<li style="float:right"><div class="active" >';
    echo "Welcome ".$row['first_name'];
    echo '</div></li>';
    echo '</ul>';
    echo '<div class="container" style="margin-top:150px;">';
    echo '<img src="1.png" alt="PGmadeEASY: Turning dreams into reality" class="image">';
    echo '<div class="overlay">';
    echo '<div class="text">Complete Profile to Proceed Further';
    echo '</div>';
    echo '</div>';
    echo '</div>';

  }
}
else if ( isset($_SESSION["admin_id"]) ) {
  $name = $_SESSION["admin_id"];
  $sql = "Select first_name from admin where admin_id = $name";
  $stmt = $pdo->query($sql);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  echo "Welcome ".$row['first_name'];
  echo '<p><a href="logout.php">Logout</a></p>';
}
else {
  echo '<div style="width:60%" class="container">';
  echo '<img src="1.png" alt="PGmadeEASY: Turning dreams into reality" class="image">';
  echo '<div class="overlay">';
  echo '<div class="text">Welcome to the PG Booking System';
  echo '</div>';
  echo '</div>';
  echo '</div>';
  echo '<div class=sas>';
  //view without Login
  echo '<form method="POST"><div style="margin-left:22%;width:30%" class="wrap"><div class="search"><input type="text" name="without" class="searchTerm" placeholder="Enter City" ><button type="submit" name="outfind" value="Search" class="searchButton"> <i class="fa fa-search"></i></button></div></div></form>';
  //end
  echo '</div >';
  echo  '<div style="margin-left:30%;width:60%">';
  echo '<p><a style="margin:2%" class="fox" href="login.php" class="login">Existing User? log in</a></p>';
  echo '<p><a style="margin:2%" class="fox" href="register.php" class="register">New User? Register</a></p>';
 echo  '</div>';
}
 ?>

 <div class='ripple-background'>
   <div class='circle xxlarge shade1'></div>
   <div class='circle xlarge shade2'></div>
   <div class='circle large shade3'></div>
   <div class='circle mediun shade4'></div>
   <div class='circle small shade5'></div>
 </div>


</body>
