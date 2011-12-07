<?php

define('EXPORTFILE', '/tmp/export.reg');
define('IMPORTFILE', '/tmp/import.reg');

class windowsRegistryClass {

    private $hiveFile;
    private $prefixString;
    
    function  __construct($hiveFile, $prefixString='\\') {
        $this->hiveFile=$hiveFile;
        $this->prefixString=$prefixString;
    }

    function prepareKey($key) {
        $key = str_replace("\\", "\\\\\\\\", $key);
        $key = str_replace(' ',"\\\\x20",$key);
        return $key;
    }

    function prepareKey2($key) {
        $key = str_replace("\\", "\\\\x5C", $key);
        $key = str_replace(' ',"\\x20",$key);
        return $key;
    }

    function getRealKey( $lowerkey ){
        $keys=$this->getRealKeys();
                
        foreach($keys as $lKey => $realKey  ){
            if(stripos($lKey,$lowerkey) !== false ){
                return $realKey;
            }
        }
        return false;
    }

    function getRealAttrib( $lowerkey ){
        $keys=$this->getRealKeys();

        foreach($keys as $lKey => $realKey  ){
            if(stripos($lKey,$lowerkey) !== false ){
                return $realKey;
            }
        }
        return false;
    }

    function txt2hex($txt){
        $nip=array();
        foreach (  str_split($txt) as $c ) {
          $nip[]=unitsClass::longDec2hex(ord($c));
          $nip[]="00";
        }
        $n2ip=implode(",",$nip);
        return $n2ip;
    }
/*
 * $keyPath: Erregistroko zein adarretik aurrera begiratuko degun
 * $keyStr: Bilaketa katea. Erregistroko klabean textu kate hau duena bilatuko du.
 */
    function getObjectsArray( $keyPath='', $keyStr='', $realValue='' ){
        $guids=array();

        $elements=array();
        $exportFile=$this->exportKey($keyPath);
        if($exportFile===false){
            exceptionHandlerClass::saveError("Error reading Windows registry");
            exceptionHandlerClass::saveError("keyPath $keyPath");
            return false;
        }

        $txt = file_get_contents($exportFile);
        preg_match_all('/\[([^\]]*)\]([^\[]*)/', $txt, $values);

        foreach ($values[2] as $id => $value ){
            $d="";

            $k=explode("\\\r\n", $value);
            foreach($k as $k1){
                $d.=trim($k1);
            }
            $wKey=strtolower($values[1][$id]);
 
            if(empty($d)){
                $elements["$wKey"]=$d;
                continue;
            }else{
                preg_match_all('/\"([^\"]*)"=(.*)/', $d, $d2);
                foreach ($d2[1] as $id2 => $e ){
                    if(empty($realValue)){
                        $elements["$wKey"][strtolower($e)]=str_replace('"','',$d2[2][$id2]);
                    }else{
                        $elements["$wKey"][$e]=str_replace('"','',$d2[2][$id2]);
                    }
                }
            }
        }

 
        foreach ($elements as $key => $value ) {
            $key=str_replace('\\\\', '', trim($key));

            if(empty($keyStr) ){
                $k='[\''.str_replace('\\','\'][\'',$key).'\']';
                eval( "\$guids$k=\$value;");
            } elseif ( !empty($keyStr) && stripos( $key, $keyStr ) !==false  ){

                $sub=substr($key,strripos(substr($key,0,stripos($key,$keyStr)),'\\'));
                $k='[\''.str_replace('\\','\'][\'',$sub).'\']';
                eval( "\$guids$k=\$value;");
            }
        }
        return $guids;
    }


    function valueReverse(&$offset,&$value){
        if( strlen($value) % 2 ){
            $value='0'.$value;
        }
        $len= strlen($value);
        $value=implode(',',array_reverse(str_split($value,2)));
        $offset=$offset-($len/2)+1;
    }

    
    /*
     * Klabearen benetako balioa bueltatzen du.  $keypath jarri behar degu ControlSet001 adarrean "Segmentation fault" ematen duelako.
     * $keyPath Nondik aurrera bilatuko duen.
     * $lkey bilatu beharreko katea. 
     */
    function getRealKeys($keyPath='',$lkey=''){

        $exportFile=$this->exportKey($keyPath);

        if($exportFile===false){
            exceptionHandlerClass::saveError("Error reading Windows registry");
            return false;
        }
        
        $txt = file_get_contents($exportFile);

        preg_match_all('/\[([^\]]*)\][^\[]*/', $txt, $values);
        
        $res=array();
        if(isset($values[1]) && !empty($values[1])){
            foreach($values[1] as $id => $value){
                if(empty($lkey)){
                    $res[strtolower($value)]=$value;
                }else{
                    if(stripos($value,$lkey) !== false ){
                        $realKey=substr($value,strripos(substr($value,0,stripos($value,$lkey)),'\\')+1);
                        return $realKey;
                    }
                }
            }
            return $res;
        }else{
            return false;
        }
    }


    function exportKey( $key='') {

        if (is_file(EXPORTFILE)) {
            unlink(EXPORTFILE);
        }

  

        if(empty ($key) ){
            $key='\\';
        }

        $key=$this->prepareKey2($key);
        $prefixString=$this->prepareKey2($this->prefixString);

        if (is_file($this->hiveFile)) {
            //sudo /var/www/openirudi/bin/windowsCmd.sh exportRegistryKey $hiveFile $prefix $key $exportFile
            $cmd = str_replace('$hiveFile', $this->hiveFile, sfConfig::get('app_windows_export'));
            $cmd = str_replace('$prefixString', $prefixString, $cmd);
            $cmd = str_replace('$key', $key, $cmd);
            $cmd = str_replace('$exportFile', sfConfig::get('app_windows_exportFile'), $cmd);
            $re = executeClass::execute($cmd);

            if (is_file(EXPORTFILE)) {
               return EXPORTFILE;
            }else{
                exceptionHandlerClass::saveMessage("cmd :: $cmd");
                exceptionHandlerClass::saveMessage("re: " .implode('<br>',$re['output']) );
                return false;
            }
        }  else {
            exceptionHandlerClass::saveError("We not found hive File");
            return false;

        }
    }

    function deleteKey($fkey){
        if (!is_file($this->hiveFile)) {
            exceptionHandlerClass::saveError("We not found hive File");
            return false;
        }

        $cmd = str_replace('$hiveFile', $this->hiveFile, sfConfig::get('app_windows_importRegistryKey'));
        $cmd = str_replace('$prefix', "'{$this->prefixString}'", $cmd);
        $cmd = str_replace('$importFile', IMPORTFILE, $cmd);

        $t="Windows Registry Editor Version 5.00\r\n\r\n";
        $t.="[-{$fkey}]\r\n";
        file_put_contents(IMPORTFILE, $t);

        //$re = executeClass::execute($cmd);
        if ($re['return'] == 0 ) {
           return true;
        }else{
            exceptionHandlerClass::saveMessage("cmdREG: " . $cmd);
            exceptionHandlerClass::saveMessage("re: " .implode('<br>',$re['output']) );
            return false;
        }
    }


    function modifyHexKey($fkey,$type,$attrib,$value){
        /*
         * [HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft]
"Value A"="<String value data>"
"Value B"=hex:<Binary data (as comma-delimited list of hexadecimal values)>
"Value C"=dword:<DWORD value integer>
"Value D"=hex(7):<Multi-string value data (as comma-delimited list of hexadecimal values)>
"Value E"=hex(2):<Expandable string value data (as comma-delimited list of hexadecimal values)>
"Value F"=hex(b):<QWORD value (as comma-delimited list of 8 hexadecimal values, in little endian byte order)>
"Value G"=hex(4):<DWORD value (as comma-delimited list of 4 hexadecimal values, in little endian byte order)>
"Value H"=hex(5):<DWORD value (as comma-delimited list of 4 hexadecimal values, in big endian byte order)>
"Value I"=hex(0):
         */
        switch ($type){
            case 'A':
                $v1='"'.$value.'"';
                break;
            case 'B':
                $v1="hex:$value";
                break;
            case 'C':
                $v1="dword:$value";
                break;
            case 'D':
                $v1="hex(7):$value";
                break;
            case 'E':
                $v1="hex(2):$value";
                break;
            case 'F':
                $v1="hex(b):$value";
                break;
            case 'G':
                $v1="hex(4):$value";
                break;
            case 'H':
                $v1="hex(5):$value";
                break;
            case 'I':
                $v1="hex(0):$value";
                break;

        }

        if (!is_file($this->hiveFile)) {
            exceptionHandlerClass::saveError("We not found hive File");
            return false;
        }

        $cmd = str_replace('$hiveFile', $this->hiveFile, sfConfig::get('app_windows_importRegistryKey'));
        $cmd = str_replace('$prefix', "'{$this->prefixString}'", $cmd);
        $cmd = str_replace('$importFile', IMPORTFILE, $cmd);

        $t="Windows Registry Editor Version 5.00\r\n\r\n";
        $t.="[{$fkey}]\r\n";
        $t.="\"{$attrib}\"={$v1}\r\n";
        file_put_contents(IMPORTFILE, $t);

        $re = executeClass::execute($cmd);
        if ($re['return'] == 0 ) {
           return true;
        }else{
            exceptionHandlerClass::saveMessage("cmdREG: " . $cmd);
            exceptionHandlerClass::saveMessage("re: " .implode('<br>',$re['output']) );
            return false;
        }
    }

    function modifyDwordKey($fkey,$attrib,$value){
        if (!is_file($this->hiveFile)) {
            exceptionHandlerClass::saveError("We not found hive File");
            return false;
        }

        $value=str_pad($value, 8, "0", STR_PAD_LEFT);

        $cmd = str_replace('$hiveFile', $this->hiveFile, sfConfig::get('app_windows_importRegistryKey'));
        $cmd = str_replace('$prefix', "'{$this->prefixString}'", $cmd);
        $cmd = str_replace('$importFile', IMPORTFILE, $cmd);
 
        $t="Windows Registry Editor Version 5.00\r\n\r\n";
        $t.="[{$fkey}]\r\n";
        $t.="\"{$attrib}\"=dword:{$value}\r\n";
        file_put_contents(IMPORTFILE, $t);
        $re = executeClass::execute($cmd);
        if ($re['return'] == 0 ) {
           return true;
        }else{
            exceptionHandlerClass::saveMessage("cmdREG: " . $cmd);
            exceptionHandlerClass::saveMessage("re: " .implode('<br>',$re['output']) );
            return false;
        }


            
    }
    
    function modifyStrKey($fkey,$attrib,$value){
        if (!is_file($this->hiveFile)) {
            exceptionHandlerClass::saveError("We not found hive File");
            return false;
        }

        $cmd = str_replace('$hiveFile', $this->hiveFile, sfConfig::get('app_windows_importRegistryKey'));
        $cmd = str_replace('$prefix', "'{$this->prefixString}'", $cmd);
        $cmd = str_replace('$importFile', IMPORTFILE, $cmd);

        $t="Windows Registry Editor Version 5.00\r\n\r\n";
        $t.="[{$fkey}]\r\n";
        if(!empty ($attrib) && !empty ($value)){
            $t.="\"{$attrib}\"=\"{$value}\"\r\n";
        }else if(!empty ($attrib) && empty($value)){
            $t.="\"{$attrib}\"\r\n";
        }
        file_put_contents(IMPORTFILE, "$t" );

        $re = executeClass::execute($cmd);
        if ($re['return'] == 0 ) {
           return true;
        }else{
            exceptionHandlerClass::saveMessage("cmdREG: " . $cmd);
            exceptionHandlerClass::saveMessage("re: " .implode('<br>',$re['output']) );
            return false;
        }
    }

    function importArray($fkey, $attribsArray){
        if(!is_array($attribsArray)){
            exceptionHandlerClass::saveError("Must be array");
            return false;
        }

        $cmd = str_replace('$hiveFile', $this->hiveFile, sfConfig::get('app_windows_importRegistryKey'));
        $cmd = str_replace('$prefix', "'{$this->prefixString}'", $cmd);
        $cmd = str_replace('$importFile', IMPORTFILE, $cmd);


        $t="Windows Registry Editor Version 5.00\r\n\r\n";

        $t.="[{$fkey}]\r\n";
        foreach ($attribsArray as $attrib => $value ){
            if(!empty ($attrib) && !empty ($value)){
                $t.="\"{$attrib}\"=\"{$value}\"\r\n";
            }else if(!empty ($attrib) && empty($value)){
                $t.="\"{$attrib}\"\r\n";
            }
        }
        file_put_contents(IMPORTFILE, "$t" );

        $re = executeClass::execute($cmd);
        if ($re['return'] == 0 ) {
           return true;
        }else{
            exceptionHandlerClass::saveMessage("cmdREG: " . $cmd);
            exceptionHandlerClass::saveMessage("re: " .implode('<br>',$re['output']) );
            return false;
        }



    }






}

?>
