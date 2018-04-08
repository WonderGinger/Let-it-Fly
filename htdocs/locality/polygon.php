<?php
$lines = file("raw/santa-cruz.txt", FILE_IGNORE_NEW_LINES);
for ($i = 0; $i < count($lines); $i++) {
  $parse = explode(", ", $lines[$i]);
  echo "new google.maps.LatLng(" . $parse[1] . ", " . $parse[0] . ")";
  if ($i != count($lines) - 1) echo ",";
  echo "<br>";
}
?>