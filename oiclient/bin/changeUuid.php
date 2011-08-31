#!/usr/bin/php
<?php


if($argc==3){
    //if(is_dir($argv[1])){
        echo "\nchange {$argv[1]} partition uuid: {$argv[2]}";
        $f = fopen($argv[1], "c+b");
        fseek($f,72,SEEK_CUR );
        foreach(array_reverse(str_split(trim($argv[2]),2)) as $h){

          fwrite($f,chr(hexdec($h)));
        }
        fclose($f);
    //}
}
echo "\n";
?>
