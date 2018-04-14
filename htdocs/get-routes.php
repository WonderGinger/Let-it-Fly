<?php
require_once "../private/utilities.php";
session_start();

// Redirect user to sign-in if not logged in
if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
  echo "{error: \"not signed in\"}";
  exit();
}

$data = get_routes();
echo json_encode($data);