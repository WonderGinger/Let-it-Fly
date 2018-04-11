<!-- One of the two ways of doing map display logic.-->
<div class="container">
    <p id="debug"></p>
    <div class="section teal-text lighten-1 center-align">
        <div class="row">
            <a id="working-toggle" class="col s12 waves-effect green lighten-1 waves-light btn-large progress">START</a>
        </div>
        <div class="row">
            <div class="progress" id="progress" style="visibility: hidden"><div class="determinate" id="preload"></div></div>  
        </div>
        <div class="row">
            <p id="waiting-message"></p>
        </div>

    </div>
    
</div>
<div id="map"></div>



<?php
// Add ID to session
    if (!$result = $dbh->query("SELECT * FROM drivers WHERE email='{$_SESSION['email']}' LIMIT 1")) echo $result;
    $result = $result->fetch_array(MYSQLI_ASSOC);
    $_SESSION["id"] = $result["id"];
?>
