<?php

/**
 * image actions.
 *
 * @package    openirudi
 * @subpackage image
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */

define('WAIT2DEPLOY',20);
class imageActions extends sfActions {

    public function preExecute() {
        // Obtenemos la configuracion
        $this->getComputer();
        $this->getListOisystems();
        $this->getListImages();
    }


    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex($request) {
   
    }

    public function executeProba(){
        exceptionHandlerClass::saveMessage("aaa");

        //echo "aa:<pre>".print_r($this->hw->listDisks->disks['sda']->partitions['sda2']->fileSystem,1)."</pre>bbbbb";
        $r=$this->hw->listDisks->disks['sda']->partitions['sda2']->fileSystem->changeIPAddress();
        echo "rr: ".var_export($r,1)."</pre>";

        $this->forward('image', 'index');
    }

    
    function executeLoading() {

    }

    function executeProcess() {

        if(is_file('/tmp/process')){
            $txt=file_get_contents('/tmp/process');
            preg_match('/(.+)@@@([a-zA-Z0-9\ \.\_\--\/]+)@@@(.+)/',$txt,$match);
            if(isset($match[2])){
                $cmd=sfConfig::get('app_command_process').' ' .$match[2];
                $r=executeClass::execute($cmd);
                if($r['return']==0){
                    echo "{$match[1]} " .implode('<br>', $r['output']). " {$match[3]}";
                }else{
                    echo "{$match[1]} {$match[3]}";
                }
            }else{
                echo "$txt";
            }
            exit;
        }else{
            echo "...";
        }

        exit;
        
    }

    function executeProcessAllLog(){
        $this->getListOisystems(true);
        $this->getComputer(true);
        
        exceptionHandlerClass::spoolException(false);

        echo '<style> body{
font-family: verdana,arial;
font-size: 12px;
}</style>';
        echo file_get_contents(sfConfig::get('app_command_processAllLog'));
        exceptionHandlerClass::spoolException(true);
        exit;
    }

    function executeRedetect(){
        $this->getListOisystems(true);
        $this->getComputer(true);
    }
    
    function executeReinstallOiSystem2($request) {
        $partition['partitionName']= $request->getParameter('partitionName');
        $partition['time']=time();
        $this->getUser()->setAttribute('newOiSystem', $partition);
        $this->to='http://'.$_SERVER['SERVER_NAME'].'/'.$this->getController()->genUrl('image/reinstallOIsystem3');
        $this->name='Openirudi client reinstall';
        $this->back='config/index';
        $this->setTemplate('processIframe');
        $this->result=false;
        file_put_contents('/tmp/reinstallOi', serialize($partition));
        exceptionHandlerClass::process("...");

        $cmd=sfConfig::get('app_command_backCommand') .' '.'wget -O '.sfConfig::get('app_command_processAllLog').'  '.$this->to;
        executeClass::execute($cmd);


    }

    function executeReinstallOIsystem3() {
        exceptionHandlerClass::spoolException(false);

        exceptionHandlerClass::process('Start...');
        $partition=unserialize(file_get_contents('/tmp/reinstallOi'));
        unlink('/tmp/reinstallOi');

        $result=false;
        if($this->listOisystems->oisystems[$partition['partitionName']]->isOIFileSystem) {
            $result=$this->listOisystems->oisystems[$partition['partitionName']]->miniLinuxInstall();
        }
        $re=$this->hw->listDisks->makeBoot();
        if($result == false || $re==false){
            $this->result=false;
        }else{
            $this->result=true;
        }

        exceptionHandlerClass::process("!EOF!$this->result");
        exceptionHandlerClass::spoolException(true);
        exit;
    }

        
    function executeInstallOIsystem2($request) {
        $partition= $request->getParameter('partition');
        $partition['time']=time();
        
        $this->to='http://'.$_SERVER['SERVER_NAME'].'/'.$this->getController()->genUrl('image/installOIsystem3');
        $this->name='New Openirudi client install';
        $this->back='config/index';
        $this->setTemplate('processIframe');
        $this->result=false;

        file_put_contents('/tmp/installOi', serialize($partition));
        exceptionHandlerClass::process("...");

        $cmd=sfConfig::get('app_command_backCommand') .' '.'wget -O '.sfConfig::get('app_command_processAllLog').'  '.$this->to;

        executeClass::execute($cmd);

    }

    function executeInstallOIsystem3() {

        exceptionHandlerClass::spoolException(false);
        exceptionHandlerClass::process('Start...');
        $partition=unserialize(file_get_contents('/tmp/installOi'));
        //unlink('/tmp/installOi');


        if(!isset($partition['diskName'])) {
            exceptionHandlerClass::saveError("You must select one disk");
            $this->result=false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }

        if(!isset($this->hw->listDisks->disks[$partition['diskName']])) {
            exceptionHandlerClass::saveError("Disk: ".$partition['diskName']." not exists");
            $this->result=false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }

        $partition['sizeSectors']=unitsClass::size2sector($partition['size']);
        if($this->hw->listDisks->disks[$partition['diskName']]->maxNewPrimaryPartitionSectors < $partition['sizeSectors']) {
            exceptionHandlerClass::saveError("Not enought free sectors in disk:".$partition['diskName']);
            $this->result=false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }

        $this->getListOisystems(true);
        $r=$this->listOisystems->createOiSystem($partition);

        if($r===false) {
            exceptionHandlerClass::saveError("OpenIrudi system was not created sucessfully");
            $this->result=false;
        }else{
            $this->result=true;
        }

        exceptionHandlerClass::saveMessage("Make bootable all partitions");
        $hw=$this->getComputer(true);
        $re=$hw->listDisks->makeBoot();


        if($re==true && $this->result==true){
            $this->result=true;
        }else{
            $this->result=false;
        }

        exceptionHandlerClass::process("!EOF!$this->result");
        exceptionHandlerClass::spoolException(true);
        exit;
        return sfView::NONE;

    }

    function executeNewImage1($request) {
        $this->oisystem=$request->getParameter('oisystem');
    }

    function executeNewImage2($request) {
        $newImage=$request->getParameter('new');
        $newImage['time']=time();
        
        $this->to='http://'.$_SERVER['SERVER_NAME'].'/'.$this->getController()->genUrl('image/newImage3');
        $this->name='New image creation';
        $this->back='image/index';
        $this->setTemplate('processIframe');
        $this->result=false;

        file_put_contents('/tmp/newImage', serialize($newImage));
        exceptionHandlerClass::process("...");

        $cmd=sfConfig::get('app_command_backCommand') .' '.'wget -O '.sfConfig::get('app_command_processAllLog').'  '.$this->to;
        executeClass::execute($cmd);
    }

    function executeNewImage3() {
       
        exceptionHandlerClass::spoolException(false);
        
        exceptionHandlerClass::process('Start...');
        $newImage=unserialize(file_get_contents('/tmp/newImage'));
        unlink('/tmp/newImage');

        if(empty($newImage) || !isset($newImage['name']) || !isset($newImage['source']) || !isset($newImage['time'])) {
            exceptionHandlerClass::saveError('No partition selected');
            $this->result==false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }
        $time=time();
        if($newImage['time'] > $time || $newImage['time'] +5 <  $time ) {
            exceptionHandlerClass::saveError('Internal error creating image');
            $this->result==false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }

        $disk=$this->hw->listDisks->diskOfpartition( $newImage['source'] );
        $orgPartition=$this->hw->listDisks->disks[$disk]->partitions[$newImage['source']];

        $this->result=$this->listImages->createImage($newImage,$orgPartition,$this->listOisystems );

        exceptionHandlerClass::process("!EOF!$this->result");
        exceptionHandlerClass::saveMessage('<a name="end">Finish image creation</a>');
        
        exceptionHandlerClass::spoolException(true);
        exit;
        return sfView::NONE;
    }
    



   //-----------------TASK DEPLOY IMAGE--------------------------------------------------------------

    function executeTaskDeploy2() {
        if(ImageServerOppClass::is_validServer()) {
            $taskList=ImageServerOppClass::getTaskToDoNow();
            if(!empty($taskList) ) {
                $taskList['time']=time();
                //$this->getUser()->setAttribute('taskList', $taskList);
                $this->to='http://'.$_SERVER['SERVER_NAME'].'/'.$this->getController()->genUrl('image/taskDeploy3');
                $this->name='Openirudi task deploy';
                $this->back='list_to_work/index';
                $this->setTemplate('processIframe');
                $this->result=false;

                file_put_contents('/tmp/task', serialize($taskList));
                exceptionHandlerClass::process("...");

                $cmd=sfConfig::get('app_command_backCommand') .' '.'wget -O '.sfConfig::get('app_command_processAllLog').'  '.$this->to;
                executeClass::execute($cmd);

                return;
            }
        }

        $this->redirect('list_to_work/index');

    }

    function executeTaskDeploy3($request) {
        exceptionHandlerClass::spoolException(false);

        exceptionHandlerClass::process('Start...');
        $taskList=unserialize(file_get_contents('/tmp/task'));
        unlink('/tmp/task');

        $time=time();
        if($taskList['time'] > $time || $taskList['time'] + WAIT2DEPLOY <  $time ) {
            exceptionHandlerClass::saveError('Internal error selecting image');
            $this->result=false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }

        if($taskList[0]['associate'] == 1){
            $nextBoot='reboot';
        }else{
            $nextBoot='halt';
        }
        
        //$deployResult=$this->listImages->deployImageList($taskList );
        $deployResult=true;
        
        if($deployResult===false){
            $nextBoot='stop';
        }

        $this->getComputer(true);
        if( count($this->hw->listDisks->partitionsOS(false))>0 && sfYamlOI::readKey('boot')==1){
            $nextBoot='reboot';
        }

        $re=$this->hw->listDisks->makeBoot();
        if($deployResult===true && $re==true ){
            $this->result=true;
        }else{
            $this->result=false;
            $nextBoot='stop';
        }

        exceptionHandlerClass::process("!EOF!$this->result");
        exceptionHandlerClass::saveMessage('<a name="end">Finish image set deploy</a>');
        exceptionHandlerClass::saveMessage("next: $nextBoot");


        //exceptionHandlerClass::spoolException(true);
   exceptionHandlerClass::saveMessage( "---------11-----------------" );
        
        switch ($nextBoot){
            case 'halt':
                $this->redirect('list_to_work/halt');
exceptionHandlerClass::saveMessage( "------------------- " );
                exit;
            case 'reboot':
                $osList=array_keys($this->hw->listDisks->partitionsOS(false));
                $partitionName=array_shift($osList);
                $disk=$this->hw->listDisks->diskOfpartition($partitionName);
echo "NORA:: url_for('image/nextboot?partitionName=' . $partitionName . '&diskName=' . $disk)" ;
exceptionHandlerClass::saveMessage("NORA:: url_for('image/nextboot?partitionName=' . $partitionName . '&diskName=' . $disk)");
 url_for('article/read?title=Finance_in_France', true)
                $this->redirect(url_for('image/nextboot?partitionName=' . $partitionName . '&diskName=' . $disk));
                exceptionHandlerClass::spoolException(true);
                exit;
            default:
exceptionHandlerClass::saveMessage( "NORA:: default " );
                exceptionHandlerClass::spoolException(true);
                exit;
                return sfView::NONE;
        }

    }

    //-----------------DEPLOY IMAGE SET--------------------------------------------------------------


    function executeDeployImageSet1($request) {
        $this->id=$request->getParameter('id');
        $this->imageSet=$this->listImages->imageSets[$this->id];
        //$taskList=ImageServerOppClass::getTaskToDoNow();

    }

    function executeDeployImageSet2($request) {
        $this->deploy = $request->getParameter('deploy');
        $this->deploy['time']=time();

        $this->to='http://'.$_SERVER['SERVER_NAME'].'/'.$this->getController()->genUrl('image/deployImageSet3');
        $this->name='Openirudi imageSet deploy';
        $this->back='image/index';
        $this->setTemplate('processIframe');
        $this->result=false;

        file_put_contents('/tmp/imageSet', serialize( $this->deploy));
        exceptionHandlerClass::process("...");

        $cmd=sfConfig::get('app_command_backCommand') .' '.'wget -O '.sfConfig::get('app_command_processAllLog').'  '.$this->to;
        executeClass::execute($cmd);

    }

    function executeDeployImageSet3($request) {
        exceptionHandlerClass::spoolException(false);

        exceptionHandlerClass::process('Start...');
        $deploy=unserialize(file_get_contents('/tmp/imageSet'));
        unlink('/tmp/imageSet');

        $time=time();
        if($deploy['time'] > $time || $deploy['time'] + WAIT2DEPLOY <  $time ) {
            exceptionHandlerClass::saveError('Internal error selecting image');
            $this->result=false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }

        if(!isset($deploy['diskName']) || empty($deploy['diskName']) ){
            exceptionHandlerClass::saveError('No disk selected');
            $this->result=false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }

        foreach($this->listImages->imageSets[$deploy['id']]['oiimages']  as $id => $oiimage){
            $taskList[$id]['oiimages_id']=$oiimage['id'];
            $taskList[$id]['disk']=$deploy['diskName'];
            $taskList[$id]['partition']='';
            $taskList[$id]['size']=$oiimage['size'];
            $taskList[$id]['position']=$oiimage['position'];
        }

        $deployResult=$this->listImages->deployImageList($taskList );

        $this->getComputer(true);

        if($deployResult===false){
            exceptionHandlerClass::saveError('ERROR deploying image list');
        }
        
        $re=$this->hw->listDisks->makeBoot();
        if($re==false){
            exceptionHandlerClass::saveError('ERROR makeing botable MBR');
        }

        if($deployResult==false || $re==false){
            $this->result=false;
        }else{
            $this->result=true;
        }
        
        exceptionHandlerClass::process("!EOF!$this->result");
        exceptionHandlerClass::saveMessage('<a name="end">Finish image set deploy</a>');
        exceptionHandlerClass::spoolException(true);
        exit;
        return sfView::NONE;
    }

    

    //-----------------DEPLOY IMAGE--------------------------------------------------------------
    function executeDeployImage1($request) {
        $this->id=$request->getParameter('id');
        $this->image=$this->listImages->list[$this->id];
    }

    function executeDeployImage2($request) {
        $this->deploy = $request->getParameter('deploy');
        $this->deploy['time']=time();

        //$this->getUser()->setAttribute('deploy', $this->deploy);

        $this->to='http://'.$_SERVER['SERVER_NAME'].'/'.$this->getController()->genUrl('image/deployImage3');
        $this->name='Image deploy';
        $this->back='image/index';
        $this->setTemplate('processIframe');
        $this->result=false;

        file_put_contents('/tmp/deploy', serialize($this->deploy));
        exceptionHandlerClass::process("...");
        $cmd=sfConfig::get('app_command_backCommand') .' '.'wget -O '.sfConfig::get('app_command_processAllLog').'  '.$this->to;
        executeClass::execute($cmd);
    }

    function executeDeployImage3($request) {
        exceptionHandlerClass::process('Start...');
        $deploy=unserialize(file_get_contents('/tmp/deploy'));

        exceptionHandlerClass::process("......");

        unlink('/tmp/deploy');
        $this->result=false;

        exceptionHandlerClass::spoolException(false);
        
        if(empty($deploy) || !isset($deploy['id']) || !isset($deploy['partitionName']) || empty($deploy['partitionName']) || !isset($deploy['time'])) {
            exceptionHandlerClass::saveError('No image or partition selected');
            $this->result=false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }
        $time=time();

        $time=time();
        if($deploy['time'] > $time || $deploy['time'] + WAIT2DEPLOY <  $time ) {
            exceptionHandlerClass::saveError('Internal error selecting image');
            $this->result=false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }

        $image=$this->listImages->list[$deploy['id']];
        if(!is_object($image)) {
            exceptionHandlerClass::saveError('No valid image  selected');
            $this->result=false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }

        //createPartition disk size type
        $new=false;
        exceptionHandlerClass::saveMessage("Prepare partition ");
        exceptionHandlerClass::process('Prepare partition...');

        if (strpos($deploy['partitionName'],'new_primary_') !== false) {
            $candidate['diskName']=trim(str_replace('new_primary_','',$deploy['partitionName']));
            $candidate['type']='primary';
            $diskFreeSectors=$this->hw->listDisks->disks[$candidate['diskName']]->maxNewPrimaryPartitionSectors;
            $new=true;
        }elseif(strpos($deploy['partitionName'],'new_logic_') !== false){
            $candidate['diskName']=trim(str_replace('new_logic_','',$deploy['partitionName']));
            $candidate['type']='logical';
            $diskFreeSectors=$this->hw->listDisks->disks[$candidate['diskName']]->maxNewLogicPartitionSectors;
            $new=true;
        }else{
            $diskFreeSectors=0;
        }

        if($new){
            //$candidate['diskName']=trim(str_replace('new_primary_','',$deploy['partitionName']));
            $sectorBytes=$this->hw->listDisks->disks[$candidate['diskName']]->sectorBytes;
            
            $imagePartitionSectors=$image->partition_size;
            $fsSectors=unitsClass::size2sector(array('size'=>$image->filesystem_size,'unit'=>'B'));
            $fs_opts=explode(',',sfConfig::get('app_oipartition_fsImageCreateType'));
            $candidate['fs']=$image->filesystem_type;

            if( $fsSectors > $diskFreeSectors ){
                exceptionHandlerClass::saveError('Disk has not enought space');
                $this->result=false;
                exceptionHandlerClass::process("!EOF!$this->result");
                exceptionHandlerClass::spoolException(true);
                exit;
            }elseif( $imagePartitionSectors  >=  $diskFreeSectors ) {
                 $candidate['size']=$diskFreeSectors-1;
            }elseif( $imagePartitionSectors  <  $diskFreeSectors  ){
                 $candidate['size']=$imagePartitionSectors;
            }else{
                exceptionHandlerClass::saveError("I can't calculate partitition size");
                $this->result=false;
                exceptionHandlerClass::process("!EOF!$this->result");
                exceptionHandlerClass::spoolException(true);
                exit;
            }
            
            exceptionHandlerClass::saveMessage('Adding new partition to disk::');
            $newPartition=$this->hw->listDisks->disks[$candidate['diskName']]->addPartitionSize($candidate['size'],$candidate['type'],$candidate['fs']);
            $this->getComputer(true);

            $deploy['partitionName']=$candidate['diskName'].$newPartition;

        }


        $diskName=$this->hw->listDisks->diskOfpartition( $deploy['partitionName'] );
        if (!isset($this->hw->listDisks->disks[$diskName]->partitions[$deploy['partitionName']])) {
            exceptionHandlerClass::saveError("Can't find this partition");
            $this->deploy_result=false;
            $this->result=false;
            exceptionHandlerClass::process("!EOF!$this->result");
            exceptionHandlerClass::spoolException(true);
            exit;
        }
        $this->partition=$this->hw->listDisks->disks[$diskName]->partitions[$deploy['partitionName']];
        if($this->partition->set_partitionTypeId($image->partition_type)) {
            $this->getComputer(true);
        }

        $oiSystem=$this->listOisystems->oiSystem2DeployImage($image);

        $active=$this->listOisystems->activeOiSystem();
        if(!is_null($active)){
            $this->listOisystems->oisystems[$active]->clientUpdate();
        }
        if($oiSystem===false){
            $dep=$image->deployImage($this->partition);
        }else{
            $dep=$image->deployImage($this->partition, $oiSystem );
        }

        if($dep === false ){
            exceptionHandlerClass::saveError("ERROR in deploy <pre>".print_r($dep,1)."</pre>");
        }

        exceptionHandlerClass::saveMessage("Make filesystem bootable");
        
        $hw=$this->getComputer(true);
        $re=$hw->listDisks->makeBoot();
        
        if($re==false){
            exceptionHandlerClass::saveError('ERROR making botable MBR');
        }

        if($dep===false || $re== false ){
            $this->result=false;
        }else{
            $this->result=true;
        }

        exceptionHandlerClass::process("!EOF!$this->result");
        
        exceptionHandlerClass::saveMessage('<a name="end">Finish image deploy</a>');       
        exceptionHandlerClass::spoolException(true);
        exit;
        return sfView::NONE;
    }


    function executeCopyDrivers($request) {

        foreach($this->hw->listDisks->disks as $diskName => $disk){
            foreach($disk->partitions as $partitionName => $partition){
                if( $partition->fstype=='windows' ){
                   $partition->fileSystem->getWinDriver($this->hw);
                }
            }
        }
        $this->redirect('image/index');
    }


    function executeMKBoot($request) {

        $this->hw->listDisks->makeBoot();
        
        $this->redirect('image/index');

    }

    function executeNextboot($request) {
        $diskName=$request->getParameter('diskName');
        $partitionName=$request->getParameter('partitionName');
        if(count($this->listOisystems->oisystems)==0){
            exceptionHandlerClass::saveError("Reboot without oisystem");
            grubMenuClass::reboot();
        }

        foreach($this->listOisystems->oisystems as $oisystem ) {
            if($oisystem->isMinilinuxInstalled()) {
                  $oisystem->nextBoot($diskName, $partitionName);
            }else{
                exceptionHandlerClass::saveError("We need Openirudi system and is not installed");
            }
        }
        $this->redirect('my_login/index');
    }


    /**
     * Obtiene el ordenador
     */
    private function getComputer($f=false) {
        $this->hw=systemOppClass::getComputer($f);
        return $this->hw;
    }

    private function getListOisystems($f=false) {
        $this->listOisystems=systemOppClass::getListOisystems($f);
        return $this->listOisystems;
    }

    private function getListImages() {
        $this->listImages = new ListImagesOppClass();
    }

}
