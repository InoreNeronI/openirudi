<?php

class oiImageOppClass {

    private $id;
    private $ref;
    private $name;
    private $description;
    private $os;
    private $uuid;
    private $created_at='0000-00-00 00:00:00';
    private $partition_size=0;
    private $partition_type;
    private $filesystem_size;
    private $filesystem_type;
    private $path;
    private $files;
    private $size;



    function __construct($properties) {

        $this->id=$properties['id'];
        $this->ref= $properties['ref'];
        $this->name= $properties['name'];
        $this->description= $properties['description'];
        $this->os= $properties['os'];
        $this->uuid= $properties['uuid'];
        
        if(isset($properties['created_at'])){
            $this->created_at= $properties['created_at'];
        }
        if(isset($properties['partition_size'])){
            $this->partition_size= $properties['partition_size'];
        }
        $this->partition_type= $properties['partition_type'];
        $this->filesystem_size= $properties['filesystem_size'];
        $this->filesystem_type= $properties['filesystem_type'];
        $this->path= $properties['path'];
        $this->files= $properties['files'];
        $this->size= $properties['size'];




    }

    function __get($propertyName) {
        try {
            if(property_exists('oiImageOppClass', $propertyName)) {
                if(!isset($this->$propertyName) ) {
                    $this->__set($propertyName, '');
                }
                return $this->$propertyName;

            }
            throw new Exception("Invalid property name \"{$propertyName}\" in oiImageOppClass");

        }catch(Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function __set($propertyName, $value) {
        try {
            if(!property_exists('oiImageOppClass', $propertyName)) {
                throw new Exception("Invalid property value \"{$propertyName}\" in oiImageOppClass ");
            }
            if(method_exists($this,'set_'.$propertyName)) {
                call_user_func(array($this,'set_'.$propertyName),$value);
            }else {
                throw new Exception("*Invalid property value \"{$propertyName}\" in oiImageOppClass ");
            }

        }catch(Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function deployImage($destPartition, $oiSystem='-' ) {
        $pname=$destPartition->partitionName;

        if(!is_object($destPartition) || empty($pname) ) {
            exceptionHandlerClass::saveError( "this is not valid partition" . " {$destPartition->partitionName} ---- {$destPartition->startSector} " );
            return false;
        }
        if(empty($this->files)) {
            exceptionHandlerClass::saveError( "Not valid image, it has not files in server" );
            return false;
        }

        exceptionHandlerClass::saveMessage("Start image deploy ({$this->name})");

        if( is_object($oiSystem) ){
            if (!$oiSystemMountPoint = $oiSystem->isMounted()) {
                $mountedAlready = false;
                $oiSystemMountPoint = $oiSystem->mount();
            } else {
                $mountedAlready = true;
            }
        }else{
            exceptionHandlerClass::saveMessage("Deploy image without oiPartition.");
            $mountedAlready = true;
            $oiSystemMountPoint="-";
        }
        $serverMountPoint=ImageServerOppClass::mountServerFolder();
        if($serverMountPoint===false){
            exceptionHandlerClass::saveMessage("ERROR mounting server");
            return false;
        }

        $re=false;
        $cmd=str_replace('$imageId', sfConfig::get('app_oi_imagePrefix').$this->id, sfConfig::get('app_oipartition_deployImage'));
        $cmd=str_replace('$oiSystemPath',$oiSystemMountPoint.'/'.sfConfig::get('app_oi_imagesdir'),$cmd);
        $cmd=str_replace('$destPartition','/dev/'.$destPartition->partitionName,$cmd);
        $cmd=str_replace('$files', $this->files,$cmd);
        $cmd=str_replace('$fs-type', $this->partition_type ,$cmd);
        $cmd=str_replace('$serverMountPoint',$serverMountPoint,$cmd);
        $re=executeClass::executeProc($cmd);

        if(!$mountedAlready) {
            $oiSystem->umount();
        }
        ImageServerOppClass::umountServerFolder();

        $hw=systemOppClass::getComputer(true);

        if($re===false ) {
            exceptionHandlerClass::saveMessage("An error ocurred and image has not been deployed" );
            return false;
        }
        $diskName=$hw->listDisks->diskOfpartition( $pname );

        if ( is_null($hw->listDisks->disks[$diskName]->partitions[$destPartition->partitionName]->fileSystem ) ){

            exceptionHandlerClass::saveError("at1".$hw->listDisks->disks[$diskName]->partitions[$destPartition->partitionName]->partitionTypeId );
            exceptionHandlerClass::saveError("at2".  $this->partition_type);
            //return false;
        }
        if ( $hw->listDisks->disks[$diskName]->partitions[$destPartition->partitionName]->partitionTypeId != $this->partition_type ) {

            exceptionHandlerClass::saveError("t1".$hw->listDisks->disks[$diskName]->partitions[$destPartition->partitionName]->partitionTypeId );
            exceptionHandlerClass::saveError("t2".  $this->partition_type);

        }

        exceptionHandlerClass::saveMessage("Image post deploy" );
        exceptionHandlerClass::saveMessage("Image post deploy disk: $diskName signature: " .$hw->listDisks->disks[$diskName]->diskSignature  );
        if(!is_null($hw->listDisks->disks[$diskName]->partitions[$destPartition->partitionName]->fileSystem)){
            $hw->listDisks->disks[$diskName]->partitions[$destPartition->partitionName]->fileSystem->postDeploy();
        }
        exceptionHandlerClass::saveMessage("Image deployed sucefully (".$this->name.")" );
        sfYamlOI::saveKey('deployed_image',$this->id);
        sfYamlOI::saveKey('deployed_time',time());

        return $this->id;
        
    }

//    function imageUUID($destPartition){
//        exceptionHandlerClass::saveMessage("modify system uuid" );
//        $serverMountPoint=ImageServerOppClass::mountServerFolder();
//
//        exceptionHandlerClass::saveMessage("image UUID: $this->uuid" );
//        $re=executeClass::execute("sudo /var/www/openirudi/bin/changeUuid.php  $destPartition->partitionName  {$this->uuid}");
//        if ($re['return'] !=0 ){
//             exceptionHandlerClass::saveMessage("Error modyfing UUID" );
//             exceptionHandlerClass::saveMessage("output:: ".implode('<br>',$re['output']) );
//        }
//
//        ImageServerOppClass::umountServerFolder();
//    }
        


}
?>
