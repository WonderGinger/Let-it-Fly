<?php
$ini = parse_ini_file("../private/let-it-fly.ini");
$link = mysqli_connect($ini["host"], $ini["user"], $ini["pass"], $ini["dbname"]);
if (!$link) {
  // GENERATE SERVER ERROR PAGE
}

$email = $password = $confirmation = NULL;
$msg1 = $msg2 = $msg3 = NULL;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $link->real_escape_string($_POST["email"]);
  $password = $link->real_escape_string($_POST["password"]);
  $confirmation = $link->real_escape_string($_POST["confirmation"]);

  if (empty($email)) {
    $msg1 = "Email cannot be empty.";
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $msg1 = "Email is not valid";
    } else {
        // SQL STUFF
    }
  }
    
  // HASH THE PASSWORD
  if (empty($password)) {
    $msg2 = "password cannot be empty.";
  }
  
  if (empty($confirmation)) {
    $msg3 = "Confirmation password cannot be empty.";
  } else {
    if ($confirmation != $password) {
      $msg3 = "Confirmation password does not match;";
    }
  }
}


  // also get rider vs driver check
  // do some exception checking
  // hash password

  $query = "INSERT INTO riders (email, password) VALUES ('$email', '$password')";
  mysqli_query($link, $query);


mysqli_close($link);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/sign-up.css">
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
    <content>
      <div class="container">
        <div class="valign-table">
          <div class="valign-table-cell">
            <div class="row">
              <div class="col s12 m10 l7 offset-m1 offset-l5">
                <div class="card">
                  <div class="card-content">
                    <span class="card-title teal-text text-lighten-1">Begin Your Journey</span>
                    <form method="post" action="sign-up">
                      <p>Register and get a ride in minutes, or become a driver and earn money on your schedule.</p>
                      <div class="switch">
                        <label>Rider<input type="checkbox" id="mycheckbox"><span class="lever"></span>Driver</label>
                      </div>
                      <!-- <a onclick="value_()">value</a> -->

                      <div class="row">
                        <div class="col s12 input-field">
                          <input type="email" id="email" name="email" required>
                          <label for="email">Enter your email</label>
                          <span class="helper-text"><?php echo $msg1; ?></span>
                        </div>
                        <div class="col s12 input-field">
                          <input type="password" id="password" name="password" required>
                          <label for="password">Create a password</label>
                          <span class="helper-text"><?php echo $msg2; ?></span>
                        </div>
                        <div class="col s12 input-field">
                          <input type="password" id="confirmation" name="confirmation" required>
                          <label for="confirmation">Confirm your password</label>
                          <span class="helper-text"><?php echo $msg3; ?></span>
                        </div>
                        <div class="col s8">
                          <p style="font-size: 14px; margin-top:7px; color: #9e9e9e;">By proceeding, you agree to the Terms of Service.</a></p><!-- FIX TAG -->
                        </div>
                        <div class="col s4 right-align"><button type="submit" class="btn waves-effect waves-light">Next</button></div>
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
    <script>

function value_() {
  var checkbox = document.getElementById('mycheckbox');
  alert('checkbox value: ' + checkbox.checked);
}


    </script>
  </body>
</html>