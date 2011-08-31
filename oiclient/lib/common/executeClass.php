<?php

class executeClass {
    static function StrExecute($cmd) {
        $r=exec($cmd,$e1,$e2);
        $rr=var_export($e2,1);
  //exceptionHandlerClass::saveError("StrExecute:: ".print_r($r,1)." " .print_r($e2,1)."" );
        return implode("\n",$e1);
    }

    static function ArrExecute($cmd) {
        $r=exec($cmd,$e1,$e2);
        //exceptionHandlerClass::saveError('cmd='.$cmd);
        //exceptionHandlerClass::saveError($r);
        return $e1;
    }

    static function execute($cmd) {
        $r=exec($cmd,$e1,$e2);
        return array('return'=>$e2,'output'=>$e1);
    }


    static function executeProc($cmd ) {
        /*
         * Funtzio honetan emaitza pantaiaratzen joan behar du bukaerara sai egon gabe.
         */
//        flush();
//        ob_start();
//        ob_implicit_flush(true);
        //$handle=popen("$cmd 2>&1 ",'r' );
        $handle=exec("$cmd 2>&1", $output, $return);
        if($return === false || $return != 0 ) {
            print implode("<br>",$output);
            return false;
        }else{
            return true;
        }

//        ob_end_flush();
//            pclose($handle);


    }

    static function readLog($log) {
        //$read='aaaa';
        $read='';
        if(is_file($log)) {
            $resource = fopen($log,'r');
            $read .= fread($resource, filesize($log));
            fclose($resource);
        }

        return $read;

    }

    static function closeProc($resource) {
        pclose($resource);
    }
}


?>
