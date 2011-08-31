<?php

class winRestoreOppClass {
    private $hw;
    function __construct($hw){
        $this->hw=$hw;
	}

	function __get($propertyName){
		try {
			if(property_exists('winRestoreOppClass', $propertyName)){
				if(empty( $this->$propertyName)){
					$this->__set($propertyName, '');
				}
				return $this->$propertyName;
			}
			throw new Exception("Invalid property name \"{$propertyName}\" in winRestoreOppClass");

		}catch(Exception $e){
			exceptionHandlerClass::saveError($e->getMessage());
		}
	}

	function __set($propertyName, $value){
		try {
			if(!property_exists('winRestoreOppClass', $propertyName)){
				throw new Exception("Invalid property value \"{$propertyName}\" in winRestoreOppClass");
			}
			if(method_exists($this,'set_'.$propertyName)){
				call_user_func(array($this,'set_'.$propertyName),$value);
			}else{
				throw new Exception("*Invalid property value \"{$propertyName}\"in winRestoreOppClass ");
			}

		}catch(Exception $e){
			exceptionHandlerClass::saveError($e->getMessage());
		}
	}

    public function getWinDriver($partition, $DriverServer) {
        $mountPoint = $partition->fileSystem->mount();

        $listPci = $this->hw->lspci;
        $returnPci = self::scanPci($partition, $DriverServer, $listPci, $mountPoint);
        $PciErrors = $returnPci[0];
        $PciSuccesses = $returnPci[1];

        $listUsb = $this->hw->lsusb;
        $returnUsb = self::scanUsb($partition, $DriverServer, $listUsb, $mountPoint);
        $UsbErrors = $returnUsb[0];
        $UsbSuccesses = $returnUsb[1];

        $partition->fileSystem->umount();
        
        return array($PciErrors, $PciSuccesses, $UsbErrors, $UsbSuccesses);
    }

    static function scanPci($partition, $DriverServer, $list, $mountPoint) {
        $serverPathPattern = sfConfig::get('app_driver_driverUrl');
        $sysprepWinPath = sfConfig::get('app_driver_sysprepwinpath');
        $defaultWinPath = sfConfig::get('app_driver_defaultwinpath');
        $vars = array('$server','$type','$vendor','$device','$subsys','$rev');
        $i = 1;
        $error = array();
        $success = array();

        foreach ($list as $dev) {
            $values = array($DriverServer, 'pci', $dev['vendor'], $dev['device'], $dev['subsys'], $dev['rev']);
            $vid = $dev['vendor'];
            $pid = $dev['device'];
            if ($dev['subsys'] != '00000000')   $subsys = $dev['subsys'];
            if ($dev['rev'] != '00')   $rev = $dev['rev'];
            $url = str_replace($vars,$values,$serverPathPattern);
            try {
                $zipped_driver = '';
                if ($zipped_driver = fopen($url, 'r')) {
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
        return array($error, $success);
    }

    static function scanUsb($partition, $DriverServer, $list, $mountPoint) {
        $error = array();
        $success = array();
        // TODO
        return array($error, $success);
    }

} ?>