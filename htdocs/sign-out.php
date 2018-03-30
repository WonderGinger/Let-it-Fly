<?php
session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) session_destroy();

header("location: sign-in");
exit();
?>