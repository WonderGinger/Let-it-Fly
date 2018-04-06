<?php
require_once __DIR__ . "/../private/utilities.php";

if (!$result = $dbh->query("SELECT * FROM requests WHERE id='1'")) db_error();
$result = $result->fetch_array(MYSQLI_ASSOC);

$resultz = $result["time"];
$duration = ($resultz < 60) ? 0 : $resultz - 60;

if (!$result = $dbh->query("UPDATE requests SET time={$duration} WHERE id=1")) db_error();

/*
echo "<pre>";
echo "before: " . $resultz . "<br>";
echo "after : " . $duration . "<br>";
echo "</pre>";
*/

mysqli_close($dbh);
?>