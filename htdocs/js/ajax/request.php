<?php
require_once "../../../private/utilities.php";
session_start();

if (isset($_POST["selector"])) {
  // Check database for available drivers
  if ($_POST["selector"] === "drivers" && isset($_POST["passengers"])) {
    // Sanitize input
    $_POST["passengers"] = mysqli_true_escape_string($dbh, $_POST["passengers"]);

    $passengers = $_POST["passengers"];
    if (!$result = $dbh->query("SELECT id, parties, des, lat, lng FROM drivers WHERE locked=0 AND working=1 AND seats>={$passengers} AND parties<2")) db_error();

    $drivers = array();
    while($row = $result->fetch_assoc()) $drivers[] = $row;
    echo json_encode($drivers);
  }

  // One-mile checking
  if ($_POST["selector"] === "omc" && isset($_POST["driver"])) {
    $id = $_POST["driver"]["id"];


    if (!$result = $dbh->query("SELECT id_driver, polyline_1, polyline_2 FROM requests WHERE id_driver={$id}")) db_error();
    $result = $result->fetch_array(MYSQLI_ASSOC);

    if (!$result) {
      echo "empty";
    } else {
      $arr = [];
      if ($result["polyline_1"] !== null) {
        array_push($arr, json_decode($result["polyline_1"]));
      }
      if ($result["polyline_2"] !== null) {
        array_push($arr, json_decode($result["polyline_2"]));
      }
      echo json_encode($arr);
    }
  }














  // Submit request
  if ($_POST["selector"] === "submit" && isset($_SESSION["id"]) && isset($_POST["data1"]) && isset($_POST["data2"]) && isset($_POST["data3"])) {
    // $id_driver = mysqli_true_escape_string($dbh, $_POST["data"]["guy"]["id"]);
    //$wpoints = mysqli_true_escape_string($dbh, $_POST["data"]["guy"]);

    //echo json_encode($_POST["data"]["guy"]);

    $coords1 = json_encode($_POST["data1"]["coords1"]);
    $coords2 = json_encode($_POST["data2"]["coords2"]);
    $id_driver = $_POST["data3"];
    $id_rider = $_SESSION['id'];


    if (!$result = $dbh->query("INSERT INTO requests (id_rider, id_driver, polyline_1, polyline_2, eta_1, eta_2) VALUES ({$id_rider}, {$id_driver},'{$coords1}', '{$coords2}', 0, 0)")) {
      echo mysqli_error($dbh);
    } else {
      echo "db-success";
    }
  }












  // Toggles the "working" boolean in the drivers table.
  if ($_POST["selector"] === "working" && isset($_SESSION["id"]) && isset($_POST["value"])) {
    // Sanitize inputs
    $_POST['value'] = mysqli_true_escape_string($dbh, $_POST['value']);
    $_SESSION['id'] = mysqli_true_escape_string($dbh, $_SESSION['id']);

    if (!$result = $dbh->query("UPDATE drivers SET working={$_POST['value']} WHERE id='{$_SESSION['id']}'")) db_error();
    // echo $_POST["value"];
  }

  // Checks for incoming requests for drivers in the requests table, and updates driver location.
  if ($_POST["selector"] === "check" && isset($_SESSION["id"])) {
    // Sanitize input
    $_SESSION['id'] = mysqli_true_escape_string($dbh, $_SESSION['id']);

    // Find a request in the requests table that has id_driver matching the driver's ID.
    if (!$result = $dbh->query("SELECT * FROM requests WHERE id_driver={$_SESSION['id']} LIMIT 1")) db_error();
    $result = $result->fetch_array(MYSQLI_ASSOC);
    echo json_encode($result);
  }

  // Get driver location
  if ($_POST["selector"] === "getLocation" && isset($_SESSION["id"])) {
    $_SESSION["id"] = mysqli_true_escape_string($dbh, $_SESSION["id"]);

    if (!$result = $dbh->query("SELECT lat, lng FROM drivers WHERE id={$_SESSION['id']} LIMIT 1")) db_error();
    $result = $result->fetch_array(MYSQLI_ASSOC);
    echo json_encode($result);

  }
}

mysqli_close($dbh);
?>