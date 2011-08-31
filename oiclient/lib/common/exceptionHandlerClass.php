<?php
class exceptionHandlerClass {

	/**
	 * Inicializar los mensajes
	 */
        

	private static function initialize($type){
		$sfUser = sfContext::getInstance()->getUser();
		$sfUser->setAttribute($type, array());
                $sfUser->setAttribute('save', true);
	}

        static function spoolException($spoolException){
            $sfUser = sfContext::getInstance()->getUser();
            if(is_bool($spoolException)){
                $sfUser->setAttribute('spoolException', $spoolException);
            }
        }

	/**
	 * Añadir un nuevo error
	 */
	static function saveError($error){
            
            $sfUser = sfContext::getInstance()->getUser();
            $spoolException=$sfUser->getAttribute('spoolException');
            if(!is_bool($spoolException) ) $spoolException=true;

            if($spoolException){
                $errors = $sfUser->getAttribute('error');
                if(!is_array($errors) || end($errors)!=$error ){
                    $errors[] = $error;
                    $sfUser->setAttribute('error', $errors);
                }
            }else{
                echo "<br>Error ".date('H:i:s ').': '.$error;
                
            }
            if(ImageServerOppClass::is_validServer()){
                ImageServerOppClass::saveLog( "Error ".date('h:i:s ').': '.$error);
            }
	}

	static function saveMessage($message){
            
            $sfUser = sfContext::getInstance()->getUser();
            $spoolException=$sfUser->getAttribute('spoolException');
            if(!is_bool($spoolException) ) $spoolException=true;

            if($spoolException){
                $messages = $sfUser->getAttribute('message');
                if(!is_array($messages) || end($messages)!=$message ){
                    $messages[] = $message;
                    $sfUser->setAttribute('message', $messages);
                }
            }else{
                echo "<br>Message ".date('H:i:s ').': '.$message;
                
            }
            if(ImageServerOppClass::is_validServer()){
                ImageServerOppClass::saveLog( "Message ".date('h:i:s ').': '.$message);
            }

	}

        static function serverLog($message){
            if(ImageServerOppClass::is_validServer()){
                ImageServerOppClass::saveLog( "Message ".date('h:i:s ').': '.$message);
            }
        }

	static function doLog($message){
		if(sfConfig::get('sf_logging_enabled')){
			sfContext::getInstance()->getLogger()->info($message);	
		}
	}

        static function process($message){

            if (!is_writable(sfConfig::get('app_command_processLog'))) {
                $r=executeClass::execute(sfConfig::get('app_command_cleanProcess'));
            }
            file_put_contents(sfConfig::get('app_command_processLog'), $message);
        }

        static function doLogFile($message){
            //file_put_contents('/tmp/oi.log', $message ,FILE_APPEND);

        }

	static function exists($type)
	{
		$sfUser = sfContext::getInstance()->getUser();
		$data = $sfUser->getAttribute($type);

		return !empty($data);
	}

	static function listMessages($type, $mode='html'){
            $list='';
            $sfUser = sfContext::getInstance()->getUser();
            $messages = $sfUser->getAttribute($type);

            if(count($messages)>0) {
                exceptionHandlerClass::initialize($type);
                if($mode=='html'){
                    $list= implode('</li><li>',$messages);
                }elseif($mode=='txt'){
                    $list= implode("\n",$messages);
                }else{
                    $list= $messages;
                }
            }
            
            return $list;
	}

        static function listAll(){
            $list='0';
            $messages=self::listMessages('message');
            if(! empty ($messages)) {
                $list .="<br>Messages: <ul>$messages</ul>";
            }
            $errors=self::listMessages('error');
            if(! empty ($errors)) {
                $list .="<br>Errors: <ul>$errors</ul>";
            }
            return $list;

        }
        
        static function listAlljson(){
            $result=array();
            $messages=self::listMessages('message','array');
            $errors=self::listMessages('error','array');
            
            if(is_array($messages) && count($messages)>0) {
                //$result['messages']=$messages;
                $result=array_merge($result,$messages);
            }
            
            if(is_array($errors) && count($errors)>0) {
                //$result['errors']=$errors;
                $result=array_merge($result,$errors);
            }
            return json_encode($result);

        }

	static function errorHandler($errno, $errstr, $errfile, $errline){
		exceptionHandlerClass::saveError("###errorea##:: $errno, $errstr, $errfile, $errline");
		return true;
	}
}
?>
