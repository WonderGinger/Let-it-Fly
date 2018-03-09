<?php
echo <<<_END

    <div class="row">
    <div class="col s12 m6 offset-m3">
      <div class="card blue-grey darken-1">
        <div class="card-content white-text">
          <span class="card-title">Login</span>
          <form id="login" method="POST" enctype="multipart/form-data">
            <input type="text" name="username" placeholder="email"><br/>
            <input type="password" name="password" placeholder="password">
            <input class="white-text btn waves-effect" type="submit" name="submit" value="submit">
          </form>
        </div>
      </div>
    </div>
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