<?

#
#
# Tknika
# pendingTask($mac) returns:
#       true: pending tasks
#       false: no pending tasks
#

require_once('dbcon.php');


define('_MAXDELTASEC',120000);

function pendingTask($mac){
    $day=date('Y-m-d');
    $hour=date('H:i:00');

    $sql="SELECT P.id as PID,T.id as TID, mac, day, hour, TIME_TO_SEC(IF(ISNULL(day), TIMEDIFF(hour,'$hour' ), TIMEDIFF( TIMESTAMP(day,hour),'$day $hour' ) )) as DIFF  FROM  my_task T  INNER JOIN pc P ON P.id=T.pc_id  ";
    //$sql.="WHERE associate=0";
    $sql.="WHERE associate=0 HAVING DIFF <= 0 AND DIFF > -"._MAXDELTASEC;

    $result = mysql_query($sql);

    if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        echo '<BR/>'.$sql.'<BR/>';
        exit;
    }


    $t=array();
    while ($row = mysql_fetch_assoc($result)) {
        $g=str_split($row['mac'],2);
        $t[]=implode(':',$g);
        if ($t[0] == $mac){
                return true;
        } else {
                return false;
        }
    }
    #echo "<br>mac:: ".print_r($t,1);

    return $t;
}

?>
