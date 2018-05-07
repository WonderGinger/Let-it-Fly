<?php
require_once "../private/utilities.php";
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <title>Error</title>
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

            <?php
            if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
              echo '<li class="waves-effect"><a class="teal-text text-lighten-1" href="sign-up">Create an Account</a></li>';
              echo '<li><a class="btn waves-effect waves-light" href="sign-in">Sign In</a></li>';
            } else {
              $account_name = explode("@", $_SESSION["email"], 2);
              $account_name = strlen($account_name[0]) > 12 ? substr($account_name[0], 0, 12) . "..." : $account_name[0];
              echo '<li class="waves-effect"><a class="teal-text text-lighten-1" href="account">' . $account_name . '</a></li>';
              echo '<li><a class="btn waves-effect waves-light" href="sign-out">Sign Out</a></li>';
            }
            ?>

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
              <?php
              if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
                echo '<a class="btn waves-effect waves-light" href="sign-in">Sign In</a>';
              } else {
                echo '<a class="btn waves-effect waves-light" href="sign-out">Sign Out</a>';
              }
              ?>
            </div>
          </div>
        </div>
      </li>
      <li><a class="teal-text text-lighten-1 waves-effect" href="about">Documentation</a></li>

      <?php
      if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        echo '<li><a class="teal-text text-lighten-1 waves-effect" href="sign-up">Create an Account</a></li>';
      } else {
        echo '<li><a class="teal-text text-lighten-1 waves-effect" href="account">'. $account_name . '</a></li>';
      }
      ?>

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
                  <span class="card-title teal-text text-lighten-1">Error</span>
                  <p>Something happened. The database may be offline, or most likely you have entered data that cannot be inserted into the database because of existing requests.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <style>
    /* Active color sign in button */
    nav ul a.btn {
      background-color: #26a69a !important;
      color: white !important;
    }

    .sidenav .user-view a.btn {
      background-color: #26a69a !important;
      color: white !important;
    }
    </style>
    
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <script src="js/materialize.js"></script>
  </body>
</html>