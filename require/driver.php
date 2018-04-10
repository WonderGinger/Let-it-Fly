<?php
    if (!$result = $dbh->query("SELECT * FROM drivers")) echo "fail";
    // $result = $result->fetch_array(MYSQLI_ASSOC);
?>