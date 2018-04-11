
<!-- One of the two ways of doing map display logic.-->
<div class="container">
    <div class="section teal-text lighten-3 center-align">
        <div class="row">
            <a id="working-toggle" class="col s12 waves-effect green lighten-1 waves-light btn-large">START</a>
        </div>
    </div>
</div>


<?php

if (!$result = $dbh->query("SELECT * FROM drivers WHERE email='{$_SESSION['email']}' LIMIT 1")) echo $result;
$result = $result->fetch_array(MYSQLI_ASSOC);
$_SESSION["id"] = $result["id"];

// Toggle WORKING column in database:
// if (!$result = $dbh->query("UPDATE drivers SET working=!working WHERE id='{$_SESSION['id']}'")) db_error();


?>
