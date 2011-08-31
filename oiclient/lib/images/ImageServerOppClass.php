<?php
define('HEX2BIN_WS', " \t\n\r");

class ImageServerOppClass {

    static function address() {
        $address = sfYamlOI::readKey('imageServer');
        if (empty($address)) {
            return false;
        }
        return $address;
    }

    static function url() {
        $serverUrl = str_replace('$server', self::address(), sfConfig::get('app_server_imagesUrl'));
        return $serverUrl;
    }

    static function changeAddress($address) {
        $listOisystems=  systemOppClass::getListOisystems();
        $address=$listOisystems->setConfProperty('imageServer', $address);

        return self::is_validServer(true);
        
    }

    static function images() {

        if (!ImageServerOppClass::is_validServer()) {
            exceptionHandlerClass::saveError("Connect to valid server");
            return array();
        }
        $list = self::getServerContent2('/listImages.php');
        return $list;
    }

    static function getClientVersion() {

        if (!ImageServerOppClass::is_validServer(true)) {
            exceptionHandlerClass::saveError("Connect to valid server");
            return false;
        }
        
        $sclient = self::getServerContent2('/clientVersion.php');       
        if(is_array($sclient) && isset($sclient['user'] ) && !empty($sclient['password'])){
            $jaso2=explode('#@#@#',$sclient['password']);           
            $iv2=self::hex2bin($jaso2[1]);
            $sclient['password'] = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, sfConfig::get('app_const_pwd'), self::hex2bin($jaso2[0]), MCRYPT_MODE_ECB, $iv2));
            return $sclient;
        }
        return false;
        

    }
    
    private static function hex2bin($hex_string) {

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

    static function getImageInfo() {
        if (ImageServerOppClass::is_validServer()) {
            $info = self::getServerContent2('/imageInfo.php');
            return $info;
        }
        exceptionHandlerClass::saveError("Connect to valid server");
        return array();
    }

    static function imageSets() {

        if (!ImageServerOppClass::is_validServer()) {
            exceptionHandlerClass::saveError("Connect to valid server");
            return array();
        }
        $list = self::getServerContent2('/listImageSets.php');
        return $list;
    }

    static function checkServerStatus(){

        $v = self::getServerContent('/check.php');
        if (is_array($v)) {
            $res = array_pop($v[1]);
            if ($res == 'OK') {
                $validServer=true;
            } else {
                 $validServer=false;
            }
        } else {
             $validServer=false;
        }
        if($validServer){
            sfYamlOI::saveKey('validServer', 'OK');
        }else{
             sfYamlOI::saveKey('validServer', 'NO');
        }
        return $validServer;
    }
    

    static function is_validServer($check=false) {

        $validServer = sfYamlOI::readKey('validServer');       
        if($check===true || empty($validServer)){
            $validServer=self::checkServerStatus();
        }

        if ($validServer == 'OK') {
            return true;
        }else{
            return false;
        }
    }

   
    static function savePcConfig($registryArray) {

        if (!ImageServerOppClass::is_validServer(true)) {
            //exceptionHandlerClass::saveError("Connect to valid server");
            return false;
        }

        $data='out_params='.self::encodeGetParams($registryArray);
        $host1=self::doPostRequest('host_insert.php', $data);
        $r=self::decodeResult2($host1);

        if ($r === false) {
            return false;
        } else {
            return true;
        }
    }

    static function getPcConfig($mac,$hddid) {
        if (!ImageServerOppClass::is_validServer(true)) {
            //exceptionHandlerClass::saveError("Connect to valid server");
            return array();
        }

        $id=array('mac'=>$mac,'hddid'=>$hddid);
        $data='hwId='.base64_encode(serialize($id));
        $host1=self::doPostRequest('listHost.php', $data);
        $host=self::decodeResult2($host1);
        return $host;
    }


    static function getTasks() {
        if (!ImageServerOppClass::is_validServer()) {
            //exceptionHandlerClass::saveError("Connect to valid server");
            return array();
        }
        $hw=  systemOppClass::getComputer();
        $task = array();
        $data='hwId='.base64_encode(serialize(array('id'=>$hw->pcID)));
        $t=self::doPostRequest('taskList.php', $data);
        $tasks=self::decodeResult2($t);
        return $tasks;
    }

    static function getServerContent2($file='', $params='') {
        $address = self::address();
        if (empty($address)) {
            return null;
        }

        $serverUrl = str_replace('$server', $address, sfConfig::get('app_server_imagesUrl'));

        if (empty($params)) {
            $out = '';
        } elseif (is_array($params)) {
            $out = '?out_params=' . self::encodeGetParams($params);
        } else {
            $out = '?out_params=' . $params;
        }

        $result = @file_get_contents($serverUrl . '/' . $file . $out);
        if ($result === false) {
            return false;
        } else {
            $decoded = self::decodeResult2($result);
            return $decoded;
        }
    }

    static function decodeResult2($str) {

        $mat = array();
        if (empty($str))
            return $mat;

        if (strpos($str, '!@@@') === false
            )return true;

        $val = explode('!@@@', $str);
        if (!isset($val[1])) {
            exceptionHandlerClass::saveError("I cant read task list");
            exceptionHandlerClass::saveError("return value:" . $str);
            return false;
        }
        
        if (isset($val[1]) && !empty($val[1])) {


            $o = base64_decode($val[1]);
            $mat = unserialize($o);

            return $mat;
        } elseif (empty($val[1])) {
            return false;
        }

        return $mat;
    }

    static function getServerContent($file='', $params='') {
        $address = self::address();
        if (empty($address) || $address ===false ) {
            return false;
        }

        $serverUrl = str_replace('$server', $address, sfConfig::get('app_server_imagesUrl'));

        if (empty($params)) {
            $out = '';
        } elseif (is_array($params)) {
            $out = '?out_params=' . self::encodeGetParams($params);
        } else {
            $out = '?out_params=' . $params;
        }

        $result = @file_get_contents($serverUrl . '/' . $file . $out);
        if ($result === false) {
            return false;
        } else {
            $decoded = self::decodeResult($result);
            return $decoded;
        }
    }

    static function encodeGetParams($params) {
        $out = '';
        foreach ($params as $field => $value) {
            $params2[] = "{$field}={$value}";
        }

        $t = "!@@@" . implode('#!#', $params2) . "!@@@";
        $out = base64_encode($t);
        return $out;
    }

    static function decodeResult($str) {

        $mat = array();
        if (empty($str))
            return $mat;

        if (strpos($str, '!@@@') === false

            )return true;


        $val = explode('!@@@', $str);
        if (!isset($val[1])) {
            exceptionHandlerClass::saveError("I cant read task list");
            exceptionHandlerClass::saveError("return value:" . $str);
            return false;
        }

        if (isset($val[1]) && !empty($val[1])) {
            $o = base64_decode($val[1]);
            if (strpos($o, '%#%') === false && strpos($o, '#!#') === false) {
                return $o;
            }
            $o2 = explode('%#%', $o);
            $vals = array();
            foreach ($o2 as $i => $row) {
                if ($i === '') {
                    continue;
                }
                $vals[$i] = explode('#!#', $row);
            }
            foreach ($vals as $k => $val) {
                if ($k === '')
                    continue;
                foreach ($val as $option) {
                    if (empty($val))
                        continue;
                    $val1 = explode('=', $option);
                    if (empty($val1[0]))
                        continue;
                    if (!isset($val1[1])) {
                        $val1[1] = $val1[0];
                    }
                    $mat[$k][$val1[0]] = $val1[1];
                }
            }
            return $mat;
        } elseif (empty($val[1])) {
            return false;
        }

        return $mat;
    }

    static function getTaskToDoNow() {
        $taskList = self::getTasks();

        $deployed_image = sfYamlOI::readKey('deployed_image');
        $deployed_time = sfYamlOI::readKey('deployed_time');
        $taskDeltaTime = sfConfig::get('app_oi_taskDeltaTime');

        if (!is_array($taskList) || count($taskList) == 0) {
            return null;
        }
        return $taskList;
    }

    static function createImage($newImage) {
        $imageDB = array('name' => $newImage['name'], 'description' => $newImage['description']);
        $imageDB['os'] = $newImage['os'];
        $imageDB['uuid'] = $newImage['uuid'];
        $imageDB['partition_size'] = $newImage['partition_size'];
        $imageDB['partition_type'] = $newImage['partition_type'];
        $imageDB['filesystem_size'] = $newImage['filesystem_size'];
        $imageDB['filesystem_type'] = $newImage['filesystem_type'];

        //$id=array('mac'=>$mac,'hddid'=>$hddid);
        $data='out_params='.base64_encode(serialize($imageDB));

        $img=self::doPostRequest('out_insert.php', $data);
        $id=self::decodeResult2($img);

        if (empty($id) || !is_numeric($id)) {
            exceptionHandlerClass::saveError("new image has not been registered");
            self::removeImage($id);
            return false;
        }
        exceptionHandlerClass::saveMessage("new image has been registered in OpenIrudi server DB ($id)");
        $fileName = '/tmp/' . sfConfig::get('app_oi_imagePrefix') . $id . ".info";

        $r = manageIniFilesClass::writeIniFile($fileName, $newImage);
        if ($r === false) {
            exceptionHandlerClass::saveError("Error creating image info file");
            self::removeImage($id);
            return false;
        }
        return $id;
    }

    static function removeImage($id) {
        $res = self::getServerContent('/out_insert.php', array('remove' => $id));
        exceptionHandlerClass::saveMessage("Image $id has not been created.");
        return true;
    }

    static function mountServerFolder() {
        if (!self::is_validServer()) {
            return false;
        }
        $listOisystems=  systemOppClass::getListOisystems();

        $mountCmd = sfConfig::get('app_server_mountCmd');
        $server = self::address();
        $serverUser = sfConfig::get('app_server_user');

        $serverPassword = $listOisystems->sclient['password'];
        
        $localPath = sfConfig::get('app_server_localPath');
        $remotePath = sfConfig::get('app_server_remotePath');

        $cmd = "$mountCmd $server $serverUser $serverPassword $remotePath $localPath";
        $re = executeClass::execute($cmd);
        if ($re['return'] != 0) {
            exceptionHandlerClass::saveMessage("ERROR connecting to server::" . implode('<br>', $re['output']));
            return false;
        } else {
            return $localPath;
        }

        return $localPath;
    }

    static function umountServerFolder() {
        $localPath = sfConfig::get('app_server_localPath');
        $cmd = str_replace('$partitionName', $localPath, sfConfig::get('app_command_umount'));
        $m = executeClass::execute($cmd);
        if ($m['return'] != 0) {
            sleep(5);
            $m = executeClass::execute($cmd);
            if ($m['return'] != 0) {
                exceptionHandlerClass::saveError("error umounting server");
                return false;
            }
        }
        return true;
    }

    static function saveLog($log ) {
        if(!self::is_validServer()) return;
        
        if(is_array($log)){
            $logArray=$log;
        }else{
            $logArray=array( "$log");
        }
        $data='log='.base64_encode(serialize($logArray));
        self::doPostRequest('clientLog.php', $data);

    }

    static function doPostRequest($file, $data, $optional_headers = null) {
        $address = self::address();
        if (empty($address)) {
            return null;
        }
        $serverUrl = str_replace('$server', $address, sfConfig::get('app_server_imagesUrl'))."/{$file}";
        $params = array('http' => array('method' => 'POST', 'content' => $data));

        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }

        $ctx = stream_context_create($params);
        $fp = @fopen($serverUrl, 'rb', false, $ctx);
        if (!$fp) {
            //exceptionHandlerClass::saveError("Problem with $serverUrl ");
            return false;
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            //exceptionHandlerClass::saveError("Problem reading data from $serverUrl");
            return false;
        }
        return $response;
    }

}

?>
