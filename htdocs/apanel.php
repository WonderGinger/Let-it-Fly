<?php
require_once "../private/utilities.php";

// TODO: Improve interface, add functionality, update to OOP design

echo "<b>RIDERS</b>";
print "<pre>";
print_r(mysqli_fetch_all(mysqli_query($dbh, "SELECT * FROM riders")));
print "</pre>";

echo "<b>DRIVERS</b>";
print "<pre>";
print_r(mysqli_fetch_all(mysqli_query($dbh, "SELECT * FROM drivers")));
print "</pre>";


mysqli_close($dbh);
?>