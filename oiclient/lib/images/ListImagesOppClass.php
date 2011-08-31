<?php

class ListImagesOppClass {

    private $list = array();
    private $serverUrl = '';
    private $imageSets;

    function __construct() {
        $this->serverUrl = str_replace('$server', ImageServerOppClass::address(), sfConfig::get('app_server_imagesUrl'));
        $this->__get('list');
    }

    function __get($propertyName) {
        try {
            if (property_exists('ListImagesOppClass', $propertyName)) {
                if (!isset($this->$propertyName) || empty($this->$propertyName)) {
                    $this->__set($propertyName, '');
                }
                return $this->$propertyName;
            }
            throw new Exception("Invalid property name \"{$propertyName}\" in ListImagesOppClass");
        } catch (Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function __set($propertyName, $value) {
        try {
            if (!property_exists('ListImagesOppClass', $propertyName)) {
                throw new Exception("Invalid property value \"{$propertyName}\" in ListImagesOppClass");
            }
            if (method_exists($this, 'set_' . $propertyName)) {
                call_user_func(array($this, 'set_' . $propertyName), $value);
            } else {
                throw new Exception("*Invalid property value \"{$propertyName}\" in ListImagesOppClass");
            }
        } catch (Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function set_hostListImages($ipAddress) {

    }

    function set_serverUrl() {
        return $this->serverUrl;
    }

    function set_list() {
        $listArray=ImageServerOppClass::images();
        if( !is_array($listArray) || empty($listArray)){
            $this->list=array();
            return;
        }
        foreach($listArray as $imageParamaters){
            $this->list[$imageParamaters['id']] = new oiImageOppClass($imageParamaters);
        }
    }

    function set_imageSets(){
        $this->__get('list');
        $this->imageSets=ImageServerOppClass::imageSets();

        if(is_array($this->imageSets)){
            foreach ($this->imageSets as $imageSet ) {
                $label='';
                foreach ($imageSet['oiimages'] as $key => $oiimage ) {
                    if($oiimage['os']=='oiSystem'){
                        $label[]= "Openirudi ( {$oiimage['size']}% )";
                        //$this->imageSets[$imageSet['id']]['oiimages'][$key]['image']=
                    }else{
                        $label[]= $this->list[ $oiimage['id'] ]->name ."( {$oiimage['size']}% )";
                        //$this->imageSets[$imageSet['id']]['oiimages'][$key]['image']=$this->list[ $oiimage['id'] ];
                    }
                }
                $this->imageSets[$imageSet['id']]['label']=implode(', ',$label);
            }
        }

    }

    
    function createImage($newImage, $orgPartition, &$listOisystems) {

        $this->__get('list');

        exceptionHandlerClass::saveMessage("STEP 1 select oisystem");

        if( count($listOisystems->oisystems) > 0 ){
            $oiSystem = $listOisystems->bestOiSystem2newImage($orgPartition->fileSystem->used);
            if (!$oiSystemMountPoint = $oiSystem->isMounted()) {
                $mountedAlready = false;
                $oiSystemMountPoint = $oiSystem->mount();
            } else {
                $mountedAlready = true;
            }

        }else{
            exceptionHandlerClass::saveMessage("Create image without oiPartition.");
            $mountedAlready = true;
            $oiSystemMountPoint="-";
        }

        $result=$orgPartition->fileSystem->umount();
        if($result===false){
            exceptionHandlerClass::saveError("Error umounting dest partition.");
            return false;
        }

        $hw=systemOppClass::getComputer();

        $newImage['diskSignature']=$hw->listDisks->disks[$orgPartition->disk]->diskSignature;
        $newImage['diskName']=$orgPartition->disk;

        $newImage['startSector']=$orgPartition->startSector;
        $newImage['endSector']=$orgPartition->endSector;
        $newImage['sectors']=$orgPartition->sectors;

        $newImage['partition_size'] = $orgPartition->sectors;
        $newImage['partition_type'] = $orgPartition->partitionTypeId;

        if($orgPartition->fileSystem->mountable){
            $newImage['filesystem_size'] = $orgPartition->fileSystem->used;
        }else{
            $s=unitsClass::diskSectorSize($orgPartition->sectors,'b');
            $newImage['filesystem_size'] = $s['size'];
            exceptionHandlerClass::saveMessage("filesystem_size::  ". $s['size']."bytes" );
        }
        $newImage['filesystem_type'] = $orgPartition->fileSystem->type;
        $newImage['os'] = $orgPartition->fileSystem->os;
        $newImage['uuid'] = $orgPartition->fileSystem->uuid;

        $newImage['oiSystemPath'] = $oiSystemMountPoint;

        $newImage['serverMountPoint']=ImageServerOppClass::mountServerFolder();

        if($newImage['serverMountPoint']===false){
            exceptionHandlerClass::saveError("ERROR mounting server ");
            return false;
        }

        $result=false;
        if ($newImage['serverMountPoint'] !== false && !is_null($this->list ) ) {

            exceptionHandlerClass::saveMessage("STEP 2 create image");
            
            $id = ImageServerOppClass::createImage($newImage);
            if ($id !== false) {
                $re = false;

                $cmd = str_replace('$source', '/dev/' . $newImage['source'], sfConfig::get('app_oipartition_createImage'));
                $cmd = str_replace('$oiSystemPath', '"' . $newImage['oiSystemPath'] . '/' . sfConfig::get('app_oi_imagesdir') . '"', $cmd);
                $fileName = sfConfig::get('app_oi_imagePrefix') . $id;
                $cmd = str_replace('$imageId', '"' . $fileName . '"', $cmd);
                $cmd = str_replace('$fs-type', $newImage['partition_type'] , $cmd);
                $cmd = str_replace('$serverMountPoint', '"' . $newImage['serverMountPoint'] . '"', $cmd);


                $re = executeClass::executeProc($cmd);
                if ($re===false) {
                    exceptionHandlerClass::saveError("Error creating new image.");
                    $result = ImageServerOppClass::removeImage($id);
                }
                $result=true;
            }else{
                exceptionHandlerClass::saveError("Not create valid image.");
            }
        } else {
            exceptionHandlerClass::saveError("No Image List, is valid openirudi server?");
        }

        if (!$mountedAlready) {
            $re_umount=$oiSystem->umount();
        }else{
            $re_umount=true;
        }

        $re_umountServer=ImageServerOppClass::umountServerFolder();

        if($result==true && $re_umount==true && $re_umountServer== true){
            return true;
        }else{
            return false;
        }
    }

    function imageFileAccess($imageId='') {

        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }
        $imageList = array();

        if (!empty($mountPoint)) {
            $path = $mountPoint . '/' . sfConfig::get('app_oi_imagesdir');
            $name = sfConfig::get('app_oi_imagePrefix');
            $ext = 'fsa';

            $glob = glob($path . '/*');

            foreach ($glob as $fileName) {
                $pattern = "/$name([0-9]+)\.$ext/";
                $n = preg_match($pattern, $fileName, $match);
                if (isset($match[1])) {
                    if (isset($imageList[$match[1]])) {
                        $imageList[$match[1]]+=fileatime($fileName);
                    } else {
                        $imageList[$match[1]] = fileatime($fileName);
                    }
                }
            }
        }

        if (!$mountedAlready) {
            $this->umount();
        }

        if (isset($imageList[$imageId])) {
            return $imageList[$imageId];
        } else {
            asort($imageList, SORT_NUMERIC);
            return $imageList;
        }
    }


    function taskRemovePartitions($taskList){

        $hw=systemOppClass::getComputer(true);
        $listOisystems=  systemOppClass::getListOisystems();

        //umount mounted partitions
        $hw->listDisks->umountAllpartitions();

        $partitions2remove=array();
        $partitions2save=array();
        foreach ($taskList as $task){
            if(isset($task['disk']) && !empty($task['disk'] ) && !empty($task['size']) && empty($task['partition']) ){
                if(is_array($hw->listDisks->disks[$task['disk']]->partitions)){
                    foreach (array_keys($hw->listDisks->disks[$task['disk']]->partitions) as $partition ){
                        if(in_array($partition,$partitions2remove)==false){
                            $partitions2remove[]=$partition;
                        }
                    }
                }
            }
        }

        foreach ($taskList as $task){
            if(isset($task['partition']) && isset($task['disk']) && !empty($task['partition']) && empty($task['disk'] )){
                if(in_array($task['partition'],$partitions2remove)==true){
                    unset($partitions2remove[array_search($task['partition'],$partitions2remove)]);
                    $partitions2save[]=$task['partition'];
                }
            }
        }

        $active= $listOisystems->activeOiSystem();
        if( $active !== false && !is_null($active) ){
            unset($partitions2remove[array_search($active, $partitions2remove)]);
            $partitions2save[]=$active;
        }

        if(count($partitions2save)>0){
            foreach ($partitions2save as $partitionName){
                $disk=$hw->listDisks->diskOfpartition($partitionName);
                if($hw->listDisks->disks[$disk]->partitions[$partitionName]->partitionNumber > 4 ){
                    $ext=$hw->listDisks->disks[$disk]->extendedPartition;
                    unset($partitions2remove[array_search($ext,$partitions2remove)]);
                    $partitions2save[]=$ext;
                }
            }
        }

        //remove OLD partitions
        if(count($partitions2remove)>0 ){
            arsort($partitions2remove);
            foreach ($partitions2remove as $partitionName ){
                $disk=$hw->listDisks->diskOfpartition($partitionName);
                $r=$hw->listDisks->disks[$disk]->removePartition($partitionName);
                if($r==false){
                    exceptionHandlerClass::saveError("Error removeing partition");
                    return false;
                }
            }
        }
        $hw=systemOppClass::getComputer(true);
        return true;
    }

    function taskNewPartitionsSize($taskList){
        $hw=systemOppClass::getComputer();
        $listOiSystems=systemOppClass::getListOisystems();

        foreach ($taskList as $id => $task){
            if( count($listOiSystems->oisystems) > 0 && isset($this->list[$task['oiimages_id']]) && $this->list[$task['oiimages_id']]->os=='oiSystem'  ){
                unset($taskList[$id]);
            }
        }

        foreach ($taskList as $id => $task){
            if(isset($task['disk']) && !empty($task['disk'] ) && !empty($task['size']) && empty($task['partition']) ){
                $free=$hw->listDisks->disks[$task['disk']]->freePrimarySectorsTotal + $hw->listDisks->disks[$task['disk']]->freeLogicSectorsTotal;
                $taskList[$id]['size']=floor($task['size']*$free/100);
            }
        }
        return $taskList;
    }


    function taskDeployImage($taskList){
        $hw=systemOppClass::getComputer();
        $listOisystems=systemOppClass::getListOisystems();

        foreach ($taskList as $id => $task ){
            $hw->listDisks->umountAllpartitions();
            if( isset($task['partition']) && ! empty($task['partition']) ){
                if(empty($task['disk']) ){
                    $task['disk']=$hw->listDisks->diskOfpartition($task['partition']);
                }
                if(!isset($hw->listDisks->disks[$task['disk']]) || !isset($hw->listDisks->disks[$task['disk']]->partitions[$task['partition']]) ){
                    exceptionHandlerClass::saveError("NO FOUND PARTITION<pre>".print_r($task,1)."</pre>");
                    continue;
                }

                $destPartition=$hw->listDisks->disks[$task['disk']]->partitions[$task['partition']];

                $image=$this->list[$task['oiimages_id']];
                $oiSystem=$listOisystems->oiSystem2DeployImage($image);

                
                $ri=$image->deployImage($destPartition, $oiSystem);
                if($ri===false) {
                    exceptionHandlerClass::saveMessage("ERROR in imagedeploy");
                    return false;
                }

            }
        }
        return true;

    }

    
    function taskCreatePartition($taskList){
        foreach ($taskList as $id => $task ){
            $hw=systemOppClass::getComputer(true);

            $hw->listDisks->umountAllpartitions();
            
            if(isset($task['disk']) && isset($task['partition']) && empty($task['partition']) && ! empty($task['disk']) ){

                $hw=systemOppClass::getComputer();
                $disk=$hw->listDisks->disks[$task['disk']];

                if($disk->primaryPartitionsNumber==3 ){
                    //create extended partition
                    $maxHole=  unitsClass::diskSectorSize($disk->maxNewPrimaryPartitionSectors,'B');
                    $r=$newPartition=$disk->addPartitionSize($maxHole['size'],'extended','-');
                    if($r===false){
                        exceptionHandlerClass::saveMessage("Error creating extended partition");
                        exceptionHandlerClass::saveMessage("maxHole:: $maxHole" );
                    }
                    $hw=systemOppClass::getComputer(true);
                    $disk=$hw->listDisks->disks[$task['disk']];
                }

                if($disk->maxNewPrimaryPartitionSectors >= $task['size']){
                    $t='primary';
                }elseif( $disk->hasExtendPartition && $disk->maxNewPrimaryPartitionSectors <= $task['size'] && $disk->maxNewLogicPartitionSectors >= $task['size'] ){
                    $t='logical';
                }elseif($disk->maxNewPrimaryPartitionSectors >= $task['size'] * 0.9   ){
                    $taskList[$id]['size']=$disk->maxNewPrimaryPartitionSectors;
                    $t='primary';
                }elseif( $disk->hasExtendPartition && $disk->maxNewPrimaryPartitionSectors <= $task['size'] * 0.9 && $disk->maxNewLogicPartitionSectors >= $task['size'] * 0.9 ){
                    $taskList[$id]['size']= $disk->maxNewLogicPartitionSectors;
                    $t='logical';
                }else{
                    exceptionHandlerClass::saveError("No enough sectors");
                    exceptionHandlerClass::saveError("need: ".$task['size']." max primary: ".$disk->maxNewPrimaryPartitionSectors. "  max logic: ".$disk->maxNewLogicPartitionSectors);
                    return false;
                }
                $image=$this->list[$task['oiimages_id']];

                if($image->os=='oiSystem'){
                    $oipartition=array('diskName'=>$task['disk'],'size'=>$taskList[$id]['size'],'ptype'=>$t );
                    $listOiSystems=new listOiSystemsOppClass($hw);

                    $r=$listOiSystems->createOiSystem($oipartition);
                    if($r===false){
                        exceptionHandlerClass::saveMessage("Error oisystem creating");
                        return false;
                    }
                    unset($taskList[$id]);

                }else{
                    $newPartition=$disk->addPartitionSize($taskList[$id]['size'],$t,$image->filesystem_type);
                    if($newPartition === false ){
                        exceptionHandlerClass::saveMessage("I can't create partition to image " . $image->name );
                        return false;
                    }
                    $taskList[$id]['partition']=$task['disk'].$newPartition;
                }
            }
        }
        $hw=systemOppClass::getComputer(true);
        return $taskList;
    }

    function taskBoot($taskList){
          foreach ($taskList as $id => $task ){
              $listOiSystems=systemOppClass::getListOisystems();
              if(isset($task['is_boot']) && $task['is_boot']==1 ){
                  $listOiSystems->setConfProperty('boot', '1');
              }else{
                  $listOiSystems->setConfProperty('boot', '0');
              }
              return true;
          }
          return false;
    }


    function deployImageList($taskList){
        

        if(!is_array($taskList)){
            exceptionHandlerClass::saveError("No valid task");
            return false;
        }
        $this->taskRemovePartitions($taskList);

        $hw=systemOppClass::getComputer(true);
        $listOisystems=systemOppClass::getListOisystems(true);
        $active=$listOisystems->activeOiSystem();
        if(!is_null($active)){
            $listOisystems->oisystems[$active]->clientUpdate();
        }

        $taskList2=$this->taskNewPartitionsSize($taskList);
        if($taskList2 === false){
            exceptionHandlerClass::saveError("Error calculating new partitions size");
            return false;
        }

        $taskList3=$this->taskCreatePartition($taskList2);
        if($taskList3 === false){
            exceptionHandlerClass::saveError("Error creating new partitions");
            return false;
        }

        $r=$this->taskDeployImage($taskList3);
        if($r === false){
            exceptionHandlerClass::saveError("Error deploying new partitions");
            return false;
        }

        $this->taskBoot($taskList3);

        return true;
    }

}
?>
