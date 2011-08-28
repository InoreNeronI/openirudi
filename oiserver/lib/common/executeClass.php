<?php


class executeClass {
	static function StrExecute($cmd) {
		$r=exec($cmd,$e1,$e2);
		$rr=var_export($e2,1);
		//exceptionHandlerClass::saveError($r);
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

	static function executeProc($cmd, $log) {
		exceptionHandlerClass::saveMessage("$cmd &> $log &");
		$resource = popen("$cmd &> $log &", 'r');

		exceptionHandlerClass::saveMessage('resource='.print_r($resource,1));
		return $resource;
	}

	static function readLog($log) {
		$read='';
		if(is_file($log)){
			$resource = fopen($log,'r');
			$read = fread($resource, filesize($log));
			fclose($resource);
		}
		return $read;
	}

	static function closeProc($resource){
		pclose($resource);
	}
        
} ?>