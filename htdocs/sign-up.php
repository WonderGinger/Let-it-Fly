<?php
$ini = parse_ini_file("../private/let-it-fly.ini");
$link = mysqli_connect($ini["host"], $ini["user"], $ini["pass"], $ini["dbname"]);
if (!$link) {
  // DISPLAY SERVER ERROR PAGE
  header("Location: http://www.sjsu.edu/");
  exit();
}

$user_checkbox = $user_email = $user_password = $user_confirmation = NULL;
$error_email = $error_password = $error_confirmation = NULL;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $user = empty($_POST["checkbox"]) ? "riders" : "drivers";
  $email = $link->real_escape_string($_POST["email"]);
  $password = $link->real_escape_string($_POST["password"]);
  $confirmation = $link->real_escape_string($_POST["confirmation"]);
  $verification = TRUE;

  switch ($email) {
    case NULL:
      $error_email = "Field cannot be empty.";
      $verification = FALSE;
      break;
    case !filter_var($email, FILTER_VALIDATE_EMAIL):
      $error_email = "Email is considered invalid.";
      $verification = FALSE;
      break;
    // MIGHT NEED TRY/CATCH FOR DISCONNECT ERROR
    case $email === mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM {$user} WHERE email='{$email}' LIMIT 1"))["email"]:
      $error_email = "Email is already registered.";
      $verification = FALSE;
      break;
  }
  switch ($password) {
    case NULL:
      $error_password = "Field cannot be empty.";
      $verification = FALSE;
      break;
  }
  switch ($confirmation) {
    case NULL:
      $error_confirmation = "Field cannot be empty.";
      $verification = FALSE;
      break;
    case $confirmation !== $password:
      $error_confirmation = "Password does not match original.";
      $verification = FALSE;
      break;
  }

  if ($verification) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    // ADD PHPMAIL?
    // MIGHT NEED TRY/CATCH FOR DISCONNECT ERROR
    // REDIRECT USER TO SUCCESSFUL REGISTRATION PAGE
    mysqli_query($link, "INSERT INTO {$user} (email, password) VALUES ('{$email}', '{$password}')");
    header("Location: http://www.sjsu.edu/");
    exit();
  } else {
    $user_checkbox = ($user === "drivers") ? "checked='checked'" : $user_checkbox;
    $user_email = "value='{$email}'";
    $user_password = "value='{$password}'";
    $user_confirmation = "value='{$confirmation}'";
  }
}

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
                        <label>Rider<input type="checkbox" name="checkbox" <?php echo $user_checkbox; ?>><span class="lever"></span>Driver</label>
                      </div>
                      <div class="row">
                        <div class="col s12 input-field">
                          <input type="email" id="email" name="email" <?php echo $user_email; ?> required>
                          <label class="active" for="email">Enter your email</label>
                          <span class="helper-text red-text"><?php echo $error_email; ?></span>
                        </div>
                        <div class="col s12 input-field">
                          <input type="password" id="password" name="password" <?php echo $user_password; ?> required>
                          <label class="active" for="password">Create a password</label>
                          <span class="helper-text red-text"><?php echo $error_password; ?></span>
                        </div>
                        <div class="col s12 input-field">
                          <input type="password" id="confirmation" name="confirmation" <?php echo $user_confirmation; ?> required>
                          <label class="active" for="confirmation">Confirm your password</label>
                          <span class="helper-text red-text"><?php echo $error_confirmation; ?></span>
                        </div>
                        <div class="col s8"><p id="legal-warning">By proceeding, you agree to the <a href="">Terms of Service.</a></p></div>
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