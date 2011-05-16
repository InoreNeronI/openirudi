<?php

require_once('dbcon.php');
if(!isset($_REQUEST['out_params'])) {
    echo '<br>out_params request parametroa beharrezkoa da<br>';
}

    $req=base64_decode($_REQUEST['out_params']);
    $args=unserialize($req);

 //file_put_contents('/tmp/create.log', "-jaso2::-".print_r($req,1),FILE_APPEND);

    //$val=explode('!@@@',$req);


//    if(!isset($val[1]) || empty($val[1])) {
//        echo "!@@@!@@@";
//        exit;
//    }
//
//    $sarrera=explode('#!#',$val[1]);
//
//    $args=array();
//    foreach($sarrera as $i=>$row) {
//        $myArray=explode("=",$row);
//        $args[$myArray[0]]=$myArray[1];
//    }


    if(isset($args['remove']) && is_numeric($args['remove'])) {
        $sql="DELETE FROM `oiimages` WHERE `oiimages`.`id` = {$args['remove']} LIMIT 1";
        $result = mysql_query($sql);
        
    } else {

        $args['created_at']=date('Y-m-d H:i:s');
        if(!isset($args['path'])) $args['path']='';
        $sql='INSERT INTO oiimages(name,description,os,uuid,created_at,partition_size,partition_type,filesystem_size,filesystem_type,path) VALUES("'.$args['name'].'","'.$args['description'].'","'.$args['os'].'","'.$args['uuid'].'","'.$args['created_at'].'",'.$args['partition_size'].','.$args['partition_type'].','.$args['filesystem_size'].',"'.$args['filesystem_type'].'","'.$args['path'].'")';
        $result = mysql_query($sql);
    }
    if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        echo '<BR/>'.$sql.'<BR/>';
        exit;
    }
    $myid=mysql_insert_id();

    $out=base64_encode(serialize($myid));

    echo "!@@@{$out}!@@@";


?>
