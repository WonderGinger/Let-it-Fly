<?php
$ini = parse_ini_file("../private/let-it-fly.ini");
$link = mysqli_connect($ini["host"], $ini["user"], $ini["pass"], $ini["dbname"]);
if (!$link) {
  // DISPLAY SERVER ERROR PAGE
  header("Location: http://www.sjsu.edu/");
  exit();
}

echo "<b>RIDERS</b>";
print "<pre>";
print_r(mysqli_fetch_all(mysqli_query($link, "SELECT * FROM riders")));
print "</pre>";

echo "<b>DRIVERS</b>";
print "<pre>";
print_r(mysqli_fetch_all(mysqli_query($link, "SELECT * FROM drivers")));
print "</pre>";


mysqli_close($link);
?>