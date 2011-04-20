<?php
define('ROOT','/oiImages/' );
require_once('dbcon.php');

if(isset($_REQUEST['id'])){

}

   $sql='SELECT * FROM  oiimages ORDER BY oiimages.id DESC';

   $result = mysql_query($sql);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    echo '<BR/>'.$sql.'<BR/>';
    exit;
}


while ($row = mysql_fetch_assoc($result)) {
    $r=array();
    foreach(array_keys($row) as $field) {
        $r[]="{$field}=".$row[$field];
    }
    
    chdir(ROOT);
    $fileList=glob("oiImage_{$row['id']}.f*");
    $r[]="files=".implode(',', $fileList );
    
    $size=0;
    foreach ( $fileList as $file){
      $size+=filesize(ROOT.$file);
    }
    $r[]="size=$size";
    
    $t[]=implode('#!#', $r);
    
}

$total=implode('%#%',$t);

$out=base64_encode($total);
echo "!@@@$out!@@@";

?>
