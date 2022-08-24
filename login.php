<?php
//session_start();
//session_destroy();
session_start();
require_once "other.php";
require_once "pdo.php";

if ( isset($_POST['cancel'] ) ) {
    header("Location: index.php");
    return;
}

if ( isset($_POST['log'])) {
  $login_as = isset($_POST["login_as"]) ? $_POST['login_as']+0 : -1;
  //echo $login_as;
  if ( $login_as == -1 ) {
      $_SESSION['error'] = "Please select login as type";
      header("Location: login.php");
      return;
  }
  $msg = validate_login();
  if (is_string($msg)){
    $_SESSION['error'] = $msg;
    header("Location: login.php");
    return;
  }
 else {
        $salt="abc123";
        $check = hash('md5',$salt.$_POST['password']);
        if ($login_as == 0){
          unset($_SESSION["name"]);
          unset($_SESSION["landlord_id"]);
        $sql = "Select landlord_id,first_name from landlord where email = :em and password = :pw";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
          ':em'=> $_POST['email'],
          ':pw'=> $_POST['password']
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row !== false)
        {
          $_SESSION['name'] = $row['first_name'];
          $_SESSION['landlord_id'] = $row['landlord_id'];
          $_SESSION["success"] = "Logged In Successfully";
          header('location: index.php');
          return;
        }
        $_SESSION["error"] = "Incorrect Password or Email";
        header("Location: login.php");
        return;
    }
    else if ($login_as == 1){
      unset($_SESSION["name"]);
      unset($_SESSION["tenant_id"]);
    $sql = "Select tenant_id,first_name from tenant where email = :em and password = :pw";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':em'=> $_POST['email'],
      ':pw'=> $_POST['password']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row !== false)
    {
      $_SESSION['name'] = $row['first_name'];
      $_SESSION['tenant_id'] = $row['tenant_id'];
      $_SESSION["success"] = "Logged In Successfully";
      header('location: index.php');
      return;
    }
    $_SESSION["error"] = "Incorrect Password or Email";
    header("Location: login.php");
    return;
}
else if ($login_as == 2){
  unset($_SESSION["name"]);
  unset($_SESSION["admin_id"]);
$sql = "Select admin_id,first_name from admin where email = :em and password = :pw";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
  ':em'=> $_POST['email'],
  ':pw'=> $_POST['password']
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row !== false)
{
  $_SESSION['name'] = $row['first_name'];
  $_SESSION['admin_id'] = $row['admin_id'];
  $_SESSION["success"] = "Logged In Successfully";
  header('location: admin.php');
  return;
}
$_SESSION["error"] = "Incorrect Password or Email";
header("Location: login.php");
return;
}
  }
    return;
}

?>

<DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="pg.css">
</head>
<body>
  <div style="width:60%;" class="container">
  <img src="1.png" alt="PGmadeEASY: Turning dreams into reality" class="image">
  <div class="overlay">
  <div class="text">Welcome to the PG Booking System
  </div>
  </div>
  </div>
  <div style="margin:0 50% 0 42%;width:13%" class="login2">
<h1 class ="heading">Login</h1>
<?php
flashmessages();
 ?>
<form method="post">
<label for="type">Login as: </label>
<br>
<select name="login_as" id="type" style="width:100%;">
<option value="-1">Select</option>
<option value="0">Landlord</option>
<option value="1">Tenant</option>
<option value="2">Admin</option>
</select><br/><br/>
<label for="name">Email</label>
<br>
<input style="width:100%;" type="text" name="email" id="name"><br/><br>

<label for="id_1">Password</label>
<br>
<input style="width:100%;" type="password" name="password" id="id_1"><br/><br>
<input style="margin-right: 5px" class="fed" type="submit" name="log" value="Log In">
<input style="margin-right: 5px" class="fed" type="submit" name="cancel" value="Cancel"><br><br>
</form>
</div>

  <div class='ripple-background'>
    <div class='circle xxlarge shade1'></div>
    <div class='circle xlarge shade2'></div>
    <div class='circle large shade3'></div>
    <div class='circle mediun shade4'></div>
    <div class='circle small shade5'></div>
  </div>


</body>
</html>
