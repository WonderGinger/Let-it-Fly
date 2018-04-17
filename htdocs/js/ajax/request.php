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

  // Submit request
  if ($_POST["selector"] === "submit" && isset($_SESSION["id"]) && isset($_POST["data"])) {
    $id_driver = mysqli_true_escape_string($dbh, $_POST["data"]["guy"]["id"]);
    /*
    if (!$result = $dbh->query("INSERT INTO requests (id_rider, id_driver) VALUES ({$_SESSION["id"]}, {$id_driver})")) {
      echo "db-error";
    } else {
      echo "db-success";
    }
    */
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
    $_POST['lat'] = mysqli_true_escape_string($dbh, $_POST['lat']);
    $_POST['lng'] = mysqli_true_escape_string($dbh, $_POST['lng']);
    $_SESSION['id'] = mysqli_true_escape_string($dbh, $_SESSION['id']);

    /* DELETE THIS
    // Update driver location
    if (!$result = $dbh->query(
      "UPDATE drivers SET lat={$_POST['lat']}, lng={$_POST['lng']} WHERE id='{$_SESSION['id']}'")) db_error();
    */

    // Find a request in the requests table that has id_driver matching the driver's ID.
    if (!$result = $dbh->query("SELECT * FROM requests WHERE id_driver={$_SESSION['id']} LIMIT 1")) db_error();
    $result = $result->fetch_array(MYSQLI_ASSOC);
    echo json_encode($result);
  }
}

mysqli_close($dbh);
?>