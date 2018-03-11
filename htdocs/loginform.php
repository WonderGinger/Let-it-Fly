<?php
echo <<<_END
<div class="row card blue-grey darken-1">
  <form class="col s12 card-content white-text" id="login" method="POST">
    <div class="card-title">Login</div>
    <div class="row">
      <div class="switch col s2 offset-s9">
          <label>
          Driver?
            <input type="checkbox">
            <span class="lever"></span>
          </label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="email" type="email" class="validate">
        <label for="email">Email</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="password" type="password" class="validate">
        <label for="password">Password</label>
      </div>
    </div>
    <div class="row">
      <button class="btn waves-effect waves-light" type="submit" name="action">Submit
          <i class="material-icons right">send</i>
      </button>
      <a class="white-text btn-flat waves-light" href="register.html">SIGN UP</a>
    </div>
  </form>
</div>
_END;

// require_once 'login.php';
// require_once 'utility.php';
/*
$connection = new mysqli($hn, $un, $pw, $db);
if($connection->connect_error) die($connection->connect_error);

if(!isset($_POST['submit'])) die("Invalid username/password combination");

if(empty($_POST['username']) || empty($_POST['password'])) {
    die("Please fill in both fields<br>");
}
$un_temp = mysql_entities_fix_string($connection, $_POST['username']);
$pw_temp = mysql_entities_fix_string($connection, $_POST['password']);
$query = "SELECT * FROM users WHERE username='$un_temp'";

$result = $connection->query($query);

if(!$result) die($connection->error);
elseif($result->num_rows){
    $row = $result->fetch_array(MYSQLI_NUM);
    $result->close();
    $salt1 = "p^1m)";
    $salt2= "%mga3";
    $token = hash('ripemd128', '$salt1$pw_temp$salt2');
    
    if($token == $row[3]){
        echo "$row[0] $row[1] : Hi $row[0], you are now logged in as '$row[2]'";
    }
    else die("Invalid username/password combination");
}
$connection->close();
*/
?>