<?php

define('GRUBMENURESULT', '/tmp/grub.cfg');

class grubMenuClass {

    static function grubPartitionName($partitionName) {
        $n=preg_match('/[a-zA-Z0-9]{2}([a-z]+)([0-9]+)/',$partitionName,$match);
        $l=array('a'=>0,'b'=>1,'c'=>2,'d'=>3,'e'=>4,'f'=>5,'g'=>6,'h'=>7,'i'=>8,'j'=>9,'k'=>10);
        if($n>0) {
            return 'hd'.$l[$match[1]].','.$match[2];
        }else {
            return null;
        }
    }
    
    static function loadMenu ($mountPoint) {
        $grubMenuFile=$mountPoint.'/'.sfConfig::get('app_grub_menufile');
        $cmd = str_replace('$menuFile', $grubMenuFile, sfConfig::get('app_grub_readMenu'));
        $m=executeClass::execute($cmd);

        $f2=preg_grep( '/#/', $m['output'], PREG_GREP_INVERT);
        $f=implode("\n",$f2);

        $entryes=split( 'menuentry', $f);

        $menu=array();
        $menu['global']='';
        foreach ($entryes as $entry) {
           if(preg_match('/"(.+)" \{/',$entry,$menuMatch) && preg_match('/}/',$entry) && preg_match('/set root=\((.+)\)/',$entry,$rootMatch)) {
               $menu[$menuMatch[1]]='menuentry ' .trim($entry);
            }else {
                $menu['global'].=trim($entry);
            }
        }
        return $menu;
    }

    static function deleteRootEntry(&$menu,$root) {
        
        if(isset($menu[$root])) {
            unset($menu[$root]);
        }
        
    }

    static function cleanAllMenu($mountPoint){
        $grubMenuFile=$mountPoint.'/'.sfConfig::get('app_grub_menufile');
        file_put_contents(GRUBMENURESULT, "" );
        $cmd = str_replace('$menuFile', $grubMenuFile, sfConfig::get('app_grub_saveMenu'));
        $cmd = str_replace('$strMenu', GRUBMENURESULT ,$cmd );
        $menuFile = executeClass::execute($cmd);

    }

    static function addEntry($mountPoint, $label, $newOption, $partitionName='' ) {
        $root=self::grubPartitionName($partitionName);
        if(is_null($root)){
            $root=$partitionName;
        }
        $menu=self::loadMenu($mountPoint);
        self::deleteRootEntry($menu,$label);
        $menu=array_merge($menu, array($label=>$newOption));
        self::saveMenu($mountPoint,$menu);
        
    }


    static function saveMenu($mountPoint,$newMenuA) {
        $grubMenuFile=$mountPoint.'/'.sfConfig::get('app_grub_menufile');
        $strMenu='#GRUB 1.97 menu for Openirudi';

        if(isset($newMenuA['global'])){
            $strMenu .= "\n\n".$newMenuA['global']."\n";
            unset($newMenuA['global']);
        }
        
        if(isset($newMenuA[sfConfig::get('app_grub_systemLabel')])){
            $strMenu .= "\n\n".$newMenuA[sfConfig::get('app_grub_systemLabel')]."\n";
            unset($newMenuA[sfConfig::get('app_grub_systemLabel')]);
        }

        foreach ( $newMenuA as $option) {
            if(is_array($option)) {
                $strMenu.=implode("",$option);
            }else {
                $strMenu .= "\n\n".$option."\n";
            }
        }
        $strMenu .= "";

        file_put_contents(GRUBMENURESULT, $strMenu);
        $cmd = str_replace('$menuFile', $grubMenuFile, sfConfig::get('app_grub_saveMenu'));
        $cmd = str_replace('$strMenu', GRUBMENURESULT ,$cmd );
        $menuFile = executeClass::execute($cmd);

    }

    static function nextBoot( $mountPoint,$partitionName ){
        
        //grubsetenv:      'grub-editenv /boot/grub/grubenv set $envVar $value'
        $menu=self::loadMenu($mountPoint);
        unset($menu['global']);
        $grubPartitionName = self::grubPartitionName($partitionName);

        $grubIndex=0;
        foreach($menu as $label => $option){
            if(strpos($option,"set root=($grubPartitionName)")!==false){
                break;
            }
            $grubIndex++;
        }

        $cmd=str_replace('$oiSystemPath', $mountPoint , sfConfig::get('app_grub_nextBoot') );
        $cmd=str_replace('$grubIndex', $grubIndex , $cmd );
        $re=executeClass::execute($cmd);

    }
    
    static function grubInstall( $mountPoint, $oisystemDisk ){

        $cmd=str_replace('$oisystemDisk', $oisystemDisk , sfConfig::get('app_grub_install') );
        $cmd=str_replace('$mountPoint', $mountPoint , $cmd );

        $result=false;
        $re=executeClass::execute($cmd);
        if($re['return']!=0){
            exceptionHandlerClass::saveError('cmd : '. $cmd);
            exceptionHandlerClass::saveError(implode('<br>',$re['output']));
            $result=false;
        }else{
            $result=true;
        }
        return $result;

    }

    static function halt() {
        $cmd = sfConfig::get('app_grub_halt');
        $re = executeClass::execute($cmd);
    }

    static function reboot() {
        $cmd = sfConfig::get('app_grub_reboot');
        $re = executeClass::execute($cmd);
    }

    static function whichGrub( $mountPoint, $oisystemDisk ){

    }
    
    
}
?>
