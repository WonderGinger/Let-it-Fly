<?php
require_once "../private/utilities.php";
session_start();

// Redirect user to index if logged in
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
  header("location: /");
  exit();
}

// HTML placeholders for user data
$inputs = array_fill(0, 3, null);
$errors = array_fill(0, 2, null);

// Check form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Collect form data
  $user = !isset($_POST["checkbox"]) ? "riders" : "drivers";
  $email = mysqli_true_escape_string($dbh, $_POST["email"]);
  $password = mysqli_true_escape_string($dbh, $_POST["password"]);

  // Check email exceptions
  switch ($email) {
    case $email:
      if (strlen($email) === 0) {
        $errors[0] = "Email field cannot be empty.";
        break;
      }
    case $email:
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[0] = "Email is considered invalid.";
        break;
      }
    case $email:
      if (!$result = $dbh->query("SELECT * FROM {$user} WHERE email='{$email}' LIMIT 1")) db_error();
      $result = $result->fetch_array(MYSQLI_ASSOC);

      if (!$result) {
        $errors[0] = "Email has not been registered yet.";
        break;
      }
  }

  // Check password exceptions
  switch ($password) {
    case $password:
      if (strlen($password) === 0) {
        $errors[1] = "Password field cannot be empty.";
        break;
      }
    case $password:
      if ($errors[0] !== null) {
        $errors[1] = "Fix email error(s).";
        break;
      }
    case $password:
      if (!password_verify($password, $result["password"])) {
        $errors[1] = "Password is incorrect.";
        break;
      }
    case $password:
      $_SESSION["logged_in"] = true;
      $_SESSION["user"] = $user;
	    $_SESSION["id"] = $result["id"];
      $_SESSION["email"] = $result["email"];
      break;
  }

  // Redirect to index if error-free
  if (!array_filter($errors)) {
    header("location: /");
    exit();
  } else {
    $inputs[0] = ($user === "riders") ? $inputs[0] : "checked='checked'";
    $inputs[1] = "value='{$email}'";
    $inputs[2] = "value='{$password}'";
  }
}

mysqli_close($dbh);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <title>Sign In</title>
    <!-- Import stylesheets -->
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
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="about">Documentation</a></li>
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="sign-up">Create an Account</a></li>
            <li><a class="btn waves-effect waves-light" href="">Sign In</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navigation menu -->
    <ul class="sidenav" id="slide-out">
      <li>
        <div class="user-view">
          <div class="background"><img src="img/sjsu.png" alt="SJSU"></div>
          <div class="valign-table">
            <div class="valign-table-cell">
              <a class="btn waves-effect waves-light" href="">Sign In</a>
            </div>
          </div>
        </div>
      </li>
      <li><a class="teal-text text-lighten-1 waves-effect" href="about">Documentation</a></li>
      <li><a class="teal-text text-lighten-1 waves-effect" href="sign-up">Create an Account</a></li>
    </ul>
    <!-- Content -->
    <div class="container">
      <div class="valign-table">
        <div class="valign-table-cell">
          <div class="row">
            <div class="col s12 m8 l6 offset-m2 offset-l3">
              <!-- Sign in card -->
              <div class="card">
                <div class="card-content">
                  <span class="card-title teal-text text-lighten-1">Sign In</span>
                  <!-- User form -->
                  <form method="post" action="sign-in">
                    <p>Select your user account.</p>
                    <!-- User toggle -->
                    <div class="switch">
                      <label>Rider<input type="checkbox" name="checkbox" <?php echo $inputs[0]; ?>><span class="lever"></span>Driver</label>
                    </div>
                    <!-- User fields -->
                    <div class="row">
                      <!-- Email field -->
                      <div class="col s12 input-field">
                        <input type="email" name="email" id="email" placeholder="Enter your email" <?php echo $inputs[1]; ?> required>
                        <span class="helper-text red-text"><?php echo $errors[0]; ?></span>
                      </div>
                      <!-- Password field -->
                      <div class="col s12 input-field">
                        <input type="password" name="password" id="password" placeholder="Enter your password" <?php echo $inputs[2]; ?> required>
                        <span class="helper-text red-text"><?php echo $errors[1]; ?></span>
                      </div>
                      <!-- Submission -->
                      <div class="col s4 offset-s8 right-align"><button class="btn waves-effect waves-light" type="submit">Next</button></div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Import JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <script src="js/materialize.js"></script>
  </body>
</html>