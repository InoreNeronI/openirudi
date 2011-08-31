<?php

class oiSystemOppClass extends extOppClass {
    private $version;

    function __construct($disk, $partitionNumber, $partitionName, $partitionTypeId) {
        parent::__construct($disk, $partitionNumber, $partitionName, $partitionTypeId);
        $this->__set('isOIFileSystem', true);
        $this->__set('os', 'oiSystem');
        $this->__set('bootable', true);
    }

    public function isMinilinuxInstalled() {

        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }
        $r = true;
        if (!is_dir($mountPoint . '/' . sfConfig::get('app_oi_imagesdir')) || !is_dir($mountPoint . '/etc')) {
            $r = false;
        }
        if (!$mountedAlready) {
            $this->umount();
        }
        return $r;
    }

    function set_version() {
        $inf=manageIniFilesClass::readIniFile(sfConfig::get('app_path_oiclient'));
        if($inf !== false && isset($inf['version'])){
            $this->version=$inf['version'];
        }else{
            $this->version=0;
        }
    }

    function clientUpdate(){
        $this->__get('version');
        $listOisystems=systemOppClass::getListOisystems();
        
        exceptionHandlerClass::saveMessage( "last client :".$listOisystems->sclient['version'] ."  installed:". $this->version  );

        if(isset($listOisystems->sclient['version']) && $listOisystems->sclient['version'] > $this->version){
            exceptionHandlerClass::saveMessage("Update Openirudi client");
            $r=$this->miniLinuxInstall();
            if($r===false){
                exceptionHandlerClass::saveError("ERROR updating Openirudi client");
            }

        }else{
            exceptionHandlerClass::saveMessage("Last version of Openirudi client is installed");
        }
    }

    public function listSavedImages() {
        $imageList = array();
        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }

        if (!empty($mountPoint)) {
            $path = $mountPoint . '/' . sfConfig::get('app_oi_imagesdir');
            $name = sfConfig::get('app_oi_imagePrefix');
            $ext = 'f[a-z0-9]+';

            $glob = glob($path . '/*');
            foreach ($glob as $fileName) {
                $pattern = "/$name([0-9]+)\.$ext/";
                $n = preg_match($pattern, $fileName, $match);
                if (isset($match[1])) {
                    exceptionHandlerClass::saveMessage("ff AZte: $fileName ");
                    if(!isset($imageList[$match[1]])){
                        $imageList[$match[1]] = filesize($fileName);
                    }else{
                        $imageList[$match[1]] += filesize($fileName);
                    }
                }else{
                    unlink($fileName);
                }
            }
        }

        if (!$mountedAlready) {
            $this->umount();
        }
        return $imageList;
    }

    function removeSize($size) {
        $images = $this->imageFileAccess();
        $imageSizes = $this->imageFileSize();

        $free = 0;
        foreach ($images as $imageId => $atime) {
            if ($size <= $free) {
                return;
            }
            $free += $imageSizes[$imageId];
            $this->removeImageFiles($imageId);
        }
    }

    function removeImageFiles($imageId) {
        if (!is_numeric($imageId)) {
            return;
        }
        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }

        if (!empty($mountPoint)) {
            $path = $mountPoint . '/' . sfConfig::get('app_oi_imagesdir');
            $imageFilePrefix = sfConfig::get('app_oi_imagePrefix');
            $imageFileSufix = 'f*';

            $cmd = str_replace('$oiSystemPath', $path, sfConfig::get('app_oipartition_removeImage'));
            $cmd = str_replace('$imageFilePrefix', $imageFilePrefix, $cmd);
            $cmd = str_replace('$imageId', $imageId, $cmd);
            $re = executeClass::execute($cmd);
        }

        if (!$mountedAlready) {
            $this->umount();
        }
    }

    function imageFileSize($imageId='') {

        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }

        if (!empty($mountPoint)) {
            $imageList = array();
            $path = $mountPoint . '/' . sfConfig::get('app_oi_imagesdir');
            $name = sfConfig::get('app_oi_imagePrefix');
            $ext = 'f[a-z0-9]+';

            $glob = glob($path . '/*');

            foreach ($glob as $fileName) {
                $pattern = "/$name([0-9]+)\.$ext/";
                $n = preg_match($pattern, $fileName, $match);
                if (isset($match[1])) {
                    if (isset($imageList[$match[1]])) {
                        $imageList[$match[1]]+=filesize($fileName);
                    } else {
                        $imageList[$match[1]] = filesize($fileName);
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
            return $imageList;
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
            $ext = 'f[a-z0-9]+';

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

    function miniLinuxInstall() {

       if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }
        $result=false;
        $result=false;
        if ($this->isMounted()) {
            $cmd = str_replace('$partitionName', $this->partitionName, sfConfig::get('app_oisystem_install'));
            $re = executeClass::executeProc($cmd);
            if ($re === false) {
                exceptionHandlerClass::saveMessage("an error ocurred an Openirudi system is not installed");
                $result=false;
            } else {
                $result=true;
            }
        }

        if (!$mountedAlready) {
            $this->umount();
        }

        if($result == true ){
             exceptionHandlerClass::saveMessage("azkena true");
            return true;
        }else{
            return false;
        }


    }

    function  postDeploy() {

    }
    

    function nextBoot($diskName, $partitionName) {
        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }
        if (!empty($mountPoint)) {
            grubMenuClass::nextBoot($mountPoint, $partitionName);
        }

        if (!$mountedAlready) {
            $this->umount();
        }
    }

    function makeBootable() {

        $this->makeGrubMenu();

        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }
        $result=false;

        $result=grubMenuClass::grubInstall($mountPoint, $this->disk);

        if (!$mountedAlready) {
            $this->umount();
        }
        return $result;

    }

    function makeGrubMenu() {

        $this->grubMenuOptionInOiSystem();

        $hw = systemOppClass::getComputer();

        foreach ($hw->listDisks->bootablePartitions() as $partition) {
            if ($partition->partitionName == $this->partitionName){
                continue;
            }

            $grubOption = $partition->fileSystem->grubMenuOptionInOiSystem();
            foreach ($grubOption as $label => $menuOption) {
                $this->addGrubEntry($label, $menuOption, $partition->partitionName);
            }
        }
    }


    function addGrubEntry($label, $menuOption, $partitionName) {

        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }

        grubMenuClass::addEntry($mountPoint, $label, $menuOption, $partitionName);

        if (!$mountedAlready) {
            $this->umount();
        }
    }

    function grubMenuOptionInOiSystem() {
        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }

        $kernel = glob($mountPoint . '/boot/vmlinuz-*');
        $grubPartitionName = grubMenuClass::grubPartitionName($this->partitionName);

        if (count($kernel) == 0) {
            echo "<br>No valid kernel found for Openirudi system. Install Openirudi system.<br>";
        }

        $menuGlobal = '
        load_env GRUB_DEFAULT
        load_env GRUB_TIMEOUT

        set default="${GRUB_DEFAULT}"
        set timeout="${GRUB_TIMEOUT}"
        ';

        $menuOIsystem = '
        menuentry "' . sfConfig::get('app_grub_systemLabel') . '" {
        insmod ext2
        set root=('.$grubPartitionName.')
        linux (' . $grubPartitionName . ')' . str_replace($mountPoint, '', $kernel[0]) . '  rw root=/dev/' . $this->partitionName . ' vga=normal screen=800x600x24 lang=es_ES kmap=es sound=noconf user=root autologin
        set GRUB_DEFAULT=0
        save_env GRUB_DEFAULT
        }
        ';

        $a=grubMenuClass::cleanAllMenu($mountPoint);

        grubMenuClass::addEntry($mountPoint, 'global', $menuGlobal);
        grubMenuClass::addEntry($mountPoint, sfConfig::get('app_grub_systemLabel'), $menuOIsystem, $this->partitionName);

        if (!$mountedAlready) {
            $this->umount();
        }
    }

    function imageServer( $address=""){

        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }

        if(empty($address)){
            $address = sfYamlOI::readKey('imageServer',$mountPoint);
            if (empty($address)) {
                return false;
            }
        }else{
            //setConfProperty: 'sudo /var/www/openirudi/bin/slitazConfig.sh setConfProperty $confFile $property $value'

            $cmd=str_replace('$confFile',$mountPoint.'/'.sfConfig::get('app_path_confile'),sfConfig::get('app_oisystem_setConfProperty'));
            $cmd=str_replace('$property','imageServer',$cmd);
            $cmd=str_replace('$value',$address,$cmd);
            $re=executeClass::execute($cmd);
            if($re===false ){
                exceptionHandlerClass::saveMessage("An error ocurred changing property" );
                exceptionHandlerClass::saveMessage("cmd $cmd");
                return false;
            }
       
        }
        
        if (!$mountedAlready) {
            $this->umount();
        }
        return $address;
        
    }

    function bootAfther( $partitionName="" ){
        $property='bootAfther';
        $file=$mountPoint.'/'.sfConfig::get('app_path_confile');

        if(empty($partitionName)){
             $address = sfYamlOI::readKey($property,$mountPoint);
        }else{
            //setConfProperty: 'sudo /var/www/openirudi/bin/slitazConfig.sh setConfProperty $confFile $property $value'
            $file=$mountPoint.'/'.sfConfig::get('app_path_confile');
            
            $value=$partitionName;

            $re=sfYamlOI::setConfProperty($file, $property, $value);
            return $re;
        }
    }

    public function setConfProperty($property, $value){

        if (!$mountPoint = $this->isMounted()) {
            $mountedAlready = false;
            $mountPoint = $this->mount();
        } else {
            $mountedAlready = true;
        }

        $file=$mountPoint.'/'.sfConfig::get('app_path_confile');

        $cmd=str_replace('$confFile',$file,sfConfig::get('app_oisystem_setConfProperty'));
        $cmd=str_replace('$property',$property,$cmd);
        $cmd=str_replace('$value',$value,$cmd);
        $re=executeClass::execute($cmd);
        if($re===false ){
            exceptionHandlerClass::saveMessage("An error ocurred changing property" );
            exceptionHandlerClass::saveMessage("cmd $cmd");
            return false;
        }
        return true;

        if (!$mountedAlready) {
            $this->umount();
        }
    }

}

?>
