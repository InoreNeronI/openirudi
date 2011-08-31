<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sfYamlOI
 *
 * @author aitor
 */
class sfYamlOI extends sfYaml {


    public static function readConfig(){
        
        $confArray=self::load(sfConfig::get('app_path_confile'));
        return $confArray;

    }

    public static function readKey($key){
        $confArray=self::readConfig();
        if(isset($confArray[$key])){
            return $confArray[$key];
        } else {
            return null;
        }
    }

    public static function saveConfig($confArray) {
        $file=sfConfig::get('app_path_confile');
        
        $dump = self::dump($confArray);

        $f = fopen($file, 'w');
        if (!$f) {
            exceptionHandlerClass::saveMessage("I can't save conf file ");
            return false;
        } else {
            $bytes = fwrite($f, $dump );
            fclose($f);
            return true;
        }



    }

    public static function saveKey($key,$value){
        $oldConfArray=self::readConfig();
        $newKey=array($key=>$value);

        if(empty($newKey) ){
           return;
        }elseif(empty($oldConfArray)){
            self::saveConfig($newKey);
        }else{
           $confArray=self::array_merge_recursive_distinct($oldConfArray,$newKey);
           self::saveConfig($confArray);
        }
    }

    
    private static function array_merge_recursive_distinct(array $array1, $array2 = null) {
        $merged = $array1;

        if (is_array($array2)){
            foreach ($array2 as $key => $val){
                if (is_array($array2[$key])){
                    $merged[$key] = is_array($merged[$key]) ? self::array_merge_recursive_distinct($merged[$key], $array2[$key]) : $array2[$key];
                }else{
                    $merged[$key] = $val;
                }
            }
        }
        return $merged;
 }



}
?>
