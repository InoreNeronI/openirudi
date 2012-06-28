<?php

class linuxOppClass extends extOppClass {

    function __construct($disk, $partitionNumber, $partitionName, $partitionTypeId) {
        parent::__construct($disk, $partitionNumber, $partitionName, $partitionTypeId);
        $this->__set('isOIFileSystem', false);
        $this->__set('os', 'linux');
        $this->__set('bootable', true);
    }

    function postDeploy() {
        $this->parseMtabBootable();
        $this->parseFstabBootable($this->whereIsSwap($this->disk));
        $this->changeHostName();
        $this->changeIpAddress();
    }

    function makeBootable() {
        exceptionHandlerClass::saveMessage("make linux standAlone");
        return $this->grubStandalone();

    }

    function changeHostName(){
        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;
        }

        if(!empty($mountPoint) ) {
            $hw=systemOppClass::getComputer();
            
            //sudo /var/www/openirudi/bin/linuxCmd.sh setHostName $mountPoint $newName
            $cmd = str_replace('$mountPoint', $mountPoint, sfConfig::get('app_linux_setHostName'));
            $cmd = str_replace('$newName', $hw->network->hostname, $cmd );
            $re = executeClass::execute($cmd);
            
            if ($re['return'] === false ) {
                exceptionHandlerClass::saveMessage("cmd:: $cmd");
                exceptionHandlerClass::saveMessage("result: " . implode('<br>', $re['output']));
                $result=false;
            } else {
                $result=true;
            }
        }

        if(!$mountedAlready) {
            $this->umount();
        }
    }

    function changeIPAddress(){
        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;
        }

        $hw=  systemOppClass::getComputer();
        $cmd = str_replace('$mountPoint', $mountPoint, sfConfig::get('app_linux_changeIPAddress'));

        if($hw->network->ipAddress['main']['dhcp']!=1){
            $cmd .= ' '.$hw->network->ipAddress['main']['ip'];
            $cmd .= ' '.$hw->network->maskbits($hw->network->ipAddress['main']['netmask']);
            if(isset($hw->network->route['default']['gateway'])) {
                $cmd .= ' '.$hw->network->route['default']['gateway'];
            }
            if(isset($hw->network->dns[0])) {
                $cmd .= ' '.$hw->network->dns[0];
            }
        }
        $re = executeClass::execute($cmd);
        if ($re['return'] === false ) {
            exceptionHandlerClass::saveMessage("cmd:: $cmd");
            exceptionHandlerClass::saveMessage("result: " . implode('<br>', $re['output']));
            $result=false;
        } else {
            $result=true;
        }


        if(!$mountedAlready) {
            $this->umount();
        }

    }

    function grubStandalone() {

        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }
        $result=false;
        if (!empty($mountPoint)) {
            exceptionHandlerClass::saveMessage("Reinstall GRUB to standalone");
            $cmd = str_replace('$mountPoint', $mountPoint, sfConfig::get('app_oipartition_grubStandalone'));
    exceptionHandlerClass::saveMessage("grub install:  $cmd");
            $re = executeClass::execute($cmd);
                        
            if ($re['return'] === false ) {
                exceptionHandlerClass::saveMessage("An error ocurred reinstalling GRUB");
                exceptionHandlerClass::saveMessage("cmd:: $cmd");
                exceptionHandlerClass::saveMessage("resultgrub: " . implode('<br>', $re['output']));
                $result=false;
            } else {

                $result=true;
            }
        }
        if (!$mountedAlready) {
            $this->umount();
        }
        if($result){
            exceptionHandlerClass::saveMessage("GRUB installed in sucefully in disk MBR");
            return true;
        }else{
            exceptionHandlerClass::saveMessage("An error ocurred installing GRUB in disk");
            return false;
        }
    }

    function whereIsSwap($diskName) {
        $hw=systemOppClass::getComputer();
        //$listDisks = new listDisksOppClass();
        foreach ($hw->listDisks->disks[$diskName]->partitions as $partition) {
            if ($partition->partitionTypeId == 82) {
                return $partition;
            }
        }
        return null;
    }

    function resize($sectors) {

        $cmd = str_replace('$diskName', $this->partitions[$candidate['partitionName']]->disk, sfConfig::get('app_oipartition_resizePartition'));
        $cmd = str_replace('$number', $this->partitions[$candidate['partitionName']]->partitionNumber, $cmd);
        $cmd = str_replace('$end', $this->partitions[$candidate['partitionName']]->endSector, $cmd);
        exceptionHandlerClass::saveMessage($cmd);
        $aa = executeClass :: StrExecute($cmd);
    }

    function parseMtabBootable() {
        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }

        if (!empty($mountPoint)) {

            $tmpMtab = '/tmp/mtab';
            $cmd = 'sudo cp ' . $mountPoint . '/etc/mtab' . ' ' . $tmpMtab;
            $r = executeClass::execute($cmd);
            $cmd = 'sudo chmod 777 ' . $tmpMtab;
            $r = executeClass::execute($cmd);

            $mtabFile = new manageFilesClass($tmpMtab);

            $mtab = $mtabFile->readArrayFile();
            $u = preg_grep('/(.+)\ \/\ (.+)/', $mtab);
            if (count($u) > 0) {

                foreach ($u as $rowNum => $entry) {
                    $entry = trim($entry);
                    if (empty($entry))
                        continue;

                    if (preg_match('/^\/dev\/([a-zA-Z0-9]+)\ (.+)/', $entry, $match)) {
                        if ($match[1] == 'root' || $match[1] == 'rootfs') {
                            continue;
                        }
                        $mtab[$rowNum] = "/dev/{$this->partitionName} {$match[2]}\n";
                    }
                }
            }
            $mtabFile->writeFile(implode("", $mtab), 'w');
            $cmd = 'sudo cp ' . $tmpMtab . ' ' . $mountPoint . '/etc/mtab';
            $r = executeClass::execute($cmd);
        }
        if (!$mountedAlready) {
            $this->umount();
        }
    }

    function parseFstabBootable($swapPartition) {
        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }

        if (!empty($mountPoint)) {

            $tmpFstab = '/tmp/fstab';
            $cmd = 'sudo cp ' . $mountPoint . '/etc/fstab' . ' ' . $tmpFstab;
            $r = executeClass::execute($cmd);
            $cmd = 'sudo chmod 777 ' . $tmpFstab;
            $r = executeClass::execute($cmd);


            $fstabFile = new manageFilesClass($tmpFstab);
            $fstab = $fstabFile->readArrayFile();

            //change root filesystem
            $u = preg_grep('/(.+)\ \/\ (.+)/', $fstab);
            if (count($u) > 0) {
                foreach ($u as $rowNum => $entry) {
                    $entry = trim($entry);
                    if (preg_match('/^\/dev\/([a-zA-Z0-9]+)\ (.+)/', $entry, $match)) {
                        $mtab[$rowNum] = "/dev/{$this->partitionName} {$match[2]}\n";
                    } elseif (preg_match('/^UUID=([a-zA-Z0-9\-]+)\ (.+)/', $entry, $match)) {
                        $fstab[$rowNum] = "UUID={$this->uuid} {$match[2]}\n";
                    }
                }
            }

            //change swap filesystem
            if ($swapPartition) {
                $u1 = preg_grep('/(.+)\ swap\ (.+)/', $fstab);
                if (count($u1) > 0) {
                    foreach ($u1 as $rowNum => $entry) {
                        $entry = trim($entry);
                        if (preg_match('/^\/dev\/([a-zA-Z0-9]+)\ (.+)/', $entry, $match)) {
                            $fstab[$rowNum] = "/dev/{$swapPartition->partitionName} {$match[2]}\n";
                        } elseif (preg_match('/^UUID=([a-zA-Z0-9\-]+)\ (.+)/', $entry, $match)) {
                            if (empty($swapPartition->fileSystem->uuid)) {
                                $fstab[$rowNum] = "/dev/{$swapPartition->partitionName} {$match[2]}\n";
                            } else {
                                $fstab[$rowNum] = "UUID={$swapPartition->fileSystem->uuid} {$match[2]}\n";
                            }
                        }
                    }
                }
            }
            $fstabFile->writeFile(implode("", $fstab), 'w');
            $cmd = 'sudo cp ' . $tmpFstab . ' ' . $mountPoint . '/etc/fstab';
            $r = executeClass::execute($cmd);
        }
        if (!$mountedAlready) {
            $this->umount();
        }
    }

    function grubMenuOptionInOiSystem() {
        $label = sfConfig::get('app_grub_label');
        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }

        $str = '';
        if (!empty($mountPoint)) {
            $i = 0;
            $str = array();

            foreach (glob($mountPoint . '/boot/vmlinu*') as $kernel) {
                $pat = '/vmlinu[a-z]-(.+)/';
                preg_match($pat, $kernel, $match);
                unset($kernel);
                unset($initrd);

                if (isset($match[1]) && !empty($match[1])) {
                    $kernel = $match[0];
                    if (is_file($mountPoint . '/boot/initrd.img-' . $match[1])) {
                        $initrd = 'initrd.img-' . $match[1];
                    }
                    $label = "{$label} linux {$this->partitionName} {$i}";
                    $str[$label] = "menuentry \"$label\" {
 set root=(" . grubMenuClass::grubPartitionName($this->partitionName) . ")
 linux   /boot/{$kernel} root=/dev/{$this->partitionName} ro
 ";
                    if (isset($initrd)) {
                        $str[$label].="initrd  /boot/{$initrd}";
                    }
                    $str[$label].="\n set GRUB_DEFAULT=0\n save_env GRUB_DEFAULT\n\n";
                    $str[$label].="}\n";
                }
            }

           
            if (!$mountedAlready) {
                $this->umount();
            }
        }
        return $str;
    }

}


?>
