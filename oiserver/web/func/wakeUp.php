<?php
/*
 * orain lana daukaten pc-ak esnatu
 *
 *
 *
 *
 */
define('_MAXDELTASEC',300);

function pcListToWakeUp(){
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
    }
    echo "<br>mac:: ".print_r($t,1);

    return $t;
}


function WakeOnLan($mac,$addr=false,$port=7) {
     //Usage
     //    $addr:
     //    You will send and broadcast tho this addres.
     //    Normaly you need to use the 255.255.255.255 adres, so i made it as default. So you don't need
     //    to do anything with this.
     //    Since 255.255.255.255 have permission denied problems you can use addr=false to get all broadcast address from ifconfig command
     //    addr can be array with broadcast IP values
     //    $mac:
     //    You will WAKE-UP this WOL-enabled computer, you need to add the MAC-addres here.
     //    Mac can be array too
     //
     //Return
     //    TRUE:    When socked was created succesvolly and the message has been send.
     //    FALSE:    Something went wrong
     //
     //Example 1
     //    When the message has been send you will see the message "Done...."
     //    if ( wake_on_lan('00:00:00:00:00:00'))
     //        echo 'Done...';
     //    else
     //        echo 'Error while sending';
     //
     if ($addr===false){
         exec("ifconfig | grep Bcast | cut -d \":\" -f 3 | cut -d \" \" -f 1",$addr);
         $addr=array_flip(array_flip($addr));
         $addr=$addr[0];
         echo "\naddr:: ".print_r($addr,1);
     }

     if(is_array($addr)){
         $last_ret=false;
         for ($i=0;$i<count($ret);$i++){
             if ($ret[$i]!==false){
                 $last_ret=WakeOnLan($mac,$ret[$i],$port);
                 sleep(1);
             }
         }
         return($last_ret);
     }
     if (is_array($mac)){
         $ret=array();
         foreach($mac as $k=>$v){
             $ret[$k]=WakeOnLan($v,$addr,$port);
             }
         return($ret);
     }
     //Check if it's an real MAC-addres and split it into an array
     $mac=strtoupper($mac);
     if (!preg_match("/([A-F0-9]{1,2}[-:]){5}[A-F0-9]{1,2}/",$mac,$maccheck))
         return false;
     $addr_byte = preg_split("/[-:]/",$maccheck[0]);

     //Creating hardware adress
     $hw_addr = '';
     for ($a=0; $a < 6; $a++){//Changing mac adres from HEXEDECIMAL to DECIMAL
         $hw_addr .= chr(hexdec($addr_byte[$a]));
     }
     //Create package data
     $msg = str_repeat(chr(255),6);
     for ($a = 1; $a <= 16; $a++){
         $msg .= $hw_addr;
     }
     //Sending data
     if (function_exists('socket_create')){
         //socket_create exists
         $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);    //Can create the socket
         if ($sock){
             $sock_data = socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1); //Set
             if ($sock_data){
                 $sock_data = socket_sendto($sock, $msg, strlen($msg), 0, $addr,$port); //Send data
                 if ($sock_data){
                     socket_close($sock); //Close socket
                     unset($sock);
                     return(true);
                 }
             }
         }
         socket_close($sock);
         unset($sock);
     }
  
     $sock=fsockopen("udp://" . $addr, $port);
     if($sock){
         $ret=fwrite($sock,$msg);
         fclose($sock);
     }
     if($ret)
         return(true);
     return(false);
 }


require_once('dbcon.php');
echo "<br>date:: ".date('Y-m-d H:i:s');

$macList=pcListToWakeUp();
if(is_array($macList) && count($macList)>0){
    echo "<br> Esnatu !!!!! ";
    WakeOnLan($macList,'255.255.255.255');
}

//$macList=array('00:05:5D:7B:1E:F6');
//echo "<br>aaaa2aaaa: ". print_r($macList);

?>
