<?php
$DB='openirudiDB';
$DBUSER='openirudi';
$DBPWD='openirudi';

$link = mysql_connect('localhost', $DBUSER, $DBPWD);
if (!$link) {
    echo 'Could not connect: ' . mysql_error();exit();
}

if (!mysql_select_db($DB, $link)) {
    echo 'Could not select database';
    exit;
}

?>
