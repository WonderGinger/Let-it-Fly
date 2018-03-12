<?php
echo <<<_END
<!-- Login card -->
<div class="row card blue-grey darken-1">

  <!-- Main form area: 1 column padding on left and right -->
  <form class="col s10 offset-s1 card-content white-text" id="login" method="POST">
    <div class="card-title">Login</div>
    
    <!-- Rider login switch -->
    <div class="row">
      <div class="switch col s2 offset-s9">
          <label>
          Driver?
            <input type="checkbox">
            <span class="lever"></span>
          </label>
      </div>
    </div>

    <!-- Email field -->
    <div class="row">
      <div class="input-field col s12">
        <input id="email" name="email" type="email" class="validate">
        <label for="email">Email</label>
      </div>
    </div>

    <!-- Password field -->
    <div class="row">
      <div class="input-field col s12">
        <input id="password" name="password" type="password" class="validate">
        <label for="password">Password</label>
      </div>
    </div>

    <!-- Submit button and Sign up link -->
    <div class="row">
      <button class="btn waves-effect waves-light" type="submit" id="submit" name="submit">Submit
          <i class="material-icons right">send</i>
      </button>
      <a class="white-text btn-flat waves-light" href="register.html">SIGN UP</a>
    </div>
  </form>
</div>
_END;


/* USAGE: 
 *  Currently a test version of the code using
 *  only my local test server with a test table.
 *  This can be adapter once the backend is officially created.
 *    Additionally, some of this validation should be done in JavaScript 
 *    rather than using php's die function.
 */
require_once 'db_login.php';
require_once 'utility.php';

$connection = new mysqli($hn, $un, $pw, $db);
if($connection->connect_error) die($connection->connect_error);

if(!isset($_POST['submit'])) die("Invalid username/password combination");
if(empty($_POST['email']) || empty($_POST['password'])) {
    die("Please fill in both fields<br>");
}
$email_temp = mysql_entities_fix_string($connection, $_POST['email']);
$pw_temp = mysql_entities_fix_string($connection, $_POST['password']);
$query = "SELECT * FROM rider WHERE email='$email_temp'";

$result = $connection->query($query);

if(!$result) die($connection->error);
elseif($result->num_rows){
    $row = $result->fetch_array(MYSQLI_NUM);
    $result->close();
    $salt1 = "p^1m)";
    $salt2= "%mga3";
    $token = hash('ripemd128', '$salt1$pw_temp$salt2');
    if($token == $row[2]){
        echo "Hi $row[1], you are now logged in'";
    }
    else die("Invalid username/password combination");
}
else die("Invalid username/password combination");
$connection->close();

?>