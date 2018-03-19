<?php
require_once "../private/utilities.php";
session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
  header("Location: /");
  exit();
}

$inputs = array_fill(0, 3, NULL);
$errors = array_fill(0, 2, NULL);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $user = !isset($_POST["checkbox"]) ? "riders" : "drivers";
  $email = mysqli_true_escape_string($dbh, $_POST["email"]);
  $password = mysqli_true_escape_string($dbh, $_POST["password"]);

  if (empty($email)) {
    $errors[0] = "Field cannot be empty.";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[0] = "Email is considered invalid.";
  } else {
    if (!$result = $dbh->query("SELECT * FROM {$user} WHERE email='{$email}' LIMIT 1")) db_error();
    $result = $result->fetch_array(MYSQLI_ASSOC);

    if (!$result) {
      $errors[0] = "Email has not been registered yet.";
    } else {
      // TODO: Make this condition false after implementing PHPMailer
      if ($result["active"]) $errors[0] = "Email has not been activated yet.";
    }
  }

  if (empty($password)) {
    $errors[1] = "Field cannot be empty.";
  } else {
    if ($errors[0] === "Email has not been activated yet." || $errors[0] === NULL) {
      if (!password_verify($password, $result["password"])) {
        $errors[1] = "Password is incorrect.";
      } else {
        $_SESSION["logged_in"] = true;
        $_SESSION["user"] = $user;
        $_SESSION["email"] = $email;
      }
    }
  }

  if (!count(array_filter($errors))) {
    header("Location: /");
    exit();
  } else {
    $inputs[0] = ($user === "riders") ? $inputs[0] : "checked='checked'";
    $inputs[1] = "value='{$email}'";
    $inputs[2] = "value='{$password}'";
  }
}

mysqli_close($dbh);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <link rel="stylesheet" href="/css/master.css">
    <link rel="stylesheet" href="/css/sign-in.css">
  </head>
  <body class="grey lighten-3">
    <nav class="white">
      <div class="container">
        <div class="nav-wrapper">
          <a class="brand-logo" href="/"><i class="material-icons teal-text text-lighten-1">airport_shuttle</i></a>
          <a class="sidenav-trigger" data-target="slide-out" href=""><i class="material-icons teal-text text-lighten-1">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="/sign-up">Create an Account</a></li>
            <li><a class="btn teal-text text-lighten-1 waves-effect waves-light" href="/sign-in">Sign In</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <content>
      <div class="container">
        <div class="valign-table">
          <div class="valign-table-cell">
            <div class="row">
              <div class="col s12 m8 l6 offset-m2 offset-l3">
                <div class="card">
                  <div class="card-content">
                    <span class="card-title teal-text text-lighten-1">Sign In</span>
                    <form method="post" action="/sign-in">
                      <p>Select your user account.</p>
                      <div class="switch">
                        <label>Rider<input type="checkbox" name="checkbox" <?php echo $inputs[0]; ?>><span class="lever"></span>Driver</label>
                      </div>
                      <div class="row">
                        <div class="col s12 input-field">
                          <input type="email" id="email" name="email" <?php echo $inputs[1]; ?> required>
                          <label class="active" for="email">Enter your email</label>
                          <span class="helper-text red-text"><?php echo $errors[0]; ?></span>
                        </div>
                        <div class="col s12 input-field">
                          <input type="password" id="password" name="password" <?php echo $inputs[2]; ?> required>
                          <label class="active" for="password">Enter your password</label>
                          <span class="helper-text red-text"><?php echo $errors[1]; ?></span>
                        </div>
                        <div class="col s8">
                          <!-- TODO: Add password reset functionality -->
                          <p id="footnote"><a href="/res/blank.txt">Forgot password?</a></p>
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
  </body>
</html>