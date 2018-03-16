<?php
$user_checkbox = NULL;


/* USAGE: 
 *  Currently a test version of the code using
 *  only my local test server with a test table.
 *  This can be adapter once the backend is officially created.
 *    Additionally, some of this validation should be done in JavaScript 
 *    rather than using php's die function.
 */
require_once 'utility.php';

$ini = parse_ini_file("../private/let-it-fly.ini");
$link = mysqli_connect($ini["host"], $ini["user"], $ini["pass"], $ini["dbname"]);
if (!$link) {
  // DISPLAY SERVER ERROR PAGE
  header("Location: http://www.sjsu.edu/");
  exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $user = empty($_POST["checkbox"]) ? "riders" : "drivers";
  $email = mysql_entities_fix_string($link, $_POST["email"]);
  $password = mysql_entities_fix_string($link, $_POST["password"]);

  $password = password_hash($password, PASSWORD_DEFAULT);
  mysqli_query($link, "SELECT * FROM riders WHERE email='$email'");
  header("Location: http:/www.sjsu.edu/");
  exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/sign-in.css">
</head>


<body class="grey lighten-3">
    <nav class="white">
      <div class="container">
        <div class="nav-wrapper">
          <a class="brand-logo" href="/"><i class="material-icons teal-text text-lighten-1">airport_shuttle</i></a>
          <a class="sidenav-trigger" data-target="slide-out" href=""><i class="material-icons teal-text text-lighten-1">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="">Lorem</a></li>
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="">Ipsum</a></li>
            <li><a class="btn waves-effect waves-light" href="">Dolor</a></li>
          </ul>
        </div>
      </div>
    </nav>
<!-- Login card -->    
    <content>
      <div class="container">
        <div class="valign-table">
          <div class="valign-table-cell">
            <div class="row">
              <div class="col s12 m10 l7 offset-m1 offset-l5">
                <div class="card">

                  <!-- Main form area: 1 column padding on left and right -->
                  <form class="col s10 offset-s1 card-content" id="login" method="POST">
                    <div class="card-title">Login</div>
                    
                    <!-- Rider login switch -->
                    <div class="switch">
                      <label>Rider<input type="checkbox" name="checkbox"><span class="lever"></span>Driver</label>
                    </div>

                    <!-- Email field -->
                    <div class="row">
                      <div class="input-field col s12">
                        <input id="email" name="email" type="email" class="validate">
                        <label class="active" for="email">Email</label>
                      </div>
                    </div>

                    <!-- Password field -->
                    <div class="row">
                      <div class="input-field col s12">
                        <input id="password" name="password" type="password" class="validate">
                        <label class="active" for="password">Password</label>
                      </div>
                    </div>

                    <!-- Submit button and Sign up link -->
                    <div class="row">
                      <button class="btn waves-effect waves-light" type="submit" id="submit" name="submit">Submit
                          <i class="material-icons right">send</i>
                      </button>
                      <a class="teal-text btn-flat waves-dark" href="sign-up.php">SIGN UP</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </content>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
  </body>
</html>