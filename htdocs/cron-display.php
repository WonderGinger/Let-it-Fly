<?php
require_once __DIR__ . "/../private/utilities.php";

if (!$result = $dbh->query("SELECT * FROM requests WHERE id='1'")) db_error();
$result = $result->fetch_array(MYSQLI_ASSOC);

echo "<pre>";
echo "time: " . $result["time"] . "<br>";
echo "</pre>";

mysqli_close($dbh);
?>