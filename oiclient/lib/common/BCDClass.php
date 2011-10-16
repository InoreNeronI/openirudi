<?php


class BCDClass {
    private $BCD=null;
    private $BCDPartition=null;
    private $registry;

    
    function __construct() {
        if($this->initialice() ){
            $this->readHive();
        }
    }

    function initialice(){
        $hw=systemOppClass::getComputer();
        $osList=$hw->listDisks->partitionsOS();

        $BCDPartitionName=array_search('windows7system', $osList);
        if($BCDPartitionName===false){
            exceptionHandlerClass::saveMessage( "We not found windows system partition" );
            return false;
        }

        $BootPartitionName=array_search('windows7boot', $osList);
        if($BootPartitionName===false){
            exceptionHandlerClass::saveMessage( "We not found windows boot partition" );
            return;
        }

        $BCDDisk=$hw->listDisks->diskOfpartition($BCDPartitionName);
        $this->BCDPartition=$hw->listDisks->disks[$BCDDisk]->partitions[$BCDPartitionName];

        $BootDisk=$hw->listDisks->diskOfpartition($BootPartitionName);
        $this->BootPartition=$hw->listDisks->disks[$BootDisk]->partitions[$BootPartitionName];
        
        return true;

    }

    function readHive(){
        if (!$mountPoint = $this->BCDPartition->fileSystem->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->BCDPartition->fileSystem->mount();
        } else {
            $mountedAlready = true;
        }

        if(!empty($mountPoint) && is_file($mountPoint.'/Boot/BCD') ) {
            $this->registry=new windowsRegistryClass($mountPoint.'/Boot/BCD');
            $this->BCD=$this->registry->getObjectsArray();

            if(count($this->BCD)<=1 ){
                exceptionHandlerClass::saveError("Error reading BCD registry");
                return false;
            }
        }

        if(!$mountedAlready) {
            $this->BCDPartition->fileSystem->umount();
        }

    }

    function getBCDArray( $object ){
        $guids=array();
        $g=array();
        
        foreach ($this->BCD as $key => $value ) {
            if(strpos( $key, $object )){
                $key=str_replace('\\\\', '', trim($key));
                $k='[\''.str_replace('\\','\'][\'',$key).'\']';
                eval( "\$guids$k=\$value;");
               
            }
        }
        return $guids;
    }


    function getGuidType($type=''){
        $guids=array();
        if(isset($this->BCD['objects'])){
            foreach (array_keys($this->BCD['objects']) as $key ) {
                if(empty($type) || $type==$this->BCD['objects'][$key]['description']['type']){
                    $guids[$key]=$this->BCD['objects'][$key]['description']['type'];
                }
            }
        }
        return $guids;
    }

    function getDeviceGuidList(){

    }

    function changeDiskSignature($obj, $type, $newSignature,$partitionStart){
        if (!$mountPoint = $this->BCDPartition->fileSystem->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->BCDPartition->fileSystem->mount();
        } else {
            $mountedAlready = true;
        }

        if(!empty($mountPoint) && is_file($mountPoint.'/Boot/BCD') ) {

            $key='Objects\\'.$obj.'\Elements\\'.$type;
            if(isset ($this->BCD['objects'][$obj]['elements'][$type]['element'])){
                $newVal=explode(',',str_replace('hex:','',$this->BCD['objects'][$obj]['elements'][$type]['element']));
                switch ( count($newVal) ){
                    case 88:
                        $partitionOffset='35';
                        $signatureOffset='59';
                        break;

                    case 254:
                        $partitionOffset='87';
                        $signatureOffset='111';
                        break;
                    default :
                        exceptionHandlerClass::saveMessage( "WRONG VALUE obj:: $obj k2: <pre> ".print_r($newVal,1). "</pre>");
                        return;
                }

                $keyElement=$this->registry->getRealKey( 'Objects\\'.$obj.'\Elements\\'.$type );

                if( strlen($newSignature) % 2 ){
                    $newSignature='0'.$newSignature;
                }
                
                if( strlen($partitionStart) % 2 ){
                    $partitionStart='0'.$partitionStart;
                }

                $newSignature1=str_split($newSignature,2);
                for ($i=0;$i<count($newSignature1);$i++){
                    $newVal[$signatureOffset]=$newSignature1[$i];
                    $signatureOffset--;
                }

                $partitionStart1=str_split($partitionStart,2);
                for ($i=0;$i<count($partitionStart1);$i++){
                    $newVal[$partitionOffset]=$partitionStart1[$i];
                    $partitionOffset--;
                }

                $this->registry->modifyHexKey( $keyElement,'B','Element',implode(',',$newVal));

            }
        }

        if(!$mountedAlready) {
            $this->BCDPartition->fileSystem->umount();
        }

    }

    function makeBootable(){
        $hw=systemOppClass::getComputer();
        

        if(is_null( $this->BCDPartition) || is_null($this->BootPartition)){
            exceptionHandlerClass::saveMessage( "We not found windows system or Boot partition" );
            return;
        }

        $w7sDiskSignature=$hw->listDisks->disks[$this->BCDPartition->disk]->diskSignature;
        $w7sStart=unitsClass::diskSector2SizeHex($this->BCDPartition->startSector);
        

        $w7bDiskSignature=$hw->listDisks->disks[$this->BootPartition->disk]->diskSignature;
        $w7bStart= unitsClass::diskSector2SizeHex($this->BootPartition->startSector);

        //aladtu: 11000001 signatura partizio hasera
        $t10100002=$this->getGuidType('dword:10100002');
        $t10200005=$this->getGuidType('dword:10200005');

        foreach(array_keys($t10100002) as $obj ){
            $this->changeDiskSignature($obj, '11000001',$w7sDiskSignature, $w7sStart);
        }
        foreach(array_keys($t10200005) as $obj ){
            $this->changeDiskSignature($obj, '11000001',$w7sDiskSignature, $w7sStart);
        }

        //aladatu: 11000001 21000001 signatura partizio hasera  kontuz luzera ezberdina
        $t10200003=$this->getGuidType('dword:10200003');
        $t10200004=$this->getGuidType('dword:10200004');

        foreach(array_keys($t10200003) as $obj ){
            $this->changeDiskSignature($obj, '11000001',$w7bDiskSignature, $w7bStart);
            $this->changeDiskSignature($obj, '21000001',$w7bDiskSignature, $w7bStart);
        }
        
        foreach(array_keys($t10200004) as $obj ){
            $this->changeDiskSignature($obj, '11000001',$w7bDiskSignature, $w7bStart);
            $this->changeDiskSignature($obj, '21000001',$w7bDiskSignature, $w7bStart);
        }

        //aldatu:31000003 signatura partizio hasera
        $t30000000=$this->getGuidType('dword:30000000');
        foreach(array_keys($t30000000) as $obj ){
            $this->changeDiskSignature($obj, '11000001',$w7bDiskSignature, $w7bStart);
        }


    }

    function changePartitionSectors(){
        
    }

    

}
?>
