<?php

class FileSystemOppClass {
    private $disk;
    private $partitionNumber;
    private $partitionName;
    private $partitionTypeId;

    private $label;
    private $type;
    private $version;
    private $uuid;

    private $size;
    private $sizeHuman;
    private $free;
    private $freeHuman;
    private $used;
    private $usedHuman;

    private $isOIFileSystem=false;
    private $canCreateImage;
    private $os=null;
    private $mountable=true;
    private $bootable=false;
    private $resizable=false;
    private $drivers=false;

    function __construct($disk,$partitionNumber,$partitionName,$partitionTypeId) {
        $this->disk=$disk;
        $this->partitionNumber=$partitionNumber;
        $this->partitionName=$partitionName;
        $this->partitionTypeId=$partitionTypeId;
    }

    function __get($propertyName) {
        try {
            if(property_exists($this , $propertyName)) {
                if(!isset( $this->$propertyName)) {
                    $this->__set($propertyName, '');
                }
                return $this->$propertyName;
            }
            throw new Exception("Invalid property name \"{$propertyName}\" in FileSystemOppClass get ");

        }catch(Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function __set($propertyName, $value) {
        try {
            if(!property_exists($this, $propertyName)) {
                throw new Exception("Invalid property value \"{$propertyName}\" in FileSystemOppClass ");
            }
            if(method_exists($this,'set_'.$propertyName)) {
                call_user_func(array($this,'set_'.$propertyName),$value);
            }else {
                throw new Exception("*Invalid property value \"{$propertyName}\" in FileSystemOppClass ");
            }

        }catch(Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function getOS(){
        if(isset($this->os) && !is_null($this->os)){
            return $this->os;
        }else{
            return null;
        }
    }


    function set_canCreateImage() {
        $this->__get('type');
        if(!empty($this->type) && strpos(sfConfig::get('app_oipartition_fsImageCreateType'),$this->type) !== false ) {
            $this->canCreateImage= true;
        }else {
            $this->canCreateImage= false;
        }

    }

    function set_os($os) {
        $this->os=$os;
    }

    function set_bootable($bootable) {
        $this->bootable=$bootable;
    }
    function set_drivers($drivers) {
        $this->drivers=$drivers;
    }

    function set_mountable($mountable) {
        $this->mountable=$mountable;
    }

    function set_resizable($resizable) {
        $this->resizable=$resizable;
    }

    function set_isOIFileSystem($isOIFileSystem) {
        $this->isOIFileSystem=$isOIFileSystem;
    }

    function set_size() {
        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;
        }

        if(!empty($mountPoint)) {
            $this->free=disk_free_space($mountPoint);
            $this->freeHuman=unitsClass::sizeUnit($this->free);
            $this->size=disk_total_space($mountPoint);
            $this->sizeHuman=unitsClass::sizeUnit($this->size);
            $this->used=$this->size - $this->free;
            $this->usedHuman=unitsClass::sizeUnit($this->used);
        }
        if(!$mountedAlready) {
            $this->umount();
        }
    }


    function set_sizeHuman() {
        $this->__get('size');
    }

    function set_free() {
        $this->__get('size');
    }
    function set_freeHuman() {
        $this->__get('size');
    }

    function set_used() {
        $this->__get('size');
    }
    function set_usedHuman() {
        $this->__get('size');
    }



    function set_type() {
        $this->volid();
    }

    function set_label() {
        $this->volid();
    }

    function set_uuid() {
        $this->volid();
    }

    function volid() {

        if(empty($this->partitionName)) return;

        $this->type=null;
        $this->version=null;
        $this->uuid=null;
        $this->label=null;

        
        $blkid_result=executeClass::strExecute(str_replace('$partitionName',$this->partitionName, sfConfig::get('app_command_volid')));

        preg_match_all('~([A-Z_]*)\=\"([^\"]*)\"~sim',$blkid_result,$blkid_resultArray);

        if(!empty($blkid_resultArray[1]) ) {

            foreach($blkid_resultArray[1] as $k => $v) {
                switch($v) {
                    case 'TYPE':
                        $this->type=$blkid_resultArray[2][$k];
                        break;
                    case 'VERSION':
                        $this->version=$blkid_resultArray[2][$k];
                        break;
                    case 'UUID':
                        $this->uuid=$blkid_resultArray[2][$k];
                        break;
                    case 'LABEL':
                        $this->label=$blkid_resultArray[2][$k];
                        break;
                }

            }
        }
    }

    function isMounted() {
        if(!$this->mountable) return null;
        $cmd=str_replace('$partitionName',$this->partitionName, sfConfig::get('app_command_ismounted'));
        $s=executeClass::execute($cmd);
        if( $s['return']==0 ){
            $s2=implode("\n",$s['output']);
            if (strpos($s2,'!@@@') !==false ) {
                $s1=explode('!@@@', $s2 );
                return $s1[1];
            }else{
                return false;
            }
        }else {
            return false;
        }
    }

    function mount($mountPoint1='') {
        $this->__get('type');
        if(!$this->mountable) {
            return null;
        }

        if(!$mountPoint=$this->isMounted()) {

            $mountPoint=str_replace('$partitionName',$this->partitionName, sfConfig::get('app_command_mountpoint'));
            $cmd=str_replace('$partitionName',$this->partitionName,sfConfig::get('app_command_mount'));
            $cmd=str_replace('$mountpoint',$mountPoint, $cmd );

            $s=executeClass::execute($cmd);

            if($s['return']==0) {
                $s2=implode("\n",$s['output']);
                if (strpos($s2,'!@@@') !==false ) {
                    $s1=explode('!@@@', $s2 );
                    return $s1[1];
                }else{
                    exceptionHandlerClass::saveMessage("No mounting res ".print_r($m,1));
                    return false;
                }
            }else{
                exceptionHandlerClass::saveMessage("ERROR mounting cod: {$s['return'] } ".$this->partitionName);
                exceptionHandlerClass::saveMessage("ERROR mounting res ".print_r($s,1));
                

                return false;
            }
            
        }else {
            return $mountPoint;
        }

    }

    function umount() {
        if(!$this->mountable) return null;

        $this->__get('type');
        if(is_null($this->type)) {
            return null;
        }

        $mountPoint=$this->isMounted();
        if($mountPoint===false){
            return true;
        }
        $cmd=str_replace('$partitionName',$this->partitionName, sfConfig::get('app_command_umount'));
        $m=executeClass::execute($cmd);
        if($m['return']!=0) {
            exceptionHandlerClass::saveError("error umounting $this->partitionName");
            return false;
        }
        return true;
    }


    function changeUUID($uuid){
        exceptionHandlerClass::saveMessage("modify system uuid" );

        exceptionHandlerClass::saveMessage("image UUID: $uuid" );
        $cmd=str_replace('$partitionName',$this->partitionName, sfConfig::get('app_oipartition_changeUUID'));
        $cmd=str_replace('$uuid',$uuid, $cmd );
        
        $re=executeClass::execute($cmd);
        if ($re['return'] !=0 ){
             exceptionHandlerClass::saveMessage("Error modyfing UUID" );
             exceptionHandlerClass::saveMessage("output:: ".implode('<br>',$re['output']) );
        }

        $this->volid();

    }

}
?>
