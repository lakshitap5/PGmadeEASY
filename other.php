<?php
// other.php
function flashMessages() {
    if ( isset($_SESSION['error']) ) {
        echo('<p style="margin-top:5%;color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
    if ( isset($_SESSION['success']) ) {
        echo '<p style="margin-top:5%;color:white;text-align:center;font-size:25px">'.htmlentities($_SESSION['success'])."</p>\n";
        unset($_SESSION['success']);
    }
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function validate_register() {
  if ( strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1 || strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['pass_check']) < 1 ) {
      return "All fields are required";
  }
  else if ( is_numeric($_POST['first_name']) || is_numeric($_POST['last_name']) ){
          return "Name cannot be numeric";
  }
  else if (preg_match('/[^a-zA-Z]+/', $_POST['first_name'].$_POST['last_name'])){
          return "Name cannot contain any special characters";
  }
else if ( strpos($_POST['email'],'@')==false ){
      return "Email must have an at-sign (@)";
}
else if ( ($_POST['password']) != ($_POST['pass_check'])){
      return "Passwords not matched : Please Confirm your password again";
}
$email = test_input($_POST['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  return "Invalid email format";
}
    return true;
}

function validateProfile(){
  if ( strlen($_POST['age']) < 1 || strlen($_POST['phone']) < 1 || strlen($_POST['address']) < 1 || $_POST['status'] < 1 ) {
      return "All fields are required";
  }
  else if ( !is_numeric($_POST['age']) ){
          return "Age should be numeric";
  }
  else if (!is_numeric($_POST['phone']) ){
          return "Mobile Number should be numeric";
  }
  else if (strlen($_POST['phone'])!=10){
          return "Invalid Mobile Number";
  }
  else if (strlen($_POST['address'])>500){
          return "500 letters limit exceeded";
  }
    return true;
}

function validatelProfile(){
  if ( strlen($_POST['age']) < 1 || strlen($_POST['phone']) < 1 || strlen($_POST['address']) < 1) {
      return "All fields are required";
  }
  else if ( !is_numeric($_POST['age']) ){
          return "Age should be numeric";
  }
  else if (!is_numeric($_POST['phone']) ){
          return "Mobile Number should be numeric";
  }
  else if (strlen($_POST['phone'])!=10){
          return "Invalid Mobile Number";
  }
  else if (strlen($_POST['address'])>500){
          return "500 letters limit exceeded";
  }
    return true;
}

function validate_login(){
  if ( strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1 ) {
      return "Email and password are required";
  }
else if ( strpos($_POST['email'],'@')==false ){
      return "Email must have an at-sign (@)";
}
$email = test_input($_POST['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  return "Invalid email format";
}
return true;
}


function landlord_duplicate($pdo, $email) {
  $stmt = $pdo->prepare('SELECT * FROM landlord
     WHERE email = :em ');
  $stmt->execute(array( ':em' => $email)) ;
  $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if ($row != false){
    return "Email already exists - Please Login or signup using another email";
  }
  return true;
}
function tenant_duplicate($pdo, $email) {
  $stmt = $pdo->prepare('SELECT * FROM tenant
     WHERE email = :em ');
  $stmt->execute(array( ':em' => $email)) ;
  $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if ($row != false){
    return "Email already exists - Please Login or signup using another email";
  }
  return true;
}

function validateroom(){
  if (!isset($_POST['boys'])){
    $_POST['boys'] = 0;
  }
  if (!isset($_POST['girls'])){
    $_POST['girls'] = 0;
  }
  if (!isset($_POST['family'])){
    $_POST['family'] = 0;
  }
  if ( strlen($_POST['City']) < 1 || strlen($_POST['Address']) < 1 || strlen($_POST['rooms']) < 1 || strlen($_POST['capacity']) < 1 || strlen($_POST['washrooms']) < 1) {
      return "All fields are required";
  }
  if ( strlen($_POST['room_description']) < 1 || strlen($_POST['rent']) < 1 || strlen($_POST['pgtype']) < 1 || strlen($_POST['furnished']) < 1 || strlen($_POST['ac']) < 1  ) {
      return "All fields are required";
  }
  if ( strlen($_POST['Power']) < 1 || strlen($_POST['Food']) < 1 || strlen($_POST['kitchen']) < 1 || strlen($_POST['rname']) < 1) {
      return "All fields are required";
  }
  if ( strlen($_POST['water_connection']) < 1  || strlen($_POST['electricity_meter']) < 1 || strlen($_POST['Gas']) < 1) {
      return "All fields are required";
  }
  if ( $_POST['boys'] == 0 && $_POST['girls'] ==0 && $_POST['family'] == 0) {
      return "All fields are required";
  }
  else if ( is_numeric($_POST['City']) ){
          return "City cannot be numeric";
  }
  else if (!is_numeric($_POST['rooms']) ){
          return "Number of rooms should be numeric";
  }
  else if (!is_numeric($_POST['capacity']) ){
          return "Person Capacity should be numeric";
  }
  else if (!is_numeric($_POST['washrooms']) ){
          return "Number of washrooms should be numeric";
  }
  else if (!is_numeric($_POST['rent']) ){
          return "Rent should be numeric";
  }
  else if (strlen($_POST['Address'])>150){
          return "Address cannot be more than 150 letters";
  }
  else if (strlen($_POST['rname'])>30){
          return "Name cannot be more than 30 letters";
  }
  else if (strlen($_POST['room_description'])>400){
          return "Room Description cannot be more than 400 letters";
  }
  if ($_POST['washrooms']<0){
    return "Number of washrooms cannot be negative";
  }
  if ($_POST['rooms']<0){
    return "Number of rooms cannot be negative";
  }
  if ($_POST['rent']<0){
    return "Rent cannot be negative";
  }
  if ($_POST['capacity']<0){
    return "Number of Persons cannot be negative";
  }
    return true;
}

function validatePos() {
  for ($i=1; $i<=9; $i++) {
    if ( ! isset($_POST['year'.$i]) ) continue;
    if ( ! isset($_POST['desc'.$i]) ) continue;
    $year = $_POST['year'.$i];
    $desc = $_POST['desc'.$i];
    if ( strlen($year) == 0  || strlen($desc) == 0 ) {
        return "All fields are required";
    }
    if ( ! is_numeric($year) ) {
        return "Position year must be numeric";
    }

  }
  return true;
}
function validateEdu() {
  for ($i=1; $i<=9; $i++) {
    if ( ! isset($_POST['edu_year'.$i]) ) continue;
    if ( ! isset($_POST['edu_school'.$i]) ) continue;
    $eduyear = $_POST['edu_year'.$i];
    $eduschool = $_POST['edu_school'.$i];
    if ( strlen($eduyear) == 0  || strlen($eduschool) == 0 ) {
        return "All fields are required";
    }
    if ( ! is_numeric($eduyear) ) {
        return "Education year must be numeric";
    }

  }
  return true;
}


function loadPos($pdo, $profile_id) {
  $stmt = $pdo->prepare('SELECT * FROM position
     WHERE profile_id = :prof ORDER BY rank');
  $stmt->execute(array( ':prof' => $profile_id)) ;
  $positions = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $positions;
}

function loadEdu($pdo, $profile_id) {
  $stmt = $pdo->prepare('SELECT year,name FROM Education
    JOIN Institution
    ON Education.institution_id = Institution.institution_id
     WHERE profile_id = :prof ORDER BY rank');
  $stmt->execute(array( ':prof' => $profile_id)) ;
  $educations = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $educations;
}

function insertPositions($pdo, $profile_id) {
  $rank = 1;
  for($i = 1; $i<=9; $i++) {
     if ( ! isset($_POST['year'.$i]) ) continue;
     if ( ! isset($_POST['desc'.$i]) ) continue;
     $year = $_POST['year'.$i];
     $desc = $_POST['desc'.$i];

     $stmt = $pdo->prepare('INSERT INTO Position
        (profile_id, rank, year, description)
        VALUES ( :pid, :rank, :year, :desc)');
     $stmt->execute(array(
         ':pid' => $profile_id,
         ':rank' => $rank,
         ':year' => $year,
         ':desc' => $desc)
    );
    $rank++;
  }
}

function insertEducations($pdo, $profile_id) {
  $rank = 1;
  for($i = 1; $i<=9; $i++) {
     if ( ! isset($_POST['edu_year'.$i]) ) continue;
     if ( ! isset($_POST['edu_school'.$i]) ) continue;
     $year = $_POST['edu_year'.$i];
     $school = $_POST['edu_school'.$i];

     // Lookup the school if it is there.
     $institution_id = false;
     $stmt = $pdo->prepare('SELECT institution_id FROM
         institution WHERE name = :name');
     $stmt->execute(array(':name' => $school));
     $row = $stmt->fetch(PDO::FETCH_ASSOC);
     if ( $row !== false ) $institution_id = $row['institution_id'];

     // If there was no institution, insert it
     if ( $institution_id === false ) {
       $stmt = $pdo->prepare('INSERT INTO institution
           (name) VALUES (:name)');
       $stmt->execute(array(':name' => $school));
       $institution_id = $pdo->lastInsertId();
     }

     $stmt = $pdo->prepare('INSERT INTO Education
        (profile_id, rank, year, institution_id)
        VALUES ( :pid, :rank, :year, :iid)');
     $stmt->execute(array(
         ':pid' => $profile_id,
         ':rank' => $rank,
         ':year' => $year,
         ':iid' => $institution_id)
    );
    $rank++;
  }
}
