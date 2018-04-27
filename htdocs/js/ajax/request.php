<?php
require_once "../../../private/utilities.php";
session_start();

if (isset($_POST["selector"])) {
  // Check database for available drivers
  if ($_POST["selector"] === "drivers" && isset($_POST["passengers"])) {
    // Sanitize input
    $_POST["passengers"] = mysqli_true_escape_string($dbh, $_POST["passengers"]);

    $passengers = $_POST["passengers"];
    if (!$result = $dbh->query("SELECT id, parties, des, lat, lng FROM drivers WHERE locked=0 AND working=1 AND seats>={$passengers} AND parties<2")) {
      echo "db-error";
      exit;
    }

    $drivers = array();
    while($row = $result->fetch_assoc()) $drivers[] = $row;
    echo json_encode($drivers);
  }

  // One-mile checking
  if ($_POST["selector"] === "omc" && isset($_POST["driver"])) {
    $id = $_POST["driver"]["id"];

    if (!$result = $dbh->query("SELECT id_driver, polyline_1, polyline_2 FROM requests WHERE id_driver={$id}")) {
      echo "db-error";
      exit;
    }
    $result = $result->fetch_array(MYSQLI_ASSOC);

    if (!$result) {
      echo "empty";
    } else {
      $arr = [];
      array_push($arr, $_POST["iteration"]);
      array_push($arr, json_decode($result["polyline_1"]));
      echo json_encode($arr);
    }
  }

  // Cross check
  if ($_POST["selector"] === "ccheck") {
    $coords1 = json_encode($_POST["data1"]["coords1"]);
    $coords2 = json_encode($_POST["data2"]["coords2"]);
    $id_driver = $_POST["data3"];
    $id_rider = $_SESSION['id'];

    $orig_parties = $_POST["orig"]["parties"];
    $orig_des = $_POST["orig"]["des"];

    if (!$result = $dbh->query("SELECT id, parties, des, lat, lng FROM drivers WHERE id = {$id_driver}")) {
      echo "db-error";
      exit;
    }
    $result = $result->fetch_array(MYSQLI_ASSOC);

    // Cross check working state before others
    if (!$result2 = $dbh->query("SELECT working FROM drivers WHERE id = {$id_driver}")) {
      echo "db-error";
      exit;
    }
    $result2 = $result2->fetch_array(MYSQLI_ASSOC);

    if ($result2["working"] == 0) {
      echo "diff";
      exit;
    }

    if ($result["parties"] === $orig_parties && ($result["des"] === $orig_des || $result["des"] === null)) {
      echo json_encode($result);
    } else {
      echo "diff";
    }
  }

  // Submit request airport to airport or airport to road (private travel)
  if (($_POST["selector"] === "submit-aa" || $_POST["selector"] === "submit-ar") && isset($_SESSION["id"])) {
    $id_rider = $_SESSION["id"];
    $id_driver = $_POST["data1"]["id"];
    $coords1 = json_encode($_POST["data2"]);
    $coords2 = json_encode($_POST["data3"]);
    $people = $_POST["data4"];
    $des = $_POST["data5"];
    $cost = $_POST["data6"];
    $rider_email = $_SESSION["email"];

    if ($des == null) {
      $des = "NULL";
    } else {
      $des = "'" . $des . "'";
    }

    if (!$result1 = $dbh->query("INSERT INTO requests (id_rider, rider_email, id_driver, seats, polyline_1, cost, des) VALUES ({$id_rider}, '{$rider_email}', {$id_driver}, {$people}, '{$coords2}', {$cost}, {$des})")) {
      echo "db-error";
      exit;
    }

    if (!$result2 = $dbh->query("UPDATE drivers SET seats = seats - {$people}, parties = parties + 1, des = {$des} WHERE id = {$id_driver}")) {
      echo "db-error";
      exit;
    }
  }

  // Submit request road to airport
  if ($_POST["selector"] === "submit-ra" && isset($_SESSION["id"])) {
    $id_rider = $_SESSION["id"];
    $id_driver = $_POST["data1"]["id"];
    $coords1 = json_encode($_POST["data2"]);
    $coords2 = json_encode($_POST["data3"]);
    $people = $_POST["data4"];
    $des = $_POST["data5"];
    $cost = $_POST["data6"];
    $rider_email = $_SESSION["email"];

    if (!$result1 = $dbh->query("INSERT INTO requests (id_rider, rider_email, id_driver, seats, polyline_1, polyline_2, eta_2, cost, des) VALUES ({$id_rider}, '{$rider_email}', {$id_driver}, {$people} ,'{$coords1}', '{$coords2}', 0, {$cost}, '{$des}')")) {
      echo "db-error";
      exit;
    }

    if (!$result2 = $dbh->query("UPDATE requests SET polyline_1 = '{$coords1}', eta_1 = 0, polyline_2 = '{$coords2}', eta_2 = 0 WHERE id_driver = {$id_driver}")) {
      echo "db-error";
      exit;
    }

    if (!$result3 = $dbh->query("UPDATE drivers SET seats = seats - {$people}, locked = 1, parties = parties + 1, des = '{$des}' WHERE id = {$id_driver}")) {
      echo "db-error";
      exit;
    }
  }

  // RIDER FUNCTIONS
  if ($_POST["selector"] === "refresh" && isset($_SESSION["id"])) {

    $id_rider = $_SESSION["id"];
    if (!$result1 = $dbh->query("SELECT * FROM requests WHERE id_rider = {$id_rider}")) {
      echo "db-error";
      exit;
    }
    $result1 = $result1->fetch_array(MYSQLI_ASSOC);

    if (!$result1) {
      echo "empty";
      exit;
    }

    $id_driver = $result1["id_driver"];
    if (!$result2 = $dbh->query("SELECT id, email, seats, locked, lat, lng, parties, des FROM drivers WHERE id = {$id_driver}")) {
      echo "db-error";
      exit;
    }
    $result2 = $result2->fetch_array(MYSQLI_ASSOC);

    $details = [];
    array_push($details, $result1);
    array_push($details, $result2);


    if (!$result3 = $dbh->query("SELECT * FROM requests WHERE id_driver = {$id_driver}")) {
      echo "db-error";
      exit;
    }
    $reqs = [];
    while($row = $result3->fetch_assoc()) $reqs[] = $row;

    array_push($details, $reqs);

    echo json_encode($details);
  }

  // Get working state
  if ($_POST["selector"] === "working" && isset($_SESSION["id"])) {
    // Sanitize inputs
    $id_driver = mysqli_true_escape_string($dbh, $_SESSION['id']);

    if (!$result = $dbh->query("SELECT working FROM drivers WHERE id = {$id_driver}")) {
      echo "db-error";
      exit;
    }
    $result = $result->fetch_array(MYSQLI_ASSOC);

    echo json_encode($result);
  }

  // Set working state to 1
  if ($_POST["selector"] === "begin-working" && isset($_SESSION["id"])) {
    // Sanitize inputs
    $id_driver = mysqli_true_escape_string($dbh, $_SESSION['id']);

    if (!$result = $dbh->query("UPDATE drivers SET working = 1 WHERE id = {$id_driver}")) {
      echo "db-error";
      exit;
    }
  }

  // Set working state to 0
  if ($_POST["selector"] === "stop-working" && isset($_SESSION["id"])) {
    // Sanitize inputs
    $id_driver = mysqli_true_escape_string($dbh, $_SESSION['id']);

    if (!$result = $dbh->query("SELECT * FROM requests WHERE id_driver = {$id_driver}")) {
      echo "db-error";
      exit;
    }

    $pass = [];
    while($row = $result->fetch_assoc()) $pass[] = $row;

    if (count($pass) == 0) {
      if (!$result = $dbh->query("UPDATE drivers SET working = 0 WHERE id = {$id_driver}")) {
        echo "db-error";
        exit;
      }
      echo "1";
      exit;
    } else {
      echo "0";
      exit;
    }
  }

  // Get request list
  if ($_POST["selector"] === "get-passengers" && isset($_SESSION["id"])) {
    // Sanitize inputs
    $id_driver = mysqli_true_escape_string($dbh, $_SESSION['id']);

    if (!$result = $dbh->query("SELECT * FROM requests WHERE id_driver = {$id_driver}")) {
      echo "db-error";
      exit;
    }

    $pass = [];
    while($row = $result->fetch_assoc()) $pass[] = $row;
    echo json_encode($pass);
  }

  // Get driver location
  if ($_POST["selector"] === "get-location" && isset($_SESSION["id"])) {
    $_SESSION["id"] = mysqli_true_escape_string($dbh, $_SESSION["id"]);

    if (!$result = $dbh->query("SELECT lat, lng FROM drivers WHERE id={$_SESSION['id']} LIMIT 1")) {
      echo "db-error";
      exit;
    }
    $result = $result->fetch_array(MYSQLI_ASSOC);
    echo json_encode($result);
  }

  // Get driver location
  if ($_POST["selector"] === "initialization" && isset($_SESSION["id"])) {
    $lat = $_POST["lat"];
    $lng = $_POST["lng"];
    $pass = $_POST["pass"];

    if (!$result = $dbh->query("UPDATE drivers SET lat = {$lat}, lng = {$lng}, seats = {$pass} WHERE id={$_SESSION['id']}")) {
      echo "db-error";
      exit;
    } 
    echo "success";
  }



}

mysqli_close($dbh);
?>