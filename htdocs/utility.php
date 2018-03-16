<?php
function mysql_entities_fix_string($connection, $string) {
    return htmlentities(mysql_fix_string($connection, $string));
}
function mysql_fix_string($connection, $string) {
    if(get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connection->real_escape_string($string);
}
function display_error_page(){
    header("Location: http://www.sjsu.edu/");
    exit();
}
?>