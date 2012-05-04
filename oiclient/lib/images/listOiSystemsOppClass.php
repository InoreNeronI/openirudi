<?php
class listOiSystemsOppClass {
    private $oisystems=array();
    //private $hw;
    private $sclient;

    function __construct() {
        $this->set_oisystems();
        //$this->hw=$hw;
    }

    function __get($propertyName) {
        try {
            if (property_exists('listOiSystemsOppClass', $propertyName)) {
                if (!isset($this->$propertyName)) {
                    $this->__set($propertyName, '');
                }
                return $this->$propertyName;
            }
            throw new Exception("Invalid property name \"{$propertyName}\" in listOiSystemsOppClass");

        }catch(Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }
    
    function __set($propertyName, $value) {
        try {
            if (!property_exists('listOiSystemsOppClass', $propertyName)) {
                throw new Exception("Invalid property value \"{$propertyName}\" in listOiSystemsOppClass ");
            }
            if (method_exists($this, 'set_' . $propertyName)) {
                call_user_func(array($this, 'set_' . $propertyName), $value);
            } else {
                throw new Exception("*Invalid property value \"{$propertyName}\" in listOiSystemsOppClass ");
            }
        } catch (Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function set_oisystems() {
        
        $hw=systemOppClass::getComputer();
        $this->oisystems=array();
        if(!isset($this->oisystems) || empty($this->oisystems)) {

            foreach($hw->listDisks->disks as $diskName => $disk) {
                if(is_array($disk->partitions)) {
                    foreach ($disk->partitions as $partition) {

                        if(!is_null($partition->fileSystem)) {
                            if($partition->fileSystem->isOIFileSystem==true) {
                                $this->oisystems[$partition->partitionName]=$partition->fileSystem;
                            }
                        }
                    }
                }
            }
        }
    }

    function set_sclient($reconnect=false){

        if(empty ($this->sclient) || $reconnect==true){
            
            $this->sclient=ImageServerOppClass::getClientVersion();
            if($this->sclient !== false ){
                $cmd = str_replace('$user', $this->sclient['user'], sfConfig::get('app_oisystem_changePwd'));
                $cmd = str_replace('$newPwd',$this->sclient['password'], $cmd);
                $cmd = str_replace('$newMd5', md5($this->sclient['password']), $cmd);
                $re = executeClass::execute($cmd);
                if($re['return']!=0){
                    exceptionHandlerClass::saveMessage("ERROR setting new password");
                    exceptionHandlerClass::saveMessage("cmd== $cmd ");
                    exceptionHandlerClass::saveMessage("re==<pre>".print_r($re,1)."</pre>");
                }
            }
        }
    }

    function activeOiSystem(){
        $this->__get('oisystems');
        $cmd=sfConfig::get('app_oisystem_active');
        $re = executeClass::execute($cmd);
        if($re['return']!=0){
            exceptionHandlerClass::saveMessage("ERROR shearcing active Openirudi partition");
            exceptionHandlerClass::saveMessage("cmd== $cmd ");
            exceptionHandlerClass::saveMessage("re==<pre>".print_r($re,1)."</pre>");
        }
        $out=implode("\n",$re['output']);

        if(strpos($out, '!@@@') ===false ){
            return false;
        }else{
            $p=explode('!@@@',$out);
            if($p[1]=='null' || $p[1]=='nul' ){
                return null;
            }else{
                $ois=array_keys($this->oisystems);
                if(isset($this->oisystems[$p[1]])){
                    return $p[1];
                }else{
                    exceptionHandlerClass::saveError("ERROR searching active oisystem");
                    return null;
                }
            }
        }
        return false;
    }
        
    
    function activeVersion() {
        $inf=manageIniFilesClass::readIniFile(sfConfig::get('app_path_oiclient'));
        if($inf !== false && isset($inf['version'])){
            $version=$inf['version'];
        }else{
            $version=0;
        }
        
        return $version;
    }


    function installOisystem($partitionName){
        $cmd=str_replace('$partitionName',$partitionName,sfConfig::get('app_oisystem_install'));
        $re=executeClass::executeProc($cmd);
        if($re===false ){
            exceptionHandlerClass::saveMessage("An error ocurred an Openirudi system has not been installed" );
            exceptionHandlerClass::saveMessage("cmd $cmd");
            return false;
        }
        exceptionHandlerClass::saveMessage("Openirudi system has been installed" );
        return true;
    }

    function createOiSystem($partition) {

        $hw=systemOppClass::getComputer();

        if(is_array($partition['size']) && isset ($partition['size']['size']) ){
            $partition['sizeSectors']=unitsClass::size2sector($partition['size']);
        }elseif(is_numeric ($partition['size']) ){
            $partition['sizeSectors']=$partition['size'];
        }elseif(strpos($partition['size'],'%') !== false ){
            $partition['size']=str_replace('%', '', $partition['size']);
            $partition['sizeSectors']=floor($partition['size'] * $hw->listDisks->disks[$partition['diskName']]->maxSectors);
        }else{
            exceptionHandlerClass::saveError("ERROR calculating partition size");
            return false;
        }

        if(!isset($partition['ptype'])){
            $partition['ptype']='primary';
        }
        
        if($partition['ptype']=='logical'){
            $partition['startSector']=$hw->listDisks->disks[$partition['diskName']]->newLogicPartitionStartSector( $partition['sizeSectors'] );
        }else{
            $partition['startSector']=$hw->listDisks->disks[$partition['diskName']]->newPrimaryPartitionStartSector( $partition['sizeSectors'] );
        }

        $partition['stopSector']=$partition['startSector']+$partition['sizeSectors']-1;
        if( $partition['stopSector'] > $hw->listDisks->disks[$partition['diskName']]->maxSectors ){
            $partition['stopSector']=$hw->listDisks->disks[$partition['diskName']]->maxSectors;
        }

        $cyls=floor( $partition['stopSector'] / $hw->listDisks->disks[$partition['diskName']]->cylSectors );
        $partition['stopSector']=$cyls* $hw->listDisks->disks[$partition['diskName']]->cylSectors-1;
        if(empty ($partition['stopSector'])){
            exceptionHandlerClass::saveError('Wrong partition size');
            return false;
        }

        $cmd=str_replace('$diskName','/dev/'.$partition['diskName'],sfConfig::get('app_oipartition_createOiPartition'));
        $cmd=str_replace('$startSector',$partition['startSector'],$cmd);
        $cmd=str_replace('$stopSector',$partition['stopSector'],$cmd);
        $cmd=str_replace('$ptype',$partition['ptype'],$cmd);

        
        $re=executeClass::executeProc($cmd);
        if($re===false ){
            exceptionHandlerClass::saveMessage("An error ocurred an Openirudi system has not been installed" );
            exceptionHandlerClass::saveMessage("cmd $cmd");
            return false;
        }

        exceptionHandlerClass::saveMessage("Openirudi system has been installed" );

        $hw=systemOppClass::getComputer(true);
        $lisOiSystems=systemOppClass::getListOisystems(true);
        
        exceptionHandlerClass::saveMessage("Make bootable all partitions");
        $hw->listDisks->makeBoot();

    }


    function miniLinuxInstalledOiSystems() {
        $r=array();
        foreach($this->oisystems as $name => $oisystem) {
            if($oisystem->isMinilinuxInstalled) {
                $r[]=$name;
            }
        }
        return $r;
    }

    function miniLinuxNotInstalledOiSystems() {
        $r=array();
        foreach($this->oisystems as $name => $oisystem) {
            if(!$oisystem->isMinilinuxInstalled) {
                $r[]=$name;
            }
        }
        return $r;
    }

    /*
     * Funtzio honetan Openirudiko partizio guztiak errebisatu eta imagin berri bat non gordeko den aukeratzen da.
     *
    */
    function oiSystem2DeployImage( $image ) {
        $result=$this->searchImage($image);

        if(count($this->oisystems)==0){
            return false;
        }
        if(is_null($result)) {
            $result=$this->bestOiSystem2newImage($image->size);
        }
        exceptionHandlerClass::saveMessage("Image saved on local cache ". $result->partitionName);
        return $result;
        
    }

    /*
     * Openirudiko partizioan imagin bat badagoen begiratu. Baldin badago openirudi Partizioaren path-a pasa
    */
    function searchImage($image) {

        foreach ($this->oisystems as $partitionName => $oiSystem ) {
            $listSavedImages=$oiSystem->listSavedImages();
            if( isset($listSavedImages[$image->id]) ) {
                if ( $oiSystem->free + $listSavedImages[$image->id] >= $image->size  ) {
                    return $oiSystem;
                }else {
                    $oiSystem->removeImageFiles($image->id);
                }
            }
        }
        return null;
    }

    function bestOiSystem2newImage($imageSize) {
        foreach ($this->oisystems as $partitionName => $oiSystem ) {
            $free[$partitionName]=$oiSystem->free;
            $size[$partitionName]=$oiSystem->size;
        }

//ez dago imagina baino tokia badago
        asort($free,SORT_NUMERIC);
        foreach($free as $partitionName => $free) {
            if($free >= $imageSize ) {
                return $this->oisystems[$partitionName];
            }
        }
        asort($size,SORT_NUMERIC);

//ez dago imagina ez dago tokirik
        foreach($size as $partitionName => $size) {
            if($size > $imageSize ) {
                $this->oisystems[$partitionName]->removeSize($imageSize);
                return $this->oisystems[$partitionName];
            }
        }

        exceptionHandlerClass::saveMessage("???????????????");

    }

    function executeBoot($request) {
        $hw=  systemOppClass::getComputer();

        $diskName=$request->getParameter('diskName');
        $partitionName=$request->getParameter('partitionName');

        $this->partition=$hw->listDisks->disks[$diskName]->partitions[$partitionName];

        exceptionHandlerClass::saveError("partition:: ".$partitionName."  disk::".$diskName." -  ");



        foreach($this->listOisystems->localOisystems as $oisystem) {
            //$oisystem->
            $grubObj=new grubMenuClass($oisystem);
            $grubObj->addLinuxEntry( "Openirudi partition", $this->partition );
            break;
        }

        $this->redirect('image/index');
    }


    function imageServer($address=''){
        if(!empty($address)){
            foreach ($this->oisystems as $pname => $oisystem ){
                $address=$oisystem->imageServer($address);
            }
        }

        return $address;
    }

    function setConfProperty($property, $value){

        if(is_null($this->activeOiSystem())){
            sfYamlOI::saveKey($property, $value);
        }
        foreach ($this->oisystems as $pname => $oisystem ){
            $r=$oisystem->setConfProperty($property, $value);
            if($r===false){
                
            }
        }
    }

    function getConfProperty($property){
        $v=sfYamlOI::readKey($property);
        return $v;
    }

    
}
