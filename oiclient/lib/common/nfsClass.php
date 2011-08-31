<?php

class nfsClass {

// localMountPoint:   '/tmp/oi_$host'
//    exportPath:        '/openirudi/'
//    exportPermissions: '(rw,no_root_squash)'
//    nfsdDaemon:        'sudo /etc/init.d/unfsd'
//    nfsMount:          'sudo mount $host:$exportPath $localMountPoint'


    static function exportDir($exportPaths){

        $exportPath=sfConfig::get('app_nfs_exportPath');
        $exportPermissions=sfConfig::get('app_nfs_exportPermissions');
        $exportFileConf=sfConfig::get('app_nfs_exportFileConf');

        $content='';
        foreach($exportPaths as $row){
          $content.="$row  $exportPermissions\n";

        }

        $f = fopen('/tmp/exports', 'w');
        if (!$f) {
            exceptionHandlerClass::saveMessage("I can't save exports file ");
        } else {
            $bytes = fwrite($f, $content );
            fclose($f);
        }

        $cmd='sudo cp /tmp/exports '.sfConfig::get('app_nfs_exportFileConf');
		$r=executeClass::execute($cmd);
        if($r['return']!=0) exceptionHandlerClass::saveMessage("Error in server configure");
        

        $cmd=sfConfig::get('app_nfs_nfsdDaemon').' restart';
        $r=executeClass::execute($cmd);
        if($r['return']!=0) exceptionHandlerClass::saveMessage("Error starting server");
   
    }

    static function mountRemoteDir($host, $localMountPoint, $remoteSystemMountPoint){
        

        if(!is_dir($localMountPoint)){
            mkdir ($localMountPoint, 0777,true);
        }

        $cmd=sfConfig::get('app_nfs_isnfsmounted');
        $cmd=str_replace('$localMountPoint',$localMountPoint,$cmd);

        $r=executeClass::execute($cmd);
        if($r['return']==0 && !empty($r['output'])){
             exceptionHandlerClass::saveMessage("Server has been already mounted ");
             return true;
        }

        $cmd=sfConfig::get('app_nfs_nfsMount');
        $cmd=str_replace('$host',$host,$cmd);
        $cmd=str_replace('$exportPath',$remoteSystemMountPoint,$cmd);
        $cmd=str_replace('$localMountPoint',$localMountPoint,$cmd);
        $r=executeClass::execute($cmd);
        if($r['return']==0){
            return true;
        }else{
            exceptionHandlerClass::saveMessage("Error mounting server $cmd ");
            return false;
        }
    }

    static function umountRemoteDir($host, $localMountPoint){
        $cmd=sfConfig::get('app_nfs_nfsUmount');
        $cmd=str_replace('$localMountPoint',$localMountPoint,$cmd);
        $r=executeClass::execute($cmd);
        if($r['return']==0){
            return true;
        }else{
            exceptionHandlerClass::saveMessage("Error umounting server");
            return false;
        }
    }

    static function downloadDir($host, $remoteSystemMountPoint, $remoteOiImagePath, $localOisystemImagePath ){
        if(empty($localOisystemImagePath)){
            exceptionHandlerClass::saveMessage("Local image path is empty");
        }
        if(empty($remoteOiImagePath)){
            exceptionHandlerClass::saveMessage("Remote image path is empty");
        }
        
        if(!is_dir($localOisystemImagePath)){
            $tmpDir='/tmp/'.basename($localOisystemImagePath);
            mkdir($tmpDir);
            
            $cmd=sfConfig::get('app_nfs_nfscopy');
            $cmd=str_replace('$sourcePath', "{$tmpDir}" ,$cmd);
            $cmd=str_replace('$destinePath', "{$localOisystemImagePath}" ,$cmd);
            $cmd=str_replace('//', "/" ,$cmd);
            $r=executeClass::execute($cmd);
            if($r['return']!=0){
                exceptionHandlerClass::saveError("!!Error makeing $localOisystemImagePath path ");
            }
            
        }

        $localMountPoint=sfConfig::get('app_nfs_localMountPoint');
        $localMountPoint=str_replace('$host',$host,$localMountPoint);

        if(self::mountRemoteDir($host, $localMountPoint,  $remoteSystemMountPoint)){
            $cmd=sfConfig::get('app_nfs_nfscopy');
            $cmd=str_replace('$sourcePath', "{$localMountPoint}/{$remoteOiImagePath}" ,$cmd);
            $cmd=str_replace('$destinePath', "{$localOisystemImagePath}/" ,$cmd);
            $cmd=str_replace('//', "/" ,$cmd);

            $r=executeClass::execute($cmd);
            if($r['return']==0){
                exceptionHandlerClass::saveMessage("Image has been copyed From server");
            }else{
                 exceptionHandlerClass::saveError("!!Error copying From server: $cmd ");
            }
            self::umountRemoteDir($host, $localMountPoint);
        }

    }


    static function uploadDir($host, $remoteSystemMountPoint, $localImagePath, $remoteOiSystemPath  ){
        $localMountPoint=sfConfig::get('app_nfs_localMountPoint');
        $localMountPoint=str_replace('$host',$host,$localMountPoint);

        if(self::mountRemoteDir($host, $localMountPoint,  $remoteSystemMountPoint)){
            $cmd=sfConfig::get('app_nfs_nfscopy');
            $cmd=str_replace('$sourcePath', "{$localImagePath}" ,$cmd);
            $cmd=str_replace('$destinePath', "{$localMountPoint}/{$remoteOiSystemPath}" ,$cmd);
            $cmd=str_replace('//', "/" ,$cmd);

            $r=executeClass::execute($cmd);
            if($r['return']==0){
                exceptionHandlerClass::saveMessage("Image has been copyed to server");
            }else{
                 exceptionHandlerClass::saveError("!!Error copying From server");
            }
            self::umountRemoteDir($host, $localMountPoint);
        }

    }




}
?>
