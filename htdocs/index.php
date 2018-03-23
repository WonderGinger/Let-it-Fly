<?php
session_start();

// TODO: Organize code, add functionality

if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
  header("Location: /sign-in");
} else {
  require_once "map.php";
}
?>
<!--
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <link rel="stylesheet" href="css/master.css">
    <title>Let It Fly!</title>
  </head>
  <body>
    <nav class="white">
      <div class="container">
        <div class="nav-wrapper">
          <a class="brand-logo" href="/">
            <i class="material-icons teal-text text-lighten-1" style="padding: 0 4px 0 15px;">local_taxi</i>
            <i class="material-icons teal-text text-lighten-1" style="padding: 0 15px 0 4px;">local_airport</i>
          </a>
          <a class="sidenav-trigger" data-target="slide-out" href="">
            <i class="material-icons teal-text text-lighten-1">menu</i>
          </a>
          <ul class="right hide-on-med-and-down">
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="">About</a></li>
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="">Lorem</a></li>
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="">Ipsum</a></li>
            <li><a class="btn waves-effect">Ipsum</a></li>
          </ul>
          <ul class="sidenav" id="slide-out"></ul>
        </div>
      </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <script>$( document ).ready(function() { $(".sidenav").sidenav(); });</script>
  </body>
</html>
-->