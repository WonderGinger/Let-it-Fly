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
<html>
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


    <div style="height: calc(100% - 62px); margin-top:2px; background-color:blue;">
      <div class="card" style="height: 100%;">
        <div class="card-image"  style="height: calc(100% - 64px);  background-color: red;">
        
        <div class="container" style="position: relative;">
      <div id="floating-panel">
    hi
      </div>
    </div>
          <div id="map"></div>
        </div>
        
        <div class="card-content white-text">
          <span class="card-title activator grey-text text-darken-4 center-align">Request a Ride</span>
        </div>
        <div class="card-reveal">
          <span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
          <p>Here is some more information about this product that is only revealed once clicked on.</p>
          <p>Here is some more information about this product that is only revealed once clicked on.</p>
          <p>Here is some more information about this product that is only revealed once clicked on.</p>
          <p>Here is some more information about this product that is only revealed once clicked on.</p>
          <p>Here is some more information about this product that is only revealed once clicked on.</p>
          <p>Here is some more information about this product that is only revealed once clicked on.</p>
          <p>Here is some more information about this product that is only revealed once clicked on.</p>
          <p>Here is some more information about this product that is only revealed once clicked on.</p>
          <p>Here is some more information about this product that is only revealed once clicked on.</p>
        </div>
      </div>
    <div>


    <style>
      #map {
        height: calc(100%);
        max-height: 1024px;
        width: 100%;
      }
    </style>


    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 37.3352, lng: -121.8811},
          disableDefaultUI: true,
          zoom: 15
        });
      }
    </script>

    <!-- Import JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <script src="js/sidenav.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRIbTYik2x_e5--W85NiB2bckEMFDjVtc&callback=initMap" async defer></script>
    <script src="js/map.js"></script>
  </body>
</html>