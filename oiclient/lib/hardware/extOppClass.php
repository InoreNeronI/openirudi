<?php

class extOppClass extends FileSystemOppClass {

    function __construct($disk,$partitionNumber,$partitionName,$partitionTypeId) {
        parent::__construct($disk,$partitionNumber,$partitionName,$partitionTypeId);
        $this->__set('mountable', true);
        $this->__set('resizable', true);
        $this->__set('bootable', false);
    }

    function postDeploy(){
        
    }

    function resize($PartitionSectors) {
        $fsSectors1=ceil($PartitionSectors*0.95);
        $fsBlocks=ceil($fsSectors1/4096);
        $fsSectors=$fsBlocks*4096;

        //resizeExtFS:       'nohup sudo /var/www/openirudi/bin/cloneExt.sh resizeExtFs /dev/$partitionName $size'
        $cmd=str_replace('$partitionName',$this->partitionName,sfConfig::get('app_oipartition_resizeExtFS'));
        $cmd=str_replace('$size',$fsSectors,$cmd);
        
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

        $cmd=str_replace('$partitionName',$this->partitionName,sfConfig::get('app_oipartition_changeExtLabel'));
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
