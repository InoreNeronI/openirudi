<?php

class windows7OppClass  extends windowsOppClass {

    function __construct($disk,$partitionNumber,$partitionName,$partitionTypeId) {
        parent::__construct($disk,$partitionNumber,$partitionName,$partitionTypeId);
        $this->__set('os', 'windows7');
        $this->__set('bootable', true);
    }

    function postDeploy(){

    }

    function makeBootable( ) {
        exceptionHandlerClass::saveMessage("make windows standAlone");
        $this->fixMbr();
    }

    function fixMbr(){
        exceptionHandlerClass::saveMessage("fix Windows MBR");
        $cmd=str_replace('$partition','/dev/'.$this->partitionName,sfConfig::get('app_oipartition_winStandalone'));
        $cmd=str_replace('$type',$this->os,$cmd);

 exceptionHandlerClass::saveMessage("cmd:: $cmd");

        $re=executeClass::execute($cmd);
        exceptionHandlerClass::saveMessage("result:: ". implode('<br>',$re['output']));
        if($re['return']===false ){
            exceptionHandlerClass::saveMessage("An error ocurred fixing windows mbr" );
            return false;
        }else{
            return true;
        }
    }

    function changeHal(){

    }

    function changeKernel(){
        
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

            //$menu['default']
            $menu['boot loader']['default']=ereg_replace('partition\([0-9]\)', 'partition('.$this->partitionNumber.')', $menu['boot loader']['default']);
            unset($menu['operating systems']);
            $menu['operating systems'][$menu['boot loader']['default']]='"OpenIrudi Windows restauration" /noexecute=optin /fastdetect';

            $menu=manageIniFilesClass::writeWinIniFile($iniFile,$menu);

        }

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
