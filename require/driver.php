
<p id="ajax"></p>

<!-- One of the two ways of doing map display logic.-->
<div class="container">
    <div class="section teal-text lighten-3 center-align">
        <a id="working-toggle" class="waves-effect green lighten-1 waves-light btn-large">START</a>
    </div>
</div>

<?php
if (!$result = $dbh->query("SELECT * FROM drivers WHERE email='{$_SESSION['email']}' LIMIT 1")) echo $result;
$result = $result->fetch_array(MYSQLI_ASSOC);
$_SESSION["id"] = $result["id"];

// One way of checking if the map should be displayed, the other being through JS switch.
if($result["working"]) echo <<<MAP
<div id="map"></div>
MAP;

// Toggle WORKING column in database:
// if (!$result = $dbh->query("UPDATE drivers SET working=!working WHERE id='{$_SESSION['id']}'")) db_error();


?>
