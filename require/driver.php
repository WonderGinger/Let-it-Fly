<?php
if (!$result = $dbh->query("SELECT * FROM drivers")) echo $result;
$result = $result->fetch_array(MYSQLI_ASSOC);
print_r($result);
?>