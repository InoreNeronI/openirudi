<?php

require_once('dbcon.php');


$sql='SELECT * FROM  my_client';
$result = mysql_query($sql);


if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    echo '<BR/>'.$sql.'<BR/>';
    exit;
}

$client=array();
while ($row = mysql_fetch_assoc($result)) {
    $client=$row;
}
print_r($client);
$client['now']=time();
$out=base64_encode(serialize($client));
echo "!@@@$out!@@@";
