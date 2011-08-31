<?php
class manageIniFilesClass {
    static function readIniFile($path_file) {

        if(!is_file($path_file)) return false;

        $cfg=array();
        $base='';
        $handle=fopen($path_file,'r');
        if($handle) {
            while (!feof($handle)) {
                $line=fgets($handle);
                $line=trim($line);
                if(empty ($line)) continue;

                if(strpos($line,'[')!==false && strpos($line,']')!==false ) {
                    $k=array('[',']');
                    $base=str_replace($k,'',$line);
                }else {
                    if(empty($base)) {
                        $lag=split('=',$line);
                        $cfg[trim($lag[0])]=trim($lag[1]);
                    }else {
                        $lag=split('=',$line);
                        $cfg[$base][trim($lag[0])]=trim($lag[1]);
                    }
                }
                
            }
            fclose($handle);
        }else {
            exceptionHandlerClass::saveError("Error opening ini file : $path_file ");
            return false;
        }
        return $cfg;
    }

    static function writeIniFile($path_file,$lines) {
        $handle=fopen($path_file,'w');
        $result=true;
        if($handle) {
            foreach($lines as $ind=>$value) {

                if(is_array($value)) {
                    foreach($value as $ind2 => $value2 ) {
                        if(strpos($value2,'=')===false) {
                            if( fputs($handle,$ind2."=".$value2."\n") === false ) {
                                exceptionHandlerClass::saveError("Error writing ini file");
                                $result= false;
                            }
                        }else {
                            if( fputs($handle,$ind2."=".$value2."\n") === false ) {
                                exceptionHandlerClass::saveError("Error writing ini file");
                                $result=false;
                            }
                        }
                    }

                }else {
                    if( fputs($handle,$ind."=".$value."\n") === false ) {
                        exceptionHandlerClass::saveError("Error writing ini file");
                        $result=false;
                    }
                }
            }
            fclose($handle);
        }else {
            exceptionHandlerClass::saveError("Error opening ini file 2");
            $result=false;
        }
        return true;
    }

    static function writeWinIniFile($path_file,$lines) {

        $handle=fopen($path_file,'w');
        if($handle) {
            foreach($lines as $ind=>$value) {

                if(is_array($value)) {
                    if( fputs($handle,"[{$ind}]\r\n") === false ) {
                        exceptionHandlerClass::saveError("Error writing ini file");
                    }
                    foreach($value as $ind2 => $value2 ) {
                        if(strpos($value2,'=')===false) {
                            if( fputs($handle,$ind2."=".$value2."\r\n") === false ) {
                                exceptionHandlerClass::saveError("Error writing ini file");
                            }
                        }else {
                            if( fputs($handle,$ind2."=".$value2."\r\n") === false ) {
                                exceptionHandlerClass::saveError("Error writing ini file");
                            }
                        }
                    }

                }else {
                    if(strpos($value2,'=')===false) {
                        if( fputs($handle,$ind2."=".$value2."\r\n") === false ) {
                            exceptionHandlerClass::saveError("Error writing ini file");
                        }
                    }else {
                        if( fputs($handle,$ind2."=".$value2."\r\n") === false ) {
                            exceptionHandlerClass::saveError("Error writing ini file");
                        }
                    }
                }
            }
            fclose($handle);
        }else {
            exceptionHandlerClass::saveError("Error opening ini file 2");
        }
    }

}
?>
