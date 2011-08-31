<?php

//[boot loader]
//timeout=0
//default=multi(0)disk(0)rdisk(0)partition(1)\WINDOWS
//[operating systems]
//multi(0)disk(0)rdisk(0)partition(2)\WINDOWS="Microsoft Windows XP Professional" /noexecute=optin /fastdetect /DETECTHAL

class WinBootIniClass {
    private $winPartition;
    function __construct($winPartition1){
		$this->winPartition=$winPartition1;
		$this->loadFile();

	}


    function loadFile(){
        $mountPoint=$this->mount();
        $iniFile=$mountPoint.'/boot.ini';
        if(is_file($iniFile)){
            $menu=manageIniFilesClass::readIniFile($iniFile);
            //$menu=parse_ini_file($iniFile);
        }else{
            exceptionHandlerClass::saveMessage("parsing boot.ini \n");
        }
//exceptionHandlerClass::saveMessage("WWpname :: ".print_r($this->winPartition)." ");
//        exceptionHandlerClass::saveMessage("\n<br>boot.ini  ::  $mountPoint //<br>\n". print_r($menu['default'],1));
//        exceptionHandlerClass::saveMessage("\n");

        //$menu['default']
        $menu['boot loader']['default']=ereg_replace('partition\([0-9]\)', 'partition('.$this->winPartition->partitionNumber.')', $menu['boot loader']['default']);
        unset($menu['operating systems']);
        $menu['operating systems'][$menu['boot loader']['default']]='"OpenIrudi Windows restauration" /noexecute=optin /fastdetect';

//exceptionHandlerClass::saveMessage("\n<br>22222222222::<br>". print_r($menu['default'],1));
$menu=manageIniFilesClass::writeWinIniFile($iniFile,$menu);

        $this->umount();
    }




    //---------------------WORK FUNCTIONS
	function mount(){


		if( !$mountPoint=$this->winPartition->fileSystem->isMounted()){
			$this->mountedAlready=false;
			$mountPoint=$this->winPartition->fileSystem->mount();
		}else{
			$this->mountedAlready=true;
		}
		echo "<br> mountPoint: $mountPoint ";
		return $mountPoint;

	}
	function umount(){
		if(!$this->mountedAlready){
			$this->winPartition->fileSystem->umount();
		}
	}



}
?>
