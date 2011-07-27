<?php

require_once('dbcon.php');

if(!isset($_POST['hwId'])){
    echo "Agur!";
    exit;
}

$hwId=unserialize(base64_decode($_POST['hwId'])  );

$hwId['hddid']=trim($hwId['hddid']);
$hwId['mac']=trim($hwId['mac']);

 if(defined($PCID) && $PCID=='mac'){
    $sql="SELECT * FROM  pc WHERE mac='{$hwId['mac']}'";
 }else{
    $sql="SELECT * FROM  pc WHERE mac='{$hwId['mac']}' AND hddid='{$hwId['hddid']}'";
 }

$result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    echo '<BR/>'.$sql.'<BR/>';
    exit;
}

$host=array();
while ($row = mysql_fetch_assoc($result)) {
    $host=$row;
}

$out=base64_encode(serialize($host));
echo "!@@@$out!@@@";

?>
