<?php
$ini = parse_ini_file("../private/let-it-fly.ini");
if (!$dbh = mysqli_connect($ini["host"], $ini["username"], $ini["passwd"], $ini["dbname"])) db_error();

function db_error() {
  // TODO: Create database error page
  header("Location: /res/blank.txt");
  exit();
}

function mysqli_true_escape_string($link, $escapestr) {
  if (get_magic_quotes_gpc()) $escapestr = stripslashes($escapestr);
  return htmlentities($link->real_escape_string($escapestr));
}
?>