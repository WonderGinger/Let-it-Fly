<?php
require_once "../private/utilities.php";
session_start();

// Redirect user to sign-in if not logged in
if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
  echo "{error: \"not signed in\"}";
  exit();
}

$data = json_decode(file_get_contents('php://input'), true);
push_route($data);
echo "{}";