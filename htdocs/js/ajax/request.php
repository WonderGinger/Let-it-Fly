<?php
require_once "../../../private/utilities.php";
session_start();
if (isset($_POST["selector"])) {
  if ($_POST["selector"] === "drivers" && isset($_POST["passengers"])) {
    $passengers = $_POST["passengers"];
    if (!$result = $dbh->query("SELECT id, driving, lat, lng FROM drivers WHERE seats>={$passengers} AND working=1")) db_error();

    $drivers = array();
    while($row = $result->fetch_assoc()) $drivers[] = $row;
    echo json_encode($drivers);
  }
  if ($_POST["selector"] === "working" && isset($_SESSION["id"])) {
    if (!$result = $dbh->query("UPDATE drivers SET working=!working WHERE id='{$_SESSION['id']}'")) db_error();
  }
}

mysqli_close($dbh);
?>