<?php

class hardwareDetectOppClass {

    private $hardwareArray;
    private $hardDetail;
    private $lspci;
    private $lsusb;
    private $listDisks;
    private $motherBoard;
    private $cpuDescription;
    private $cpuFrecuency;
    private $ramType;
    private $ramSize;
    private $network;
    private $pcID;

    function __construct() {
        $sfUser = sfContext::getInstance()->getUser();
        $sfUser->setAttribute('partitionTypes', partitionOppClass::get_partitionTypes());
        $resync = executeClass::StrExecute(sfConfig::get('app_oipartition_reSyncDisk'));

        $this->hardwareArray = unserialize(str_replace(
                                array('O:16:"SimpleXMLElement":0:{}', 'O:16:"SimpleXMLElement":'),
                                array('s:0:"";', 'O:8:"stdClass":'),
                                serialize($this->hardwareArray)));
        $this->set_listDisks();
        $this->set_lspci();
        $this->set_lsusb();

        //ImageServerOppClass::savePcConfig($this->registryArray());
        //exceptionHandlerClass::saveMessage("AAA: ".print_r($this->registryArray(),1) );
    }

    function __get($propertyName) {
        try {
            if (property_exists('hardwareDetectOppClass', $propertyName)) {
                if (empty($this->$propertyName)) {
                    $this->__set($propertyName, '');
                }
                return $this->$propertyName;
            }
            throw new Exception("&&Invalid property value \"{$propertyName}\"");
        } catch (Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function __set($propertyName, $value) {
        try {
            if (!property_exists('hardwareDetectOppClass', $propertyName)) {
                throw new Exception("Invalid property value \"{$propertyName}\" in hardwareDetectOppClass ");
            }
            if (method_exists($this, 'set_' . $propertyName)) {
                call_user_func(array($this, 'set_' . $propertyName), $value);
            } else {
                throw new Exception("*Invalid property value \"{$propertyName}\" in hardwareDetectOppClass ");
            }
        } catch (Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function set_pcID(){
        $this->__get('listDisks');
        $this->__get('network');

        $d1=$this->listDisks->diskSerials();
        $d=array_shift($d1);

        $this->pcID = str_replace(' ','',"{$this->network->deviceHwInfo}{$d}");
    }

    function set_hardwareArray() {

        $hw_xml = executeClass::StrExecute(sfConfig::get('app_command_lshw'));

        $lshw = new lshwParseClass();
        $this->hardwareArray = $lshw->hardwareList($hw_xml);
    }

    function set_hardDetail() {
        $this->__get('hardwareArray');
        $strKendu = array('Array', '(', ')', '=>', "\n", ' ');
        $strBerri = array('', '', '', '=', '<br>', '&nbsp;');
        $this->hardDetail = str_replace($strKendu, $strBerri, print_r($this->hardwareArray, 1));
    }

    function set_listDisks() {
        $this->listDisks = new listDisksOppClass();
        foreach ($this->listDisks->disks as $disk) {
            $disk->sectorsMap();
        }
    }

    function set_network() {
        $this->network = new networkOppClass();
    }

    function set_cpuDescription() {
        $this->__get('hardwareArray');
        $cpu = array();
        $keys = array_keys($this->hardwareArray['core']);
        foreach ($keys as $k) {
            if (strpos($k, 'cpu') !== false && isset($this->hardwareArray['core'][$k]['product'])) {
                $cpu[] = $this->hardwareArray['core'][$k]['product'];
            }
        }
        $this->cpuDescription.=implode("<br>", $cpu);
    }

    function set_cpuFrecuency() {
        $this->__get('hardwareArray');
        $this->cpuFrecuency = unitsClass::sizeUnit($this->cpu = $this->hardwareArray['core']['cpu']['size']);
    }

    function set_motherBoard() {
        $this->__get('hardwareArray');
        if (isset($this->hardwareArray['core']['product'])) {
            $this->motherBoard = $this->hardwareArray['core']['product'];
        } elseif (isset($this->hardwareArray['product'])) {
            $this->motherBoard = $this->hardwareArray['product'];
        } else {
            $this->motherBoard = '';
        }
    }

    function set_ramSize() {
        $this->__get('hardwareArray');
        if(isset($this->hardwareArray['core']['memory:0']['capacity'])){
            $this->ramSize = unitsClass::sizeUnit($this->hardwareArray['core']['memory:0']['capacity']);
        }elseif(isset($this->hardwareArray['core']['memory']['capacity'])){
            $this->ramSize = unitsClass::sizeUnit($this->hardwareArray['core']['memory']['capacity']);
        }else{
            $this->ramSize ="";
        }
    }

    function set_ramType() {
        $this->__get('hardwareArray');

        if( isset($this->hardwareArray['core']['memory:0'])){
            $mem=$this->hardwareArray['core']['memory:0'];
        }elseif($this->hardwareArray['core']['memory']){
            $mem=$this->hardwareArray['core']['memory'];
        }else{
            $mem=array();
        }
        

        $r = '';
        foreach ($mem as $k => $v) {
            if (is_array($v) && strpos($k, 'bank:') !== false) {
                if (isset($v['size']) && !empty($v['size'])) {
                    $b = unitsClass::sizeUnit($v['size']);
                    $bb = "( " . $b['size'] . $b['unit'] . " )";
                } else {
                    $bb = '';
                }

                $r.= "<br> slot (" . $v['slot'] . ") = " . $v['description'] . " $bb ";
            }
        }
        $this->ramType = $r;
    }

    function set_lspci() {
        $i = 0;
        foreach (glob("/sys/bus/pci/devices/*") as $bus) {
            $this->lspci[$i]['vendor'] = str_replace('0x', '', trim(file_get_contents($bus . '/vendor')));
            $this->lspci[$i]['device'] = str_replace('0x', '', trim(file_get_contents($bus . '/device')));
            $this->lspci[$i]['svendor'] = str_replace('0x', '', trim(file_get_contents($bus . '/subsystem_vendor')));
            $this->lspci[$i]['sdevice'] = str_replace('0x', '', trim(file_get_contents($bus . '/subsystem_device')));

            $a = parse_ini_file($bus . '/uevent');
            $this->lspci[$i]['subsys'] = str_replace(':', '', $a['PCI_SUBSYS_ID']);
            $this->lspci[$i]['pci_id'] = str_replace(':', '', $a['PCI_ID']);
            if (isset($a['DRIVER'])) {
                $this->lspci[$i]['driver'] = str_replace(':', '', $a['DRIVER']);
            }
            $this->lspci[$i]['rev'] = '00';
            $i++;
        }
    }

    function set_lsusb() {
        $i = 0;
        $this->lsusb = array();
        foreach (glob("/sys/bus/usb/devices/*") as $bus) {
            if (file_exists($bus . '/idVendor'))
                $this->lsusb[$i]['idVendor'] = trim(file_get_contents($bus . '/idVendor'));
            if (file_exists($bus . '/idProduct'))
                $this->lsusb[$i]['idProduct'] = trim(file_get_contents($bus . '/idProduct'));
            if (file_exists($bus . '/bcdDevice'))
                $this->lsusb[$i]['bcdDevice'] = trim(file_get_contents($bus . '/bcdDevice'));
            if (file_exists($bus . '/idVendor'))
                $this->lsusb[$i]['bDeviceClass'] = trim(file_get_contents($bus . '/bDeviceClass'));
            if (file_exists($bus . '/bDeviceSubClass'))
                $this->lsusb[$i]['bDeviceSubClass'] = trim(file_get_contents($bus . '/bDeviceSubClass'));
            if (file_exists($bus . '/bDeviceProtocol'))
                $this->lsusb[$i]['bDeviceProtocol'] = trim(file_get_contents($bus . '/bDeviceProtocol'));
            if (file_exists($bus . '/bInterfaceClass'))
                $this->lsusb[$i]['bInterfaceClass'] = trim(file_get_contents($bus . '/bInterfaceClass'));
            if (file_exists($bus . '/bInterfaceSubClass'))
                $this->lsusb[$i]['bInterfaceSubClass'] = trim(file_get_contents($bus . '/bInterfaceSubClass'));
            if (file_exists($bus . '/bInterfaceProtocol'))
                $this->lsusb[$i]['bInterfaceProtocol'] = trim(file_get_contents($bus . '/bInterfaceProtocol'));

            $i++;
        }
    }

    function registryArray() {
        $this->__get('network');
        $this->__get('pcID');
        
        $registryArray['mac'] = $this->network->deviceHwInfo;
        $registryArray['hddid'] = $this->pcID;
        $registryArray['name'] = $this->network->hostname;

        if (isset($this->network->ipAddress['main']['ip']) && !empty($this->network->ipAddress['main']['ip'])) {
            if ($this->network->ipAddress['main']['dhcp'] == 1) {
                $registryArray['ip'] = 'dhcp';
            } else {
                $registryArray['ip'] = $this->network->ipAddress['main']['ip'];
                $registryArray['netmask'] = $this->network->ipAddress['main']['netmask'];
                $registryArray['gateway'] = $this->network->route['default']['gateway'];
            }
        }
        $registryArray['dns'] = implode(',', $this->network->dns);
        
        $p = array();
        foreach ($this->listDisks->disks as $disk) {
            $serial = $disk->serialNumber;
            $i = 0;
            $p[$serial]['disks'][]=$disk->diskName;
            if(count($disk->partitions) > 0){
                foreach ($disk->partitions as $partition) {
                    $p[$serial][$i]['partitionName'] = $partition->partitionName;
                    $p[$serial][$i]['startSector'] = $partition->startSector;
                    $p[$serial][$i]['sectors'] = $partition->sectors;
                    $p[$serial][$i]['size'] = $partition->humanSize['size'] . $partition->humanSize['unit'];
                    $p[$serial][$i]['partitionTypeId'] = $partition->partitionTypeId;
                    $p[$serial][$i]['partitionTypeName'] = $partition->partitionTypeName;
                    $p[$serial][$i]['fstype'] = $partition->fstype;
                    $i++;
                }
            }
        }
        $registryArray['partitions'] = serialize($p);
        return $registryArray;


    }

}
?>
