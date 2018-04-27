<?php
require_once "utilities.php";

if (!$result = $dbh->query("SELECT * FROM requests")) db_error();

$requests = [];
while($row = $result->fetch_assoc()) $requests[] = $row;

for ($i = 0; $i < count($requests); $i++) {
  $time = $requests[$i]["eta_1"];
  $route_id = $requests[$i]["id"];
  $route = shrink(json_decode($requests[$i]["polyline_1"], true));
  $seats = $requests[$i]["seats"];
  $id_driver = $requests[$i]["id_driver"];

  if ($time + 60 >= count($route) * 60) {
    if ($requests[$i]["polyline_2"] === null) {
      if (!$result = $dbh->query("DELETE FROM requests WHERE id = {$route_id}")) db_error();

      if (!$result = $dbh->query("UPDATE drivers SET seats = seats + {$seats}, parties = parties - 1, des = NULL WHERE id = {$id_driver}")) db_error();
    } else {
      // switch to new route and release lock

      $poly_2 = $requests[$i]["polyline_2"];
      if (!$result = $dbh->query("UPDATE requests SET polyline_1 = '{$poly_2}', polyline_2 = NULL, eta_1 = 0, eta_2 = NULL WHERE id = {$route_id}")) db_error();

      if (!$result = $dbh->query("UPDATE drivers SET locked = 0 WHERE id = {$id_driver}")) db_error();
    }
  } else {
    if (!$result = $dbh->query("UPDATE requests SET eta_1 = eta_1 + 60 WHERE id = {$route_id}")) db_error();

    $lat = $route[($time + 60) / 60]["lat"];
    $lng = $route[($time + 60) / 60]["lng"];

    if (!$result = $dbh->query("UPDATE drivers SET lat = {$lat}, lng = {$lng}  WHERE id = {$id_driver}")) db_error();
  }
}

function shrink($path) {
  $waypoints = [];
  array_push($waypoints, $path[0]);

  $n = 0;
  for ($i = 1; $i < count($path) - 1; $i++) {
    if ($path[$i]["eta"] >= $n) {
      array_push($waypoints, $path[$i]);
      $n += 60;
    }
  }
  array_push($waypoints, $path[count($path) - 1]);

  return $waypoints;
}

mysqli_close($dbh);
?>