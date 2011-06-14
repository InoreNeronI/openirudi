<?
require_once('dbcon.php');

define('_MAXDELTASEC',300);
define('HEX2BIN_WS', " \t\n\r");
define('_PWD','sjdlaksjda90qwñaslkdSS');

function hex2bin($hex_string) {

$pos = 0;
    $result = '';
    while ($pos < strlen($hex_string)) {
      if (strpos(HEX2BIN_WS, $hex_string{$pos}) !== FALSE) {
        $pos++;
      } else {
        $code = hexdec(substr($hex_string, $pos, 2));
            $pos = $pos + 2;
        $result .= chr($code);
      }
    }
    return $result;
}
    

function clientParams(){
    $sql="SELECT * FROM my_client";


    $result = mysql_query($sql);

    if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        echo '<BR/>'.$sql.'<BR/>';
        exit;
    }

    while ($sclient = mysql_fetch_assoc($result)) {
        $jaso2=explode('#@#@#',$sclient['password']);
        $iv2=hex2bin($jaso2[1]);
        $sclient['password'] = md5( trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, _PWD , hex2bin($jaso2[0]), MCRYPT_MODE_ECB, $iv2)) );
        return $sclient;
    }

    return null;


}

function pendingTask($mac){
    $day=date('Y-m-d');
    $hour=date('H:i:00');

    $sql="SELECT P.id as PID,T.id as TID, mac, day, hour, TIME_TO_SEC(IF(ISNULL(day), TIMEDIFF(hour,'$hour' ), TIMEDIFF( TIMESTAMP(day,hour),'$day $hour' ) )) as DIFF  FROM  my_task T  INNER JOIN pc P ON P.id=T.pc_id  ";
    $sql.="WHERE associate=0 HAVING DIFF <= 0 AND DIFF > -"._MAXDELTASEC;

    $result = mysql_query($sql);

    if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        echo '<BR/>'.$sql.'<BR/>';
        exit;
    }

    while ($row = mysql_fetch_assoc($result)) {
        if ($row['mac'] == $mac){
                return true;
        }
    }
    return false;
}

?>
