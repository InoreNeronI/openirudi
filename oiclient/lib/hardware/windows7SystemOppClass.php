<?php

class windows7SystemOppClass extends windowsOppClass {

    function __construct($disk, $partitionNumber, $partitionName, $partitionTypeId) {
        parent::__construct($disk, $partitionNumber, $partitionName, $partitionTypeId);
        $this->__set('os', 'windows7system');
        $this->__set('bootable', true);
    }

    function postDeploy() {

        exceptionHandlerClass::saveMessage("modify Windows7 system uuid");
        //$this->changeUUID($destPartition);
        $this->fixMbr();
        $bcd = new BCDClass();
        $bcd->makeBootable();
        
        $hw=systemOppClass::getComputer();
        $osList=$hw->listDisks->partitionsOS(false);
        
        if(in_array('windows7boot',$osList)){
            
            $partitionName=array_search('windows7boot',$osList);
            $diskName=$hw->listDisks->diskOfpartition($partitionName);
            
            $fs=$hw->listDisks->disks[$diskName]->partitions[$partitionName]->fileSystem;
            $fs->changeHostName();
            $fs->changeIPAddress();
   
        }
        
        
    }

    function makeBootable() {
        exceptionHandlerClass::saveMessage("make windows 7 bootable");
        return $this->fixMbr();
    }

    function fixMbr() {
        exceptionHandlerClass::saveMessage("fix Windows 7 MBR");

        $cmd = str_replace('$partition', '/dev/' . $this->partitionName, sfConfig::get('app_oipartition_winStandalone'));
        $cmd = str_replace('$type', $this->os, $cmd);
        $re = executeClass::execute($cmd);
        exceptionHandlerClass::saveMessage("result:: " . implode('<br>', $re['output']));
        if ($re['return'] === false) {
            exceptionHandlerClass::saveMessage("An error ocurred fixing windows mbr");
            exceptionHandlerClass::saveMessage("cmd $cmd");
            exceptionHandlerClass::saveMessage(implode('<br>',$re['output']));
            return false;
        } else {
            exceptionHandlerClass::saveMessage("Windows 7 MBR fixed sucessfully");
            return true;
        }
    }

    function changeHal() {

    }

    function changeKernel() {
        
    }

    function grubMenuOptionInOiSystem() {
        $label = sfConfig::get('app_grub_label');

        $diskLetter = substr($this->disk, -1);
        $l = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j');
        $diskNumber = array_search($diskLetter, $l);
        $label = "{$label} windows7";
        $str = "menuentry \"$label\" {
            set root=(hd{$diskNumber},{$this->partitionNumber})
            chainloader +1
            set GRUB_DEFAULT=0
            save_env GRUB_DEFAULT
            }
            ";
        return array($label => $str);
    }

}

?>
