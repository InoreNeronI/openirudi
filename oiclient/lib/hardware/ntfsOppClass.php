<?php

class ntfsOppClass extends FileSystemOppClass  {

    function __construct($disk,$partitionNumber,$partitionName,$partitionTypeId){
        parent::__construct($disk,$partitionNumber,$partitionName,$partitionTypeId);
        $this->__set('isOIFileSystem', false);
        $this->__set('mountable', true);
        $this->__set('resizable', true);
        $this->__set('bootable', false );
	
    }

    function postDeploy(){
        
    }

    function resize($sectors){
        $fsSectors1=ceil($sectors*0.95);
        $si=unitsClass::diskSectorSize($fsSectors1);
        $sizeM=unitsClass::converse($si,'KB');

        //resizeNtfsFS:      'sudo /var/www/openirudi/bin/cloneNtfs.sh resizeNtfsFs /dev/$partitionName $size'
        $cmd=str_replace('$partitionName',$this->partitionName,sfConfig::get('app_oipartition_resizeNtfsFS'));
        $cmd=str_replace('$size',floor($sizeM['size']),$cmd);

        $res=executeClass::execute($cmd);
        if($res['return'] !=0 ){
            exceptionHandlerClass::saveError(implode('<br>',$res['output']));
            return false;
        }else{
            exceptionHandlerClass::saveMessage(implode('<br>',$res['output']));
            return true;
        }
    }

    function changeLabel($newLabel){

        $mountPoint=$this->isMounted();
        if($mountPoint){
            $this->umount();
        }
        
        $cmd=str_replace('$partitionName',$this->partitionName,sfConfig::get('app_oipartition_changeNtfsLabel'));
        $cmd=str_replace('$newLabel',$newLabel,$cmd);
        exceptionHandlerClass::saveMessage("cmd::: $cmd");
        $res=executeClass::execute($cmd);
        if($res['return'] !=0 ){
            exceptionHandlerClass::saveError(implode('<br>',$res['output']));
            return false;
        }else{
            exceptionHandlerClass::saveMessage(implode('<br>',$res['output']));
            return true;
        }

        if($mount){
            $this->mount($mountPoint);
        }
    }

    


}
?>
