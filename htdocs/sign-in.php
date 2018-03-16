<?php

require_once 'utility.php';

// Connect to let_it_fly database
$ini = parse_ini_file("../private/let-it-fly.ini");
$link = mysqli_connect($ini["host"], $ini["user"], $ini["pass"], $ini["dbname"]);
if (!$link) display_error_page();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $user = empty($_POST["checkbox"]) ? "riders" : "drivers";
  $email = mysql_entities_fix_string($link, $_POST["email"]);

  $query = "SELECT * FROM $user WHERE email='$email'";
  
  // Main log-in logic
  $result = $link->query($query);
  if(!$result) display_error_page();
  elseif($result->num_rows) {

    // Get matching row (there should only be one)
    $row = $result->fetch_array(MYSQLI_NUM);
    // Sanitize string
    $password = mysql_entities_fix_string($link, $_POST["password"]);
    // Hash entered password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Check password against database
    if($password == $row[2]){
      // Store session variables
      session_start();
      $_SESSION['logged_in'] = true;
      $_SESSION['user'] = $user;
      $_SESSION['email'] = $email;

      // If the redirection is 1 line of code this can turn into ?: operator.
      if($user == "drivers"){
        // TODO: Redirect to driver page

      }
      elseif($user == "riders"){
        // TODO: Redirect to rider page
      }
      else {
        display_error_page();
      }
    }
    $result->close();
  }
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

<!-- Navigation bar -->
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
              <div class="col s12 m10 l7 offset-m1 offset-l3">
                <div class="card">
                  <div class="card-content">
                    <span class="card-title teal-text text-lighten-1">Login</span>
                    
                    <!-- Main form area: 1 column padding on left and right -->
                    <form method="post" action="sign-in">
                      
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
                        <a class="teal-text btn-flat waves-dark" href="../sign-up">SIGN UP</a>
                      </div>
                    </form>
                  </div>
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