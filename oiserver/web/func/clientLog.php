<?php

define('LOGFILE','/tmp/openirudi.log');

if(!isset($_POST['log'])){
    echo "<br>No log<br>";
    exit;
}

$logs=unserialize(base64_decode($_POST['log']));
$d='';
foreach ($logs as $log){
    $d.="\n". $_SERVER['REMOTE_ADDR'] ."-->  ".$log;
}

file_put_contents( LOGFILE, $d, FILE_APPEND | LOCK_EX);




?>
