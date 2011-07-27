<?php
require_once('dbcon.php');

define('_MAXDELTASEC',300);


function taskListImages($hddid) {
    if(defined($PCID) && $PCID=='mac'){
        $sql="SELECT T.id, T.oiimages_id,T.disk,T.partition, T.is_boot, T.day, T.hour, T.associate FROM  my_task T INNER JOIN pc P ON T.pc_id=P.id WHERE P.mac='{$hddid}' AND is_imageset=0";
    }else{
        $sql="SELECT T.id, T.oiimages_id,T.disk,T.partition, T.is_boot, T.day, T.hour, T.associate FROM  my_task T INNER JOIN pc P ON T.pc_id=P.id WHERE P.hddid='{$hddid}' AND is_imageset=0";
    }
    $result = mysql_query($sql);

    if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        echo '<BR/>'.$sql.'<BR/>';
        exit;
    }

    $t=array();
    while ($row = mysql_fetch_assoc($result)) {
        $r=array();
        foreach(array_keys($row) as $field) {
            $r[$field]= $row[$field];
        }
        $r['size']=0;
        $r['position']="";
        $t[]=$r;
    }
    $zz=getTaskToDoNow($t);
    return $zz;

}


function taskListImageSet($hddid) {

    if(defined($PCID) && $PCID=='mac'){
        $sql="SELECT T.id, S.oiimages_id,T.disk,T.partition,S.size, S.position, T.is_boot, T.day, T.hour, T.associate FROM  my_task T INNER JOIN pc P ON T.pc_id=P.id  INNER JOIN asign_imageset S ON T.imageset_id=S.imageset_id WHERE P.mac='{$hddid}' AND is_imageset=1 ORDER BY S.position";
    }else{
        $sql="SELECT T.id, S.oiimages_id,T.disk,T.partition,S.size, S.position, T.is_boot, T.day, T.hour, T.associate FROM  my_task T INNER JOIN pc P ON T.pc_id=P.id  INNER JOIN asign_imageset S ON T.imageset_id=S.imageset_id WHERE P.hddid='{$hddid}' AND is_imageset=1 ORDER BY S.position";
    }
    $result = mysql_query($sql);

    if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        echo '<BR/>'.$sql.'<BR/>';
        exit;
    }

    $t=array();
    while ($row = mysql_fetch_assoc($result)) {
        $r=array();
        foreach(array_keys($row) as $field) {
            $r[$field]= $row[$field];
        }
                
        $t[]=$r;
    }
    $zz=getTaskToDoNow($t);
    return $zz;

}


function getTaskToDoNow($taskList) {
    $toDo=array();
    foreach ($taskList as $task ){
        if ($task['associate']==1 ) {
            $toDo[]=$task;
        }
    }

    foreach ($taskList as $task ) {
        $now=time();
        if( empty($task['day']) && !empty($task['hour'])) {
            $h=split(':',$task['hour']);
            $timeToDeploy=mktime($h[0],$h[1], 0, date('m'),date('d'),date('Y') );
        }else {
            $h=split(':',$task['hour']);
            $d=split('-',$task['day']);
            $timeToDeploy=mktime($h[0],$h[1], 0, $d[1],$d[2],$d[0] );
        }
        $timeToDeployLimit=$timeToDeploy+_MAXDELTASEC;

        //echo "<br><br>task ".$task['partition']."toDooooo:: now: ".date('Y-m-d H:i:s',$now );
        //echo " timeToDeploy: ".date('Y-m-d H:i:s',$timeToDeploy )."  timeToDeployLimit:".date('Y-m-d H:i:s',$timeToDeployLimit );

        if(  $now >= $timeToDeploy && $now < $timeToDeployLimit  ) {
            $toDo[]=$task;
        }
    }
    return $toDo;
}



/*
 *
 * MAIN
 *
*/

if(!isset($_POST['hwId'])){
    echo "Agur!";
    exit;
}

$hwId=unserialize(base64_decode($_POST['hwId']));
if(defined($PCID) && $PCID=='mac'){
    $hwId['id']=substr($hwId['id'], 0, 12 );
}
$taskList=taskListImages($hwId['id']);
$taskLists=taskListImageSet($hwId['id']);

$taskList=array_merge($taskList,$taskLists);
$out=base64_encode(serialize($taskList));
echo "!@@@$out!@@@";
file_put_contents('/tmp/task.log', "\n",FILE_APPEND );

?>
