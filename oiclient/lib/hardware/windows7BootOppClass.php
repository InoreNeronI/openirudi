<?php

class windows7BootOppClass  extends windowsOppClass {

    function __construct($disk,$partitionNumber,$partitionName,$partitionTypeId) {
        parent::__construct($disk,$partitionNumber,$partitionName,$partitionTypeId);
        $this->__set('os', 'windows7boot');
        $this->__set('bootable', false);
        $this->__set('drivers', true);
    }

    function postDeploy(){
        exceptionHandlerClass::saveMessage("windows7 boot postDeploy......");
        
        if(in_array('windows7system',$osList)){
            $partitionName=array_search('windows7system',$osList);
            $diskName=$hw->listDisks->diskOfpartition($partitionName);
            
            $fs=$hw->listDisks->disks[$diskName]->partitions[$partitionName]->fileSystem;
            $fs->postDeploy();

        }else{
//        $bcd = new BCDClass();
//        $bcd->makeBootable();
            $this->changeHostName();
            $this->changeIPAddress();
        }
        
    }

    function changeHostName(){
        if(!$mountPoint=$this->isMounted()) {
            $mountedAlready=false;
            $mountPoint=$this->mount();
        }else {
            $mountedAlready=true;
        }
        $hiveFile='/Windows/System32/config/SYSTEM';

        if(!empty($mountPoint) && is_file($mountPoint.$hiveFile) ) {
            exceptionHandlerClass::saveMessage("change hostname");
            $hw=systemOppClass::getComputer();
            //$registry = new windowsRegistryClass($mountPoint.$hiveFile);
            $registry = new windowsRegistryClass($mountPoint.$hiveFile,'HKEY_LOCAL_MACHINE\system' );

            
            $rKey1=$registry->getRealKey('ControlSet001\Control\ComputerName\ComputerName');
            $registry->modifyStrKey($rKey1,'ComputerName',$hw->network->hostname);

            $rKey2=$registry->getRealKey('ControlSet001\services\Tcpip\Parameters');
            $registry->modifyStrKey( $rKey2 ,'Hostname',$hw->network->hostname);
            
            $rKey3=$registry->getRealKey('ControlSet001\services\Tcpip\Parameters' );
            $registry->modifyStrKey($rKey3,'NV Hostname',$hw->network->hostname);

    


        }else{
            exceptionHandlerClass::saveError("We not found hive file to hostname");
            exceptionHandlerClass::saveError("hive:: ".$mountPoint.$hiveFile );
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
        $hiveFile='/Windows/System32/config/SYSTEM';

        if(!empty($mountPoint) && is_file($mountPoint.$hiveFile) ) {
            exceptionHandlerClass::saveMessage("change ip address");
            $hw=systemOppClass::getComputer();

            $registry=new windowsRegistryClass($mountPoint.$hiveFile,'HKEY_LOCAL_MACHINE\system');

            $netPtree=$registry->getObjectsArray('ControlSet001\Control\Class\{4D36E972-E325-11CE-BFC1-08002BE10318}\0001');
            if($netPtree===false){
                exceptionHandlerClass::saveMessage("Error readinf netkey");
                return;
            }
            
            $netkey=strtolower(trim($netPtree['hkey_local_machine']['system']['controlset001']['control']['class']['{4d36e972-e325-11ce-bfc1-08002be10318}']['0001']['netcfginstanceid']));
            exceptionHandlerClass::saveMessage("netkey $netkey");
           
            $netPtree=$registry->getObjectsArray('ControlSet001\services');

            if(!isset($netPtree['hkey_local_machine']['system']['controlset001']['services'][$netkey]['parameters']['tcpip'])){
                exceptionHandlerClass::saveMessage("I not found tcp/ip parameters");
                exceptionHandlerClass::saveMessage("We not found netkey $netkey in controlset001\\services");
                return;
            }

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

        }else{
            exceptionHandlerClass::saveError("We not found hive file to ip address");
            exceptionHandlerClass::saveError("hive:: ".$mountPoint.$hiveFile );
        }

        if(!$mountedAlready) {
            $this->umount();
        }
    }



    function makeBootable( ) {
    }

    
    function changeHal(){

    }

    function changeKernel(){
        
    }

    function grubMenuOptionInOiSystem( ) {
        $label=sfConfig::get('app_grub_label');

        $diskLetter=substr($this->disk,-1);
        $l=array('a','b','c','d','e','f','g','h','i','j');
        $diskNumber=array_search($diskLetter,$l);
        $label="{$label} windows";
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
