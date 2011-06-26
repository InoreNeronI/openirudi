<?php
/* Redirect to a oiserver/web/ */
$host  = $_SERVER['HTTP_HOST'];
header("Location: http://$host/oiserver/index.php");
exit;

?>
