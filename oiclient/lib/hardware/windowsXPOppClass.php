<?php

class windowsXPOppClass  extends windowsOppClass {

    function __construct($disk,$partitionNumber,$partitionName,$partitionTypeId) {
        parent::__construct($disk,$partitionNumber,$partitionName,$partitionTypeId);
        $this->__set('os', 'windowsXP');
        $this->__set('bootable', true);
    }

    function postDeploy(){

        $this->fixMbr();
        $this->parseBootIniFile();
        $this->changeHostName();
        $this->changeIPAddress();
        $this->newDevicesRegistry();

    }
    
    function makeBootable( ) {
        exceptionHandlerClass::saveMessage("make windows standAlone<br>");
        //$this->parseBootIniFile();
        return $this->fixMbr();
    }

    function changeHal(){

    }

    function changeKernel(){
        
    }

    function changeIPAddress(){

        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;
        }
        $hiveFile='/WINDOWS/system32/config/system';

        if(!empty($mountPoint) && is_file($mountPoint.$hiveFile) ) {
            exceptionHandlerClass::saveMessage("change ip address");
            $hw=systemOppClass::getComputer();
            $registry=new windowsRegistryClass($mountPoint.$hiveFile,'HKEY_LOCAL_MACHINE\system');

            $rKey1=$registry->getRealKey('hkey_local_machine\system\controlset001\control\class\{4d36e972-e325-11ce-bfc1-08002be10318}\0001');
             
            $netPtree=$registry->getObjectsArray('',$rKey1 );

            if($netPtree===false){
                exceptionHandlerClass::saveMessage("Error readinf netkey");
                return;
            }
           
            if(isset($netPtree['hkey_local_machine']['system']['controlset001']['control']['class']['{4d36e972-e325-11ce-bfc1-08002be10318}']['0001']['netcfginstanceid'])){
                $netkey=strtolower($netPtree['hkey_local_machine']['system']['controlset001']['control']['class']['{4d36e972-e325-11ce-bfc1-08002be10318}']['0001']['netcfginstanceid']);
            }else{
                $netkey='';
            }
            exceptionHandlerClass::saveMessage("netkey $netkey");

            $rKey2=$registry->getRealKey('hkey_local_machine\system\controlset001\services\\'.$netkey.'\parameters\tcpip');

            $netPtree2=$registry->getObjectsArray('',$rKey2 );

            if(empty($netkey) || !isset($netPtree2['hkey_local_machine']['system']['controlset001']['services'][$netkey]['parameters']['tcpip'])){
                exceptionHandlerClass::saveMessage("I not found tcp/ip parameters");
                exceptionHandlerClass::saveMessage("Not found netkey $netkey in controlset001\services");
                //exceptionHandlerClass::saveMessage(print_r($netPtree2['hkey_local_machine']['system']['controlset001']['services'][$netkey],1));
                //return;

            } else {

                if($hw->network->ipAddress['main']['dhcp']==1){

                    $rKey1=$registry->getRealKey('ControlSet001\Services\\'.$netkey.'\parameters\tcpip');
                    $registry->modifyDwordKey($rKey1,'EnableDHCP','1');

                    $rKey1=$registry->getRealKey('ControlSet001\Services\Tcpip\Parameters\Interfaces\\'.$netkey );
                    $registry->modifyDwordKey($rKey1,'EnableDHCP',1);


                }else{

                    $rKey1=$registry->getRealKey('ControlSet001\Services\\'.$netkey.'\parameters\tcpip');
                    $registry->modifyDwordKey($rKey1,'EnableDHCP','0');


                    $iph=$registry->txt2hex($hw->network->ipAddress['main']['ip']);
                    $registry->modifyHexKey($rKey1,'D','IPAddress',$iph);

                    $ipm=$registry->txt2hex($hw->network->ipAddress['main']['netmask']);
                    $registry->modifyHexKey($rKey1,'D','SubnetMask',$ipm);

                    $ipg=$registry->txt2hex($hw->network->route['default']['gateway']);
                    $registry->modifyHexKey($rKey1,'D','DefaultGateway',$ipg);

                    $rKey2=$registry->getRealKey('ControlSet001\Services\Tcpip\Parameters\Interfaces\\'.$netkey);
                    $registry->modifyDwordKey($rKey2,'EnableDHCP','0');

                    $registry->modifyStrKey($rKey2,'NameServer', $hw->network->dns[0]);

                }
            }
        }

        if(!$mountedAlready) {
            $this->umount();
        }
    }

    function changeHostName(){
        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;
        }
        
        $hiveFile='/WINDOWS/system32/config/system';

        if(!empty($mountPoint) && is_file($mountPoint.$hiveFile) ) {
            exceptionHandlerClass::saveMessage("change hostname");
            $hw=systemOppClass::getComputer();
            $registry = new windowsRegistryClass($mountPoint.$hiveFile,'HKEY_LOCAL_MACHINE\system' );


            $rKey1=$registry->getRealKey('ControlSet001\Control\ComputerName\ComputerName');
            $registry->modifyStrKey($rKey1,'ComputerName',$hw->network->hostname);

            $rKey2=$registry->getRealKey('ControlSet001\services\Tcpip\Parameters');
            $registry->modifyStrKey( $rKey2 ,'Hostname',$hw->network->hostname);
            
            $rKey3=$registry->getRealKey('ControlSet001\services\Tcpip\Parameters' );
            $registry->modifyStrKey($rKey3,'NV Hostname',$hw->network->hostname);

        }
        if(!$mountedAlready) {
            $this->umount();
        }
    }

    function newDevicesRegistry(){
        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;
        }

        $hiveFile='/WINDOWS/system32/config/system';
        if(!empty($mountPoint) && is_file($mountPoint.$hiveFile) ) {
            $hw=systemOppClass::getComputer();

            $registry = new windowsRegistryClass($mountPoint.$hiveFile,'HKEY_LOCAL_MACHINE\system' );

            //--mountedDevices-------------

            $devices=$registry->getObjectsArray('MountedDevices','',true);

            $old=trim($devices['hkey_local_machine']['system']['mounteddevices']['\\\\DosDevices\\\\C:']);
            $cguid='';
            foreach ($devices['hkey_local_machine']['system']['mounteddevices']  as $guid => $value ){

                if( trim($value) == $old && $guid != '\\\\DosDevices\\\\C:' ){
                    $cguid=$guid;
                }
            }

            $old=str_replace('hex:', '', $old);
            $oldSignature=strtoupper(dechex(hexdec(implode('', array_reverse(explode(',',substr($old,0,11)))))));
            $oldOffset=strtoupper( unitsClass::longDec2hex(hexdec(implode('', array_reverse(explode(',',substr($old,12,36)))))));

            $xpDiskSignature=$hw->listDisks->disks[$this->disk]->diskSignature;
            $xpsStart=unitsClass::diskSector2SizeHex($hw->listDisks->disks[$this->disk]->partitions[$this->partitionName]->startSector);

            $xpDiskSignature=str_pad($xpDiskSignature, 8, "0", STR_PAD_LEFT);
            $xpsStart=str_pad($xpsStart, 16, "0", STR_PAD_LEFT);

            exceptionHandlerClass::saveMessage("new signature:  $xpDiskSignature new offset: $xpsStart");
            $xpsStart1=array_reverse(str_split("{$xpsStart}",2));
            $xpDiskSignature1=array_reverse(str_split("{$xpDiskSignature}",2));

            $new=implode(',',array_merge($xpDiskSignature1,$xpsStart1) );

            $keyElement=$registry->getRealKey( 'mounteddevices' );
            $registry->modifyHexKey( $keyElement,'B','\\\\DosDevices\\\\C:',$new );
            $registry->modifyHexKey( $keyElement,'B',"$cguid",$new );


            //--Disk partition-------------

            $ftdisk=$registry->getObjectsArray('ControlSet001\Enum\Root\ftdisk\0000','',true);
            $ParentIdPrefix=trim($ftdisk['hkey_local_machine']['system']['controlset001']['enum']['root']['ftdisk']['0000']['ParentIdPrefix']);


            $newLength=strtoupper(unitsClass::longDec2hex($hw->listDisks->disks[$this->disk]->partitions[$this->partitionName]->sectorBytes * ($hw->listDisks->disks[$this->disk]->partitions[$this->partitionName]->sectors +1 ) ));
            $newSignature=strtoupper(dechex(hexdec(implode('',str_split("{$xpDiskSignature}",2)))));
            $newOffset=strtoupper(unitsClass::longDec2hex(hexdec(implode('',array_reverse($xpsStart1)))));
            $oldvolumes=$registry->getObjectsArray('ControlSet001\Enum\STORAGE\Volume\\','',true );


            $oldattribs='';
            foreach($oldvolumes['hkey_local_machine']['system']['controlset001']['enum']['storage']['volume'] as $volume => $oldattribs1  ){
                if(stripos($volume, 'Offset'.$oldOffset ) !== false ){
                    $oldattribs=$oldattribs1;
                    break;
                }
            }

            $key1='HKEY_LOCAL_MACHINE\system\ControlSet001\Enum\STORAGE\Volume\\'.$ParentIdPrefix.'&Signature'.$newSignature.'Offset'.$newOffset.'Length'.$newLength;
            exceptionHandlerClass::saveMessage("new volume $key1");

            if(!empty($oldattribs1)){
                $registry->importArray("$key1", $oldattribs);
            }else{
                $registry->modifyStrKey("$key1" ,'','');
            }

            $key2="{$key1}\LogConf";
            $registry->modifyStrKey( $key2 ,'','');

            //----------new disk Devices----------

            $model=str_pad($hw->listDisks->disks[$this->disk]->model, 40 , "_", STR_PAD_RIGHT);
            $firmware=str_pad($hw->listDisks->disks[$this->disk]->firmwareRevision, 8 , "_",STR_PAD_RIGHT);
            $stNs=str_split($hw->listDisks->disks[$this->disk]->serialNumber);
            foreach($stNs as  $i=> $ns ){
                $i2=(($i%2)==0) ? $i+1 : $i-1 ;
                $chs[$i2]=unitsClass::longDec2hex(ord($ns));
            }
            ksort($chs);
            $serialNumber=str_pad(implode('',$chs),40,'20');

            //[\\ControlSet001\Control\DeviceClasses\{53f56307-b6bf-11d0-94f2-00a0c91efb8b}\##?#IDE#DiskST320413A_______________________________3.39____#45363144304e5231202020202020202020202020#{53f56307-b6bf-11d0-94f2-00a0c91efb8b}]
            //"DeviceInstance"="IDE\\DiskST320413A_______________________________3.39____\\45363144304e5231202020202020202020202020"

            $key1='HKEY_LOCAL_MACHINE\\system\ControlSet001\Control\DeviceClasses\{53f56307-b6bf-11d0-94f2-00a0c91efb8b}\##?#IDE#Disk'.$model.$firmware.'#'.$serialNumber.'#{53f56307-b6bf-11d0-94f2-00a0c91efb8b}';
            $attrib='DeviceInstance';
            $v='IDE\\Disk'.$model.$firmware.'\\'.$serialNumber;
            $registry->modifyStrKey("{$key1}" ,$attrib,$v);
            //exceptionHandlerClass::saveMessage("Disk key: $key1");

            //[\\ControlSet001\Control\DeviceClasses\{53f56307-b6bf-11d0-94f2-00a0c91efb8b}\##?#IDE#DiskST320413A_______________________________3.39____#45363144304e5231202020202020202020202020#{53f56307-b6bf-11d0-94f2-00a0c91efb8b}\#]
            //"SymbolicLink"="\\\\?\\IDE#DiskST320413A_______________________________3.39____#45363144304e5231202020202020202020202020#{53f56307-b6bf-11d0-94f2-00a0c91efb8b}"
            $key1="$key1\\#";
            $attrib='SymbolicLink';
            $v='\\\\?\\IDE#Disk'.$model.$firmware.'#'.$serialNumber;
            $registry->modifyStrKey("{$key1}" ,$attrib,$v);

        }

        if(!$mountedAlready) {
            $this->umount();
        }


    }

    function fixMbr(){
        exceptionHandlerClass::saveMessage("fix Windows MBR");
        $cmd=str_replace('$partition','/dev/'.$this->partitionName,sfConfig::get('app_oipartition_winStandalone'));
        $cmd=str_replace('$type',$this->os,$cmd);
        $re=executeClass::execute($cmd);
        $hw=systemOppClass::getComputer(true);

        if($re['return']===false ){
            exceptionHandlerClass::saveMessage("An error ocurred fixing windows mbr" );
            return false;
        }else{
            return true;
        }
    }
    

    function parseBootIniFile() {
        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;
        }

        if(!empty($mountPoint)) {
            $iniFile=$mountPoint.'/boot.ini';
            if(is_file($iniFile)) {
                $menu=manageIniFilesClass::readIniFile($iniFile);
            }else {
                exceptionHandlerClass::saveMessage("ERROR parsing boot.ini \n");
            }

            if($menu !== false || !empty($menu)){
                //$menu['default']
                $menu['boot loader']['default']=ereg_replace('partition\([0-9]\)', 'partition('.$this->partitionNumber.')', $menu['boot loader']['default']);
                unset($menu['operating systems']);
                $menu['operating systems'][$menu['boot loader']['default']]='"OpenIrudi Windows restauration" /noexecute=optin /fastdetect';

                $menu=manageIniFilesClass::writeWinIniFile($iniFile,$menu);
            }

        }
        $hiveFile='/WINDOWS/system32/config/system';
        $registry = new windowsRegistryClass($mountPoint.$hiveFile,'HKEY_LOCAL_MACHINE\system' );
        $rKey2=$registry->getRealKey('ControlSet001\Control');
        $registry->modifyStrKey( $rKey2 ,'SystemBootDevice', "multi(0)disk(0)rdisk(0)partition({$this->partitionNumber})" );



        if(!$mountedAlready) {
            $this->umount();
        }
        //modify /boot.ini

    }

    function grubMenuOptionInOiSystem( ) {
        $label=sfConfig::get('app_grub_label');

        $diskLetter=substr($this->disk,-1);
        $l=array('a','b','c','d','e','f','g','h','i','j');
        $diskNumber=array_search($diskLetter,$l);
        $label="{$label} windowsXP";
        $str="menuentry \"$label\" {
            set root=(hd{$diskNumber},{$this->partitionNumber})
            chainloader +1
            set GRUB_DEFAULT=0
            save_env GRUB_DEFAULT
            }
            ";
        return array($label=>$str);
        
    }

    
    
}
?>
