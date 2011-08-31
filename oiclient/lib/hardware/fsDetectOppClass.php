<?php

class fsDetectOppClass  extends FileSystemOppClass {


    function __construct($disk,$partitionNumber,$partitionName,$partitionTypeId) {
        parent::__construct($disk,$partitionNumber,$partitionName,$partitionTypeId);
    }

    function isOIFileSystem() {
        $this->__get('label');
        if($this->label==sfConfig::get('app_oi_cachelabel') && $this->type=='ext3') {
            return true;
        }else {
            return false;
        }
    }

    function fsType( ) {

        if(is_null($this->partitionTypeId)){
            return null;
        }
        
        if($this->isOIFileSystem()) {
            return new oiSystemOppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);;
        }

        if( $this->type=='swap'){
            if( $this->partitionTypeId==82 ) {
                return new swapOppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);
            }else{
                return null;
            }
        }

        if( $this->partitionTypeId=='f') {
            //extended partition
            return null;
        }


        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;

        }


        if(!empty($mountPoint)) {
           
            if($this->partitionTypeId=='7' && is_file($mountPoint.'/boot.ini') && is_file($mountPoint.'/ntldr' ) ) {
                $fsType= new windowsXPOppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);
                //exceptionHandlerClass::saveMessage("partition: ".$this->partitionName . " os: windowsXP" );


            }elseif($this->partitionTypeId=='7' && is_file($mountPoint.'/bootmgr') && is_dir($mountPoint.'/Boot' ) && !is_file($mountPoint.'/config.sys') ) {
                //exceptionHandlerClass::saveMessage("partition: ".$this->partitionName . " os: windows7System" );
                $fsType= new windows7SystemOppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);

            }elseif($this->partitionTypeId=='7' && !is_file($mountPoint.'/bootmgr') && is_dir($mountPoint.'/Recovery') && is_dir($mountPoint.'/ProgramData') && !is_file($mountPoint.'/boot.ini')  ) {
                //exceptionHandlerClass::saveMessage("partition: ".$this->partitionName . " os: windows7Boot" );
                $fsType= new windows7BootOppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);

            }elseif($this->partitionTypeId=='7' && is_file($mountPoint.'/config.sys') && !is_file($mountPoint.'/boot.ini') &&  is_file($mountPoint.'/bootmgr') ) {
                $fsType= new windows7OppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);
            }elseif(is_file($mountPoint.'/etc/fstab') && is_dir($mountPoint.'/dev/') && is_dir($mountPoint.'/var/') ) {
                $fsType= new linuxOppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);

            }elseif($this->partitionTypeId==83 && $this->type=='ext2' ){
                $fsType= new extOppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);
            }elseif($this->partitionTypeId==7 && $this->type=='ntfs'){
                $fsType= new ntfsOppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);
            }else {
                $fsType= new fileSystemOppClass($this->disk,$this->partitionNumber,$this->partitionName,$this->partitionTypeId);
            }
        }else {
            $fsType=null;
        }
        if(!$mountedAlready) {
            $this->umount();
        }
        return $fsType;

    }
}
?>
