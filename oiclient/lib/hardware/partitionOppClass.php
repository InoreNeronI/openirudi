<?php
define('_BYTESSECTOR',512);
define('_BYTESBLOCK',1024);

class partitionOppClass {
    private $bootable;
    private $startSector;
    private $sectors=0;
    private $endSector;
    private $blocks;
    private $humanSize;
    private $partitionTypeId;
    private $partitionTypeName;
    private $fstype;
    private $fileSystem;
    private $partitionNumber;
    private $disk;
    private $partitionName;
    private $editable=1;
    private $grubName;
    private $grubPartitionId;
    private $sectorBytes;
    private $cylSectors;
    private $canDeploy;


    function __construct($partition,$sectorBytes,$cylSectors) {
        $this->sectorBytes=$sectorBytes;
        $this->cylSectors=$cylSectors;
        $this->initiatePartition($partition);
        
        $this->set_fileSystem('fileSystem');
  }

    function __get($propertyName) {
        try {
            if(property_exists('partitionOppClass', $propertyName)) {
                if(!isset($this->$propertyName)  ) {
                    $this->__set($propertyName, '');
                }
                return $this->$propertyName;

            }
            throw new Exception("Invalid property name \"{$propertyName}\"");

        }catch(Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function __set($propertyName, $value) {
        try {
            if(!property_exists('partitionOppClass', $propertyName)) {
                throw new Exception("Invalid property value \"{$propertyName}\" in partitionOppClass");
            }
            if(method_exists($this,'set_'.$propertyName)) {
                call_user_func(array($this,'set_'.$propertyName),$value);
            }else {
                throw new Exception("*Invalid property value \"{$propertyName}\" in partitionOppClass ");
            }

        }catch(Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }


    function initiatePartition($partition) {
        $sfUser = sfContext::getInstance()->getUser();
        $partitionTypes = $sfUser->getAttribute('partitionTypes');
        $this->partitionName=$partition['partitionName'];

        $this->partitionNumber=$this->set_partitionNumber();


        if(isset($partition['bootable']) && $partition['bootable']) {
            $this->set_bootable(true);
        }else {
            $this->set_bootable(false);
        }
        $this->startSector=$partition['start'];

        if(isset($partition['id']) && isset($partitionTypes[$partition['id']])) {
            $this->partitionTypeId=$partition['id'];
            $this->partitionTypeName=$partitionTypes[$partition['id']];
        }
        $this->sectors=$partition['size'];

        $this->blocks=$this->set_blocks($partition['size']);
        $this->set_humanSize();
        $this->set_disk();

    }
    function set_endSector($sectors='') {
        $this->__get('cylSectors');
        if(empty($sectors)) $sectors=$this->sectors;
        $endSector1=$this->startSector+$sectors;
        $cyls=ceil( $endSector1 / $this->cylSectors);
        $this->endSector=$cyls*$this->cylSectors-1;
    }
    function set_partitionTypeName() {

    }

    function set_bootable($value) {
        if($value) $this->bootable=1; else $this->bootable=0;
    }

    function set_humanSize($size='') {
        if(empty($size)) {
            $bytes=$this->sectors*$this->sectorBytes;
            $this->humanSize=unitsClass::sizeUnit($bytes);
        }elseif(is_array($size) && isset($size['size']) && isset($size['unit'])) {
            $b=unitsClass::sizeUnit($size);
            if(empty($b)) {
                exceptionHandlerClass :: saveError("<br>WRONG SIZE");
                return;
            }else {
                $sectors1=ceil($b/$this->sectorBytes)-1;
                $this->set_endSector($sectors1);
                $this->sectors=$this->endSector-$this->startSector;
                $this->humanSize=unitsClass::sizeUnit($this->sectors*$this->sectorBytes);    
            }

        }elseif(is_numeric($size)) {
            $this->sectors=$size;
            $bytes=$this->sectors*$this->sectorBytes;
            $this->humanSize=unitsClass::sizeUnit($bytes);
        }
    }
    
    public static function get_partitionTypes() {
        return parse_ini_file(sfConfig::get('app_path_partitiontypes'));
    }

    function set_partitionTypeId($newid) {
        $sfUser = sfContext::getInstance()->getUser();
        $partitionTypes = $sfUser->getAttribute('partitionTypes');
        if(isset($partitionTypes[$newid])) {
            if(!isset($this->partitionTypeId) || empty($this->partitionTypeId)) {
                $this->partitionTypeId=$newid;
                $this->partitionTypeName=$partitionTypes[$newid];
                return true;
            }elseif($this->partitionTypeId != $newid ) {
                //changePartitionId:  'nohup sudo /var/www/openirudi/bin/partedCmd.sh changePartitionType $disk $number $type-fs'
                $cmd=str_replace('$diskName',$this->disk,sfConfig::get('app_oipartition_changePartitionId'));
                $cmd=str_replace('$number',$this->partitionNumber,$cmd);
                $cmd=str_replace('$type-fs',$newid,$cmd);
                $re=executeClass::StrExecute($cmd);
                if($re['return'] != 0){
                    exceptionHandlerClass :: saveError("<br>cmd :  $cmd");
                    exceptionHandlerClass :: saveError("<br>Partition  type change out:: :   ". implode("<br>",$re,1));
                }
                return true;
            }
        }
        return false;
    }

    function set_blocks($sectors) {
        $bytes=$sectors*$this->sectorBytes;
        return $bytes/_BYTESBLOCK;
    }

    function set_fstype(){
        $this->__get('fileSystem');
    }

    function set_canDeploy(){
        $this->__get('fstype');
        if($this->partitionTypeId=='f' || $this->fstype == 'oiSystem' || $this->partitionTypeId=='5' ){
            $this->canDeploy=false;
        }else{
            $this->canDeploy=true;
        }
    }

    function set_fileSystem() {
        if($this->sectors!=0) {
            $fsDetect=new fsDetectOppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);
            $this->fileSystem=$fsDetect->fsType();
        }
    }

    function set_partitionNumber() {
        $pattern = '/^[a-zA-Z]+([0-9]+)/';
        if(preg_match($pattern, $this->partitionName, $matches)!==false) {
            $this->partitionNumber=$matches[1];
        }else {
            $this->partitionNumber=null;
        }
    }

    function set_disk() {

        if(empty($this->partitionName) || !is_numeric($this->partitionNumber)) {
            $this->set_partitionNumber();
        }
        $this->disk=str_replace($this->partitionNumber,'',$this->partitionName);
    }

    function set_grubName() {
        $letter='abcdefghijklmnopqrstxyz';
        $grubDisk=strpos($letter,substr($this->partitionName,2,1));
        $this->grubPartitionId=$this->partitionNumber-1;
        $this->grubName="(hd{$grubDisk},{$this->grubPartitionId})";
    }
    function set_grupPartitionId() {
        $this->__get('grubName');
    }

    function changePartition($candidate) {
        $sfUser = sfContext::getInstance()->getUser();
        $partitionTypes = $sfUser->getAttribute('partitionTypes');

        if(isset($candidate['sizeB']) && !isset($candidate['size']) && ( $this->humanSize['size'] != $candidate['sizeB'] || $this->humanSize['unit'] != $candidate['unit'] ) ) {
            $bytes=unitsClass::sizeUnit(array('size'=>$candidate['sizeB'],'unit'=>$candidate['unit']));
            $this->sectors=ceil($bytes/$this->sectorBytes);
            $this->set_humanSize();
        }

        if(isset($candidate['id']) && $candidate['id'] != $this->partitionTypeId && isset($partitionTypes[$candidate['id']])) {
            $this->partitionTypeId=$candidate['id'];
            $this->partitionTypeName=$partitionTypes[$candidate['id']];
        }
    }
    /*************************************FUNTZIO BERRIAK********************************************/
    function set_startSector($value) {
        $this->startSector=$value;
    }
    function removeFileSystem() {
        if(isset($this->fileSystem)) {
            unset($this->fileSystem);
        }

    }
    function set_editable($value) {
        $this->editable=$value;
    }
    function set_sectors($value) {
        $this->sectors=$value;
    }
}
?>
