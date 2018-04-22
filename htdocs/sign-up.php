<?php
require_once "../private/utilities.php";
session_start();

// Redirect user to index if logged in
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
  header("location: /");
  exit();
}

// HTML placeholders for user data
$inputs = array_fill(0, 4, null);
$errors = array_fill(0, 3, null);

// Check form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Collect form data
  $user = !isset($_POST["checkbox"]) ? "riders" : "drivers";
  $email = mysqli_true_escape_string($dbh, $_POST["email"]);
  $password = mysqli_true_escape_string($dbh, $_POST["password"]);
  $confirmation = mysqli_true_escape_string($dbh, $_POST["confirmation"]);

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

      if ($email === $result["email"]) {
        $errors[0] = "Email is already registered.";
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
      if (strlen($password) < 8) {
        $errors[1] = "Password must be eight or more characters.";
        break;
      }
  }

  // Check confirmation exceptions
  switch ($confirmation) {
    case $confirmation:
      if (strlen($confirmation) === 0) {
        $errors[2] = "Confirmation field cannot be empty.";
        break;
      }
    case $confirmation:
      if ($errors[1] !== null) {
        $errors[2] = "Fix password error(s).";
        break;
      }
    case $confirmation:
      if ($confirmation !== $password) {
        $errors[2] = "Password does not match original.";
        break;
      }
  }

  // Accept registration if error-free
  if (!array_filter($errors)) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    if (!$result = $dbh->query("INSERT INTO {$user} (email, password) VALUES ('{$email}', '{$password}')")) db_error();

    header("location: sign-in");
    exit();
  } else {
    $inputs[0] = ($user === "riders") ? $inputs[0] : "checked='checked'";
    $inputs[1] = "value='{$email}'";
    $inputs[2] = "value='{$password}'";
    $inputs[3] = "value='{$confirmation}'";
  }
}

mysqli_close($dbh);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <title>Sign Up</title>
    <!-- Import stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/sign-up.css">
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
            <li class="active waves-effect"><a class="teal-text text-lighten-1" href="">Create an Account</a></li>
            <li><a class="btn waves-effect waves-light" href="sign-in">Sign In</a></li>
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
              <a class="btn waves-effect waves-light" href="sign-in">Sign In</a>
            </div>
          </div>
        </div>
      </li>
      <li><a class="teal-text text-lighten-1 waves-effect" href="about">Documentation</a></li>
      <li class="active"><a class="teal-text text-lighten-1 waves-effect" href="">Create an Account</a></li>
    </ul>
    <!-- Content -->
    <div class="container">
      <div class="valign-table">
        <div class="valign-table-cell">
          <div class="row">
            <div class="col s12 m10 l7 offset-m1 offset-l5">
              <!-- Sign up card -->
              <div class="card">
                <div class="card-content">
                  <span class="card-title teal-text text-lighten-1">Begin Your Journey</span>
                  <!-- User form -->
                  <form method="post" action="sign-up">
                    <p>Register and get a ride in minutes, or become a driver and earn money on your schedule.</p>
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
                        <input type="password" name="password" id="password" placeholder="Create a password" <?php echo $inputs[2]; ?> required>
                        <span class="helper-text red-text"><?php echo $errors[1]; ?></span>
                      </div>
                      <!-- Confirmation field -->
                      <div class="col s12 input-field">
                        <input type="password" name="confirmation" id="confirmation" placeholder="Confirm your password" <?php echo $inputs[3]; ?> required>
                        <span class="helper-text red-text"><?php echo $errors[2]; ?></span>
                      </div>
                      <!-- Footnote -->
                      <div class="col s8"><p id="footnote">By proceeding, you agree to the Terms of Service.</p></div>
                      <!-- Submission -->
                      <div class="col s4 right-align"><button class="btn waves-effect waves-light" type="submit">Next</button></div>
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