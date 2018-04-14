<?php
$ini = parse_ini_file("let-it-fly.ini");
if (!$dbh = mysqli_connect($ini["host"], $ini["username"], $ini["passwd"], $ini["dbname"])) db_error();

function db_error() {
  header("location: /db-error");
  exit();
}

function mysqli_true_escape_string($link, $escapestr) {
  if (get_magic_quotes_gpc()) $escapestr = stripslashes($escapestr);
  return htmlentities($link->real_escape_string($escapestr));
}

function push_route($data) {
  global $dbh;

  $email = mysqli_true_escape_string($dbh, $_SESSION['email']);
  $user_type = $_SESSION['user'];
  if(isset($data['current_location']['lat']) && $data['current_location']['lng']){
    $result = $dbh->query("UPDATE {$user_type} SET latitude={$data['current_location']['lat']}, longitude={$data['current_location']['lng']} WHERE email='{$email}'");
  }

  $result = $dbh->query("SELECT * FROM {$user_type} WHERE email='{$email}'");
  $srows = $result->fetch_array(MYSQLI_ASSOC);
  $user_id = $srows['id'];

  $user_type_singular = substr($user_type, 0, -1);
  $result = $dbh->query("DELETE FROM {$user_type_singular}_routes WHERE {$user_type_singular}={$user_id}");
  
  $route_data = $dbh->real_escape_string($data['route']);
  $result = $dbh->query("INSERT INTO {$user_type_singular}_routes VALUES ({$user_id},'{$route_data}')");
}

function get_routes() {
  global $dbh;
  $ret = array();

  $result = $dbh->query("SELECT email, rider, route FROM rider_routes, riders WHERE id=rider");
  $srows = $result?$result->fetch_all(MYSQLI_ASSOC):array();
  $ret['riders'] = $srows;

  $result = $dbh->query("SELECT email, driver, route FROM driver_routes, drivers WHERE id=driver");
  $srows = $result?$result->fetch_all(MYSQLI_ASSOC):array();
  $ret['drivers'] = $srows;
  return $ret;
}

?>