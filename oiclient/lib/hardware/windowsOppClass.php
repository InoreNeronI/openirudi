<?php

class windowsOppClass  extends ntfsOppClass {

//    function __construct($disk,$partitionNumber,$partitionName,$partitionTypeId) {
//        parent::__construct($disk,$partitionNumber,$partitionName,$partitionTypeId);
//        $this->__set('os', 'windows');
//        $this->__set('bootable', true);
//    }
    
    
        
    public function getWinDriver($hw) {
        
        $returnPci = $this->scanPciDriver($hw->lspci);
        $PciErrors = $returnPci[0];
        $PciSuccesses = $returnPci[1];

        $returnUsb = $this->scanUsbDriver($hw->lsusb);
        $UsbErrors = $returnUsb[0];
        $UsbSuccesses = $returnUsb[1];
        
        return array($PciErrors, $PciSuccesses, $UsbErrors, $UsbSuccesses);
    }

    function scanPciDriver( $lspci ) {

        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;
        }
        $DriverServer=ImageServerOppClass::address();
        $serverPathPattern = sfConfig::get('app_driver_driverUrl');
        $sysprepWinPath = sfConfig::get('app_driver_sysprepwinpath');
        $defaultWinPath = sfConfig::get('app_driver_defaultwinpath');

        $vars = array('$server','$type','$vendor','$device','$subsys','$rev');
        $i = 1;
        $error = array();
        $success = array();

        foreach ( $lspci as $dev) {

            $values = array($DriverServer, 'pci', $dev['vendor'], $dev['device'], $dev['subsys'], $dev['rev']);
            $vid = $dev['vendor'];
            $pid = $dev['device'];
            if ($dev['subsys'] != '00000000')   $subsys = $dev['subsys'];
            if ($dev['rev'] != '00')   $rev = $dev['rev'];
            $url = str_replace($vars,$values,$serverPathPattern);
exceptionHandlerClass::saveError("url:: $url");
            try {
                $zipped_driver = '';
                if ($zipped_driver = @fopen($url, 'r')) {
                    // imprimir toda la pagina comenzando en la posicion 10
                    $content = stream_get_contents($zipped_driver);
                    if (strlen($content) != 0) {
                        $zipFile = '/tmp/'.$i.'.zip';
                        file_put_contents($zipFile, $content);
                        if (is_dir($mountPoint.'/'.$sysprepWinPath)) {
                            $cmd = sfConfig::get('app_driver_unzip');
                            $cmd = str_replace('$winpath',$mountPoint.'/'.$sysprepWinPath,$cmd);
                            $cmd = str_replace('$zipfile',$zipFile,$cmd);
                            $re = executeClass::execute($cmd);
                            exceptionHandlerClass::saveMessage("Driver saved from: $url to ". $sysprepWinPath );
                            if (isset($subsys) && isset($rev))
                                $success[] = strtoupper('pci\ven_'.$vid.'&dev_'.$pid.'&subsys_'.$subsys.'&rev_'.$rev);
                            elseif (isset($subsys))
                                $success[] = strtoupper('pci\ven_'.$vid.'&dev_'.$pid.'&subsys_'.$subsys);
                            else
                                $success[] = strtoupper('pci\ven_'.$vid.'&dev_'.$pid);
                        } else {
                            if (!is_dir($mountPoint.'/'.$defaultWinPath)) {
                                if (@mkdir($mountPoint.'/'.$defaultWinPath) === false) {
                                    $error[] = __(sprintf("Permission denied for create %s folder", $mountPoint.$defaultWinPath));
                                }
                            }
                            if (is_dir($mountPoint.'/'.$defaultWinPath)) {
                                $cmd = sfConfig::get('app_driver_unzip');
                                $cmd = str_replace('$winpath',$mountPoint.'/'.$defaultWinPath,$cmd);
                                $cmd = str_replace('$zipfile',$zipFile,$cmd);
                                $re = executeClass::execute($cmd);
                                //exceptionHandlerClass::saveMessage("Driver saved from: $url to ".$defaultWinPath );
                                if (isset($subsys) && isset($rev))
                                    $success[] = strtoupper('pci\ven_'.$vid.'&dev_'.$pid.'&subsys_'.$subsys.'&rev_'.$rev);
                                elseif (isset($subsys))
                                    $success[] = strtoupper('pci\ven_'.$vid.'&dev_'.$pid.'&subsys_'.$subsys);
                                else
                                    $success[] = strtoupper('pci\ven_'.$vid.'&dev_'.$pid);
                            } else {
                                //exceptionHandlerClass::saveError($sysprepWinPath." does not exists, and could not create " .$defaultWinPath." path");
                                $error[] = __(sprintf("%s does not exists, and could not create %s path", $sysprepWinPath, $defaultWinPath));
                                break;
                            }
                        }
                    }
                    fclose($zipped_driver);
                    $i++;
                } else {
                    //exceptionHandlerClass::saveError("I am sorry we have not drivers for this device $url" );
                    $error[] = 'No drivers found for '.$url;
                }
            } catch (Exception $ex) {
                //exceptionHandlerClass::saveError("I am sorry we have not drivers for this device  $url" );
                $error[] = 'No drivers found for '.$url;
            }
            unset($vid, $pid);
            if (isset($subsys)) unset($subsys);
            if (isset($rev))    unset($rev);
        }

        if(!$mountedAlready) {
            $this->umount();
        }

        return array($error, $success);
    }

    function scanUsbDriver($lsusb ) {
        
        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;
        }


        $error = array();
        $success = array();
        // TODO
        return array($error, $success);


        if(!$mountedAlready) {
            $this->umount();
        }

    }

    function changeUUID($uuid){

        $this->umount();

        exceptionHandlerClass::saveError("-----CHANGE uuid:  $uuid");
        $f = fopen('/dev/'.$this->partitionName, "c+b");
        fseek($f,72,SEEK_CUR );
        foreach(array_reverse(str_split(trim($x),2)) as $h){
            fwrite($f,chr(hexdec($h)));
        }
        fclose($f);
    }


}
?>
