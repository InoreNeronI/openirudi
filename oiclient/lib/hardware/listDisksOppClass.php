<?php

class listDisksOppClass {

    private $disks = array();

    /*     * **********************************************************************
     * ESPECIAL FUNCTIONS													*
     * ********************************************************************** */

    function __construct() {
        $this->diskDetect();
    }

    function __get($propertyName) {
        try {
            if (property_exists('listDisksOppClass', $propertyName)) {
                return $this->$propertyName;
            }
            throw new Exception("Invalid property name \"{$propertyName}\"");
        } catch (Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function diskDetect() {

        $listDevicesR = executeClass::execute(sfConfig::get('app_command_listDevices'));
        $out = implode("\n", $listDevicesR['output']);
        $listDevices1 = explode('!@@@', $out);

        if ($listDevicesR['return'] != 0 || strpos($out, '!@@@') === false) {
            exceptionHandlerClass::saveMessage('Error detecting disk list');
            return;
        }
        
        $listDevices = explode("\n", $listDevices1[1]);

        foreach ($listDevices as $disk) {
            $disk = trim($disk);
            if (empty($disk) )continue;
            if (filetype('/dev/' . $disk) == 'block') {
                $this->disks[$disk] = new diskOppClass($disk);
            }
        }
    }

    function diskOfpartition($partitionName) {
        foreach (array_keys($this->disks) as $disk) {
            if (!empty($partitionName) && strpos($partitionName, $disk) === 0) {
                return $disk;
            }
        }
        return null;
    }

    function allPartitions() {
        $allPartitions = array();
        foreach ($this->disks as $disk) {
            if(is_array($disk->partitions) && count($disk->partitions)> 0 ){
                foreach ($disk->partitions as $partitionName => $partition) {
                    $allPartitions[$partition->partitionName] = $partition->sectors;
                }
            }
        }
        return $allPartitions;
    }

    function maxPartitionAvailable() {
        $free = 0;
        foreach ($this->disks as $disk) {
            $m=$disk->maxNewPrimaryPartitionSectors;
            if($disk->maxNewPrimaryPartitionSectors < $disk->maxNewLogicPartitionSectors ) {
                $m=$disk->maxNewLogicPartitionSectors;
            }
            if($m>$free){
                $free=$m;
            }
        }
        return $free;
    }

    function diskSerials() {

        $serials = array();
        foreach (array_keys($this->disks) as $disk) {
            $serials[$disk] = $this->disks[$disk]->serialNumber;
        }
        return $serials;
    }

    function oiPartitions() {
        $oiPartitions = array();
        foreach ($this->disks as $disk) {
            foreach ($disk->partitions as $partitionName => $partition) {
                if (!is_null($partition->fileSystem) && $partition->fileSystem->label == sfConfig::get('app_oi_cachelabel')) {
                    $oiPartitions[$partitionName] = $partition;
                }
            }
        }
        return $oiPartitions;
    }

    function bootablePartitions() {
        $bootablePartitions = array();
        foreach ($this->disks as $disk) {
            foreach ($disk->partitions as $partitionName => $partition) {
                if (!is_null($partition->fileSystem) && !is_null($partition->fileSystem->os) && $partition->fileSystem->bootable) {
                    //if ( $partition->partitionNumber<=4 && ! $partition->fileSystem->isOIFileSystem ){
                    $bootablePartitions[] = $partition;
                    //}
                }
            }
        }
        return $bootablePartitions;
    }

    function bootablePartition() {
        $bootablePartition = null;
        $score = 100;
        $boot_opts = explode(',', sfConfig::get('app_grub_bootLoaderOrder'));

//        $partitionsOS=partitionsOS(true);
//        foreach($boot_opts as $opt ){
//            if(in_array($opt, $partitionsOS) ){
//
//            }
//        }

        foreach ($this->disks as $disk) {
            if( count($disk->partitions)>0 ){
                foreach ($disk->partitions as $partitionName => $partition) {
                    if (!is_null($partition->fileSystem) && !is_null($partition->fileSystem->os) && $partition->fileSystem->bootable) {
                        if (false && $partition->fileSystem->isOIFileSystem) {
                            return $partition;
                        } elseif (in_array($partition->fileSystem->os, $boot_opts)) {
                            $ns = array_search($partition->fileSystem->os, $boot_opts);
                            if (isset($boot_opts[$ns]) && $ns < $score) {
                                $bootablePartition = $partition;
                                $score = $ns;
                            }
                        }
                    }
                }
            }
        }
        return $bootablePartition;
    }

    function partitionsOS($oiSystem=true) {
        $osList = array();

        foreach ($this->disks as $disk) {
            foreach ($disk->partitions as $partitionName => $partition) {

                if (!is_null($partition->fileSystem)) {
                    $os = $partition->fileSystem->os;
                    if (!empty($os)) {
                        if($os!='oiSystem' || ( $os=='oiSystem' && $oiSystem==true ))
                        $osList[$partitionName] = $os;
                    }
                }
            }
        }
        return $osList;
    }

    function makeBoot() {
        $hw = systemOppClass::getComputer();
        $result=false;
        $bootablePartition = $this->bootablePartition();
        if ($bootablePartition !== false && is_object($bootablePartition)) {
            exceptionHandlerClass::saveMessage("bootable " . $bootablePartition->partitionName . " os: " . $bootablePartition->fileSystem->os);
            $result=$hw->listDisks->disks[$bootablePartition->disk]->partitions[$bootablePartition->partitionName]->fileSystem->makeBootable();
        }
        if($result==false){
            exceptionHandlerClass::saveError("Error making disk bootable ");
        }
        
        return $result;
    }

    function umountAllpartitions(){
        foreach ($this->disks as $disk) {
            if(count($disk->partitions) > 0 ){
                foreach ($disk->partitions as $partitionName => $partition) {
                    if (!is_null($partition->fileSystem) && !is_null($partition->fileSystem->mountable) && $partition->fileSystem->mountable) {
                        $partition->fileSystem->umount();
                    }
                }
            }
        }

    }

}

?>
