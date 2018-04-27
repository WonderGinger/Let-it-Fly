<?php
require_once "../private/utilities.php";
session_start();

if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
  header("location: sign-in");
  exit();
}

if (!$result = $dbh->query("SELECT lat, lng, seats FROM drivers WHERE id = {$_SESSION['id']};")) db_error();
$result = $result->fetch_array(MYSQLI_ASSOC);



if ($_SESSION["user"] == "drivers") {
  // Initialize driver in account settings
  if ($result["lat"] == 0 && $result["lng"] == 0 && $result["seats"] == 0) {
    header("location: account");
    exit();
  }
} else {
  // work on billing
}



$account_name = explode("@", $_SESSION["email"], 2);
$account_name = strlen($account_name[0]) > 21 ? substr($account_name[0], 0, 21) . "..." : $account_name[0];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <title>Let It Fly</title>
    <!-- Import stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <link rel="stylesheet" href="css/nouislider.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/index.css">
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
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="account"><?php echo $account_name; ?></a></li>
            <li><a class="btn waves-effect waves-light" href="sign-out">Sign Out</a></li>
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
              <a class="btn waves-effect waves-light" href="sign-out">Sign Out</a>
            </div>
          </div>
        </div>
      </li>
      <li><a class="teal-text text-lighten-1 waves-effect" href="about">Documentation</a></li>
      <li><a class="teal-text text-lighten-1 waves-effect" href="account"><?php echo $account_name; ?></a></li>
    </ul>
    <?php
    if ($_SESSION["user"] === "riders") {
      if (!$result = $dbh->query("SELECT * FROM requests WHERE id_rider = {$_SESSION["id"]}")) db_error();
      $result = $result->fetch_array(MYSQLI_ASSOC);

      if ($result) {
        require_once "../require/request.php";
        $script = "js/request-map.js";
      } else {
        require_once "../require/rider.php";
        $script = "js/map.js";
      }
    } else {
      require_once "../require/driver.php";
      $script = "js/driver-map.js";
    }
    mysqli_close($dbh);
    ?>
    <!-- Import JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHd7wEeRlgn08q5xC4mifzgVZcKSoplUM&libraries=places"></script>
    <script src="js/materialize.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/library.js"></script>
    <script src="<?php echo $script; ?>"></script>
  </body>
</html>