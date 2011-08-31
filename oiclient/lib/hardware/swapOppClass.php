<?php

class swapOppClass extends FileSystemOppClass  {

    function __construct($disk,$partitionNumber,$partitionName,$partitionTypeId){
        parent::__construct($disk,$partitionNumber,$partitionName,$partitionTypeId);
    	//$this->name='linux';
        $this->__set('isOIFileSystem', false);
        $this->__set('mountable', false);
        $this->__set('resizable', true);
	
    }

    function postDeploy(){
        $hw=systemOppClass::getComputer();
        foreach(array_keys($hw->listDisks->partitionsOS(), 'linux') as $partitionName ){
            $diskName=$hw->listDisks->diskOfpartition( $partitionName );
            exceptionHandlerClass::saveMessage("swap post deploy diskName $diskName $partitionName partitionName");
            $hw->listDisks->disks[$diskName]->partitions[$partitionName]->fileSystem->postDeploy();
        }
    }

    function resize($sectors){

    }


}
?>
