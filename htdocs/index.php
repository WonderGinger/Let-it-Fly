<?php
require_once "../private/utilities.php";
session_start();

// Redirect user to sign-in if not logged in
if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
  header("location: sign-in");
  exit();
}

mysqli_close($dbh);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Let It Fly</title>
    <!-- Import stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
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
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="about">User Manual</a></li>
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="account">Account Settings</a></li>
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
      <li><a class="teal-text text-lighten-1 waves-effect" href="about">User Manual</a></li>
      <li><a class="teal-text text-lighten-1 waves-effect" href="account">Account Settings</a></li>
    </ul>

    <!-- Content -->
    <div class="card">
      <!-- Search interface -->
      <div class="container">
        <div id="floating-panel">
          <div class="row">
            <div class="col s12 m8 offset-m2 input-field">
              <!-- Search card -->
              <div class="card-panel">
                <input class="autocomplete" type="text" id="autocomplete-input" placeholder="Enter an address">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Map -->
      <div id="map"></div>
      <div class="card-content activator" id="slider">
        <span class="card-title activator center-align teal-text lighten-1">Choose Your Location<i class="material-icons">keyboard_arrow_up</i></span>
      </div>
      <!-- Request Interface -->
      <div class="card-reveal grey lighten-3">
        <span class="card-title center-align teal-text lighten-1">Request a Ride<i class="material-icons">keyboard_arrow_down</i></span>
        <div class="container">
          <p id="info1"></p>
          <p id="info2"></p>

<div style="pointer-events: auto;">
  <div class="input-field col s12">
    <select id="sel">

      <option value="SFO" selected>SFO</option>
      <option value="SJC">SJC</option>
      <option value="OAK">OAK</option>
    </select>
  </div>
</div>



        </div>
      </div>
    </div>
    <!-- Import JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRIbTYik2x_e5--W85NiB2bckEMFDjVtc&libraries=places"></script>
    <script src="js/sidenav.js"></script>
    <script src="js/autocomplete.js"></script>
    <script src="js/map.js"></script>

    <!-- TODO(front end): tidy up Materialize JavaScript -->
    <script>
      var elem = document.querySelector("select");
      var instance = M.FormSelect.init(elem);
    </script>
  </body>
</html>