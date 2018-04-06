<?php
// Receive array from JS
if(isset($_POST["data"]))
{
    $data = json_decode($_POST["data"]);
    $myarray = $data->myarray;
    foreach($myarray as $singular)
    {
      echo "something<br>";
    }
}
?>