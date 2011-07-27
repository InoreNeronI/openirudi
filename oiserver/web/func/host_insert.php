<?php

require_once('dbcon.php');

if(isset($_REQUEST['out_params'])){
    $req=base64_decode($_REQUEST['out_params']);
    //
    $val=explode('!@@@',$req);
    if(!isset($val[1]) || empty($val[1])){
        echo "!@@@!@@@";
        exit;
    }

    $sarrera=explode('#!#',$val[1]);

    $args=array();
    foreach($sarrera as $i=>$row){
        $myArray=explode("=",$row);
        $args[$myArray[0]]=$myArray[1];
    }
   //$args['created_at']=date('Y-m-d H:i:s');
   echo print_r($args,1);
   if(!isset($args['ip']) || empty($args['ip'])){
       $args['ip']=''; $args['netmask']=''; $args['gateway']=''; $args['ip']='';$args['dns']='';
   }
   if(defined($PCID) && $PCID=='mac'){
    $badago="SELECT * FROM pc WHERE mac='${args['mac']}'";
   }else{
    $badago="SELECT * FROM pc WHERE mac='${args['mac']}' AND hddid='${args['hddid']}'";
   }
   $result = mysql_query($badago);
   if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        echo '<BR/>'.$badago.'<BR/>';
        exit;
   }

   $rows=mysql_affected_rows();

    if($rows == 0 ){
       //	id 	mac 	hddid 	name 	ip 	netmask 	gateway 	dns 	pcgroup_id 	partitions
       $sql='INSERT INTO pc(mac,hddid,name,ip,netmask,gateway,dns,partitions) VALUES("'.$args['mac'].'","'.$args['hddid'].'","'.$args['name'].'","'.$args['ip'].'","'.$args['netmask'].'","'.$args['gateway'].'","'.$args['dns'].'",\''.$args['partitions'].'\')';
       $result = mysql_query($sql);

        if (!$result) {
            echo "DB Error, could not query the database\n";
            echo 'MySQL Error: ' . mysql_error();
            echo '<BR/>'.$sql.'<BR/>';
            exit;
        }
        echo "!@@@".  base64_encode(serialize(mysql_insert_id()))."!@@@";
    }else{
      //	id 	mac 	hddid 	name 	ip 	netmask 	gateway 	dns 	pcgroup_id 	partitions
        if(defined($PCID) && $PCID=='mac'){
            $sql='UPDATE pc SET name="'.$args['name'].'",ip="'.$args['ip'].'",netmask="'.$args['netmask'].'",gateway="'.$args['gateway'].'",dns="'.$args['dns'].'",partitions=\''.$args['partitions'].'\', hddid=\''.$args['hddid'].'\'  WHERE mac="'.$args['mac'].'"';
        }else{
            $sql='UPDATE pc SET name="'.$args['name'].'",ip="'.$args['ip'].'",netmask="'.$args['netmask'].'",gateway="'.$args['gateway'].'",dns="'.$args['dns'].'",partitions=\''.$args['partitions'].'\' WHERE mac="'.$args['mac'].'" AND hddid="'.$args['hddid'].'"';
        }
        $result = mysql_query($sql);


        if (!$result) {
            echo "DB Error, could not query the database\n";
            echo 'MySQL Error: ' . mysql_error();
            echo '<BR/>'.$sql.'<BR/>';
            exit;
        }
        echo "!@@@".base64_encode(serialize("UPDATE"))."!@@@";

    }

}else{
    echo 'out_params request?';
}
?>


