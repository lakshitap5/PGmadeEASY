<?php
//session_start();
//session_destroy();
session_start();
require_once "other.php";
require_once "pdo.php";
unset($_SESSION['ten']);
unset($_SESSION['flag']);
unset($_SESSION['outfind']);
unset($_SESSION['search1']);
unset($_SESSION['landlord_id']);
unset($_SESSION['tenant_id']);
if ( isset($_POST['landlord_submit']) || isset($_POST['tenant_submit'])) {
  if (isset($_POST['landlord_submit'])){
    $land = landlord_duplicate($pdo,$_POST['email']);
    if (is_string($land)){
      $_SESSION['error'] = $land;
      header("Location: register.php");
      return;
    }
  }
  else if (isset($_POST['tenant_submit'])){
    $ten = tenant_duplicate($pdo,$_POST['email']);
    if (is_string($ten)){
      $_SESSION['error'] = $ten;
      header("Location: register.php");
      return;
    }
  }
    $msg = validate_register();
    if (is_string($msg)){
      $_SESSION['error'] = $msg;
      header("Location: register.php");
      return;
    }

else {
        $salt="abc123";
        $check = hash('md5', $salt.$_POST['password']);
        if (isset($_POST['landlord_submit'])){
          $stmt = $pdo->prepare('INSERT INTO landlord (first_name, last_name, email, password)
           VALUES (:fn, :ln, :em, :pwd)');
          $stmt->execute(array(
           ':fn' => $_POST['first_name'],
           ':ln' => $_POST['last_name'],
           ':em' => $_POST['email'],
           ':pwd' => $_POST['password']));
          $_SESSION['success'] = "Your Account has been created Successfully";
          header("Location: index.php");
          return;
        }
        else if (isset($_POST['tenant_submit'])){
          $stmt = $pdo->prepare('INSERT INTO tenant (first_name, last_name, email, password)
           VALUES (:fn, :ln, :em, :pwd)');
          $stmt->execute(array(
           ':fn' => $_POST['first_name'],
           ':ln' => $_POST['last_name'],
           ':em' => $_POST['email'],
           ':pwd' => $_POST['password']));
           $_SESSION['success'] = "Your Account has been created Successfully";
           header("Location: index.php");
           return;
        }
    }
}

?>
<Doctype html>
<html>
<head>
  <meta charset="utf-8" lang="en"/>
  <title>Sign Up</title>
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
  <div style="margin:0 42% 0 40%;width:15%" class="login2">
  <h1 class="heading">SignUp</h1>
  <?php
  flashMessages();
  ?>

<form method="POST">
  <label for="fname">First Name</label><br>
  <input style="width:100%;" type="text" name="first_name" id="fname"><br/><br/>
  <label for="lname">Last Name</label><br>
  <input style="width:100%;" type="text" name="last_name" id="lname" size="37"><br/><br/>
  <label for="mail">Email</label><br>
  <input style="width:100%;" type="email" name="email" id="mail" size="37"><br/><br/>
  <label for="pwd">Password</label><br>
  <input style="width:100%;" type="password" name="password" id="pwd" size="37"><br/><br/>
  <label for="pwdcheck">Confirm Password</label><br>
  <input style="width:100%;" type="password" name="pass_check" id="pwdcheck" size="37"><br/><br/>
  <input style="width:100%; margin-right: 5px" class="fed" type="submit" name="landlord_submit" value="SignUp as Landlord"/>
  <input style="width:100%; margin-right: 5px" class="fed" type="submit" name="tenant_submit" value="SignUp as Tenant"/>
  <input style="width:100%; margin-right: 5px" class="fed" type="button" onclick="location.href='index.php';" value="Cancel"/>
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
