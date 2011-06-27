<?php
/* Redirect to a oiserver/web/ */
$host  = $_SERVER['HTTP_HOST'];
  header("Location: http://$host/oiserver/web/index.php");
exit;

?>
