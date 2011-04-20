<?php
define('ROOT','/oiImages/' );
require_once('dbcon.php');

if(isset($_REQUEST['id'])){

}

$sql1='SELECT * FROM  imageset ORDER BY imageset.id DESC';
$result1 = mysql_query($sql1);

if (!$result1) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    echo '<BR/>'.$sql.'<BR/>';
    exit;
}

$r=array();
while ($row1 = mysql_fetch_assoc($result1)) {
    $sql2='SELECT *  FROM asign_imageset S, oiimages I WHERE S.imageset_id= '.$row1['id'].' AND S.oiimages_id=I.id  ORDER BY S.position ASC';

    $r[$row1['id']]['id']=$row1['id'];
    $r[$row1['id']]['name']=$row1['name'];
    $result2 = mysql_query($sql2);
    $i=0;
    while ($row2 = mysql_fetch_assoc($result2)) {
        $r[$row1['id']]['oiimages'][$i]['id']=$row2['oiimages_id'];
        $r[$row1['id']]['oiimages'][$i]['os']=$row2['os'];
        $r[$row1['id']]['oiimages'][$i]['size']=$row2['size'];
        $r[$row1['id']]['oiimages'][$i]['position']=$row2['position'];
        $i++;
    }
}

$out=base64_encode(serialize($r));
echo "!@@@$out!@@@";



?>
