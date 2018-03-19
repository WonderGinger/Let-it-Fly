<?php
require_once "../private/utilities.php";
session_start();

$nav_link = "/sign-in";
$nav_text = "Sign In";
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
  $nav_link = "/sign-out";
  $nav_text = "Sign Out";
}

$inputs = array_fill(0, 4, NULL);
$errors = array_fill(0, 3, NULL);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $user = !isset($_POST["checkbox"]) ? "riders" : "drivers";
  $email = mysqli_true_escape_string($dbh, $_POST["email"]);
  $password = mysqli_true_escape_string($dbh, $_POST["password"]);
  $confirmation = mysqli_true_escape_string($dbh, $_POST["confirmation"]);

  if (empty($email)) {
    $errors[0] = "Field cannot be empty.";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[0] = "Email is considered invalid.";
  } else {
    if (!$result = $dbh->query("SELECT * FROM {$user} WHERE email='{$email}' LIMIT 1")) db_error();
    $result = $result->fetch_array(MYSQLI_ASSOC);

    if ($email === $result["email"]) $errors[0] = "Email is already registered.";
  }

  if (empty($password)) $errors[1] = "Field cannot be empty.";

  if (empty($confirmation)) {
    $errors[2] = "Field cannot be empty.";
  } else {
    if (!empty($password) && $confirmation !== $password) $errors[2] = "Password does not match original.";
  }

  if (!count(array_filter($errors))) {
    // TODO: Add PHPMailer functionality
    $password = password_hash($password, PASSWORD_DEFAULT);
    if (!$result = $dbh->query("INSERT INTO {$user} (email, password) VALUES ('{$email}', '{$password}')")) db_error();
    // TODO: Create sign up success page
    header("Location: /sign-in");
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
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <link rel="stylesheet" href="/css/master.css">
    <link rel="stylesheet" href="/css/sign-up.css">
  </head>
  <body class="grey lighten-3">
    <nav class="white">
      <div class="container">
        <div class="nav-wrapper">
          <a class="brand-logo" href="/"><i class="material-icons teal-text text-lighten-1">airport_shuttle</i></a>
          <a class="sidenav-trigger" data-target="slide-out" href=""><i class="material-icons teal-text text-lighten-1">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li class="active waves-effect"><a class="teal-text text-lighten-1" href="/sign-up">Create an Account</a></li>
            <li><a class="btn waves-effect waves-light" href="<?php echo $nav_link; ?>"><?php echo $nav_text; ?></a></li>
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
                    <form method="post" action="/sign-up">
                      <p>Register and get a ride in minutes, or become a driver and earn money on your schedule.</p>
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
                          <label class="active" for="password">Create a password</label>
                          <span class="helper-text red-text"><?php echo $errors[1]; ?></span>
                        </div>
                        <div class="col s12 input-field">
                          <input type="password" id="confirmation" name="confirmation" <?php echo $inputs[3]; ?> required>
                          <label class="active" for="confirmation">Confirm your password</label>
                          <span class="helper-text red-text"><?php echo $errors[2]; ?></span>
                        </div>
                        <div class="col s8">
                          <!-- TODO: Create mock Terms of Service page -->
                          <p id="footnote">By proceeding, you agree to the <a href="/res/blank.txt">Terms of Service.</a></p>
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