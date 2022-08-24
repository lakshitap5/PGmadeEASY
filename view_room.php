<?php
session_start();
if ( !isset($_SESSION['landlord_id']) ) {
    die('Access Denied');
}
 ?>
<!Doctype html>
<html>
<head>
  <meta charset="utf-8" lang="en"/>
    <link rel="stylesheet" href="pg.css">
    <title>
        Your Room List
    </title>
    <style>
      .addroom{
        margin-left:18%;
      }


table {
  width: 100%;
  border-collapse: collapse;
  margin-left: 0px;
}

td,th {
  height: 25px;
  width: 22%;
  text-align: left;
}

th
{
  background-color:rgb(71, 66, 66);
  color: rgb(240, 231, 231);
}

h1{
  text-align: left;
  margin-left: 25px;
}

.addroom{
  margin-top:120px;
  text-align:center;
  border: none;
}


.shazam1{
  border: none;
  text-decoration: none;
  background-color:rgb(255,255,255,0.5);
  color:#000000;
  font-size:80%;
  padding:8px;
  margin-right:2px;
  display: inline-block;
  margin-top: 5px;
  margin-bottom: 5px;
}

.shazam1{
  background-image: linear-gradient(rgb(87, 86, 86),#333);
  color: white;
}

.shazam1:hover{
  background-color:#FFFFFFFF;
  color:#2f84e6;
}

.back
{
 background-image: linear-gradient(rgb(87, 86, 86),#333);

}


form
{
  margin-left:36%;
  margin-top:10%;
}


    </style>
</head>
<body>
<div style="width:57%" class="addroom">
<?php
//session_start();
require_once 'pdo.php';
echo '<h1>Your Room List</h1>';
echo "<br>";
if ( isset($_SESSION["landlord_id"]) )
{
  echo '<table>';
  $lid = $_SESSION["landlord_id"];
  $sql = "Select city, room_name , room_id from rooms where landlord_id = $lid order by rent ";
  $stmt = $pdo->query($sql);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $count = 1;
  if ($row)
  {
  //echo "<table border = 1>";
  echo "<tr><th><b>S.No</b></th><th><b> Room Name</b></th><th><b>City</b></th><th><b>Action</b></th></tr>\n";
  echo "<tr><td>". $count++.'</td><td>'.htmlentities($row['room_name']).'</td><td>'.htmlentities($row['city']).'</td><td>';
  echo "<a class='shazam1' href='edit_room.php?id=".$row['room_id']."'>Edit Room</a>  \n";
  echo "<a class='shazam1' href='delete.php?id=".$row['room_id']."'>Delete</a></td></tr>\n";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC))
  {
    echo "<tr><td>". $count++.'</td><td>'.htmlentities($row['room_name']).'</td><td>'.htmlentities($row['city']).'</td><td>';
    echo "<a class='shazam1' href='edit_room.php?id=".$row['room_id']."'>Edit Room</a>  \n";
    echo "<a class='shazam1' href='delete.php?id=".$row['room_id']."'>Delete</a></td></tr>\n";
  }
  echo '</div>';
  echo "</table>";
  }
  else
  {
    echo "No rows found\n"; }
    echo '<ul>';
    echo '<li><a class="shazam" href="add_room.php">Add New Rooms</a></li>';
    echo '<li style="float:right"><a class="shazam" href="logout.php">Logout</a></li>';
    echo '</ul>';
    echo'<br>';
    echo '<a style="width:100px;float:right;" class="shazam1" href="index.php">Back</a>';
    echo "<br>";
  }
?>

<!-- <div class="back">
<input type="button" style="float:right" onclick="window.location='index.php'" class="Redirect" value="Back"/>
</div>-->
<br>
<br>
<div class='ripple-background'>
<div class='circle xxlarge shade1'></div>
<div class='circle xlarge shade2'></div>
<div class='circle large shade3'></div>
<div class='circle mediun shade4'></div>
<div class='circle small shade5'></div>
</div>
</body>
</html>
