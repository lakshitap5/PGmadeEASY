<?php
session_start();
require_once 'pdo.php';
require_once 'other.php';
if(!isset($_SESSION['admin_id'])){
  die('Access Denied');
}
flashmessages();
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 <title>Admin </title>
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


<div style="width:100%" class="tab">
   <?php
   echo '<ul>';
   echo '<li style="float:right"><a class="shazam" href="logout.php">Logout</a></li>';
   echo '<li style="float:right"><div class="active" >';
   echo "Welcome Admin";
   echo '</li>';
   echo '</ul>';
   echo '</div>';
   $count = 1;
   $accept = 0;
   $decline = 0;
   $pending = 0;
   $sql = 'SELECT requests.accept, requests.decline , landlord.first_name as first , landlord.last_name as last, tenant.first_name , tenant.last_name FROM requests JOIN landlord JOIN tenant on requests.landlord_id = landlord.landlord_id and requests.tenant_id = tenant.tenant_id';
   $stmt = $pdo->query($sql);
   echo '<div style="background:white;margin-left:20%;width:60%">';
   echo '<h1 style="margin-left:43%" class="tah">Reports</h1>';
   echo "<table style='width:93%'>";
   echo "<tr><th><b>S.No</b></th><th><b>Landlord Name</b></th><th><b>Tenant Name</b></th><th><b>Status</b></th></tr>\n";
   while($row = $stmt->fetch(PDO::FETCH_ASSOC))
   {
     if ($row['accept']==1 && $row['decline'] ==0)
     {  $print = "Accepted";
        $accept++;}
     else if ($row['accept']==0 && $row['decline'] ==1)
     {  $print = "Declined";
        $decline++;}
     if ($row['accept']== NULL && $row['decline'] == NULL)
     {  $print = "Pending";
        $pending++;}
     echo "<tr><td>". $count++.'</td><td>'.htmlentities($row['first']).' '.htmlentities($row['last']).'</td><td>'.htmlentities($row['first_name']).' '.htmlentities($row['last_name']).'</td><td>';
     echo $print."</td></tr>\n";
   }
   echo "</table>";
   echo '<div class="mark">';
   echo "<br><br><marquee bgcolor='black' style='color:white; font-size:20px;width: 92%;margin-left: 4%;'>Number of Requests Accepted = ".$accept;
   echo "  |  Number of Requests Declined = ".$decline;
   echo "  |  Number of Requests Pending = ".$pending;
   echo '</marquee></div><br>';
   echo '</div>';

    ?>

</div>

 </body>
 </html>
