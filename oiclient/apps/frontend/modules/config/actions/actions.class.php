<?php

/**
 * config actions.
 *
 * @package    openirudi
 * @subpackage config
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class configActions extends sfActions {

    public function preExecute() {
        $this->getComputer();
        $this->getListOisystems();
    }

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex($request) {
       

    }

    function executeProba($request){
        exceptionHandlerClass::saveMessage("PROBA");
//       $this->hw->listDisks->disks['sda']->partitions['sda1']->fileSystem->changeHostName();
//       $this->hw->listDisks->disks['sda']->partitions['sda1']->fileSystem->changeIPAddress();
       //$this->hw->listDisks->disks['sda']->partitions['sda1']->fileSystem->changeHostName();
        $this->hw->listDisks->makeBoot();
//$this->hw->listDisks->disks['sda']->partitions['sda1']->fileSystem->postDeploy();

//$this->hw->listDisks->disks['sda']->partitions['sda2']->fileSystem->postDeploy();

       //$aa=ImageServerOppClass::getClientVersion();
       //exceptionHandlerClass::saveMessage("aaaa: <pre>".print_r($aa,1)."</pre>");
       
//       $hw=  systemOppClass::getComputer();
//       $listOisystems= systemOppClass::getListOisystems();
//
//       $this->hw->network->loadServerRegistry($hw->pcID,$listOisystems);
       $this->redirect('config/index');
        
    }

    function executeIsBoot($request) {
        
        $value = $request->getParameter('boot');
        if($value==1){
            exceptionHandlerClass::saveMessage("Boot first partition after seconds");
        }else{
            exceptionHandlerClass::saveMessage("Show boot partitions menu");
        }
        $this->listOisystems->setConfProperty('boot', $value);
        $this->redirect('config/index');
    }

    function executeMKBoot($request) {

        $this->hw->listDisks->makeBoot();
        $r = exceptionHandlerClass::listAlljson();
        echo $r;
        exit;
    }

    public function executeChangeIpAddress($request) {
        $ipAddress = $request->getParameter('ipAddress');

        if (!ereg('^(([0-9]{1,3}\.){3}[0-9]{1,3})', $ipAddress['ip'])) {
            exceptionHandlerClass::saveMessage("ip address is not correct :: {$ipAddress['ip']}");
            return;
        }

        if (!ereg('^(([0-9]{1,3}\.){3}[0-9]{1,3})', $ipAddress['netmask'])) {
            exceptionHandlerClass::saveMessage("netmask address is not correct :: {$ipAddress['netmask']}");
            return;
        }

        if (!empty($gateway) && !ereg('^(([0-9]{1,3}\.){3}[0-9]{1,3})', $ipAddress['gateway'])) {
            exceptionHandlerClass::saveMessage("gateway is not correct :: {$ipAddress['gateway']}");
            return;
        }
        if (!empty($gateway) && !ereg('^(([0-9]{1,3}\.){3}[0-9]{1,3})', $ipAddress['dns_server'])) {
            exceptionHandlerClass::saveMessage("gateway is not correct :: {$ipAddress['dns_server']}");
            return;
        }

        foreach ($this->listOisystems->oisystems as $oisystem) {
            if ($oisystem->isMinilinuxInstalled()) {
                $this->hw->network->changeIpAddress($ipAddress, $oisystem->mount());
                $oisystem->umount();
            }
        }

        if( is_null($this->listOisystems->activeOiSystem())){
            $this->hw->network->changeIpAddress($ipAddress, '/');
        }

        $this->getUser()->getAttributeHolder()->remove('computer');

        ImageServerOppClass::savePcConfig($this->hw->registryArray());
        $this->forward('config','index');
//        $r = exceptionHandlerClass::listAlljson();
//        echo $r;
//        exit;
    }

    function executeServer($request) {

        $address = $request->getParameter('serverAddress');
        $valid=ImageServerOppClass::changeAddress($address);
        if($valid){
            $this->hw->network->loadServerRegistry($this->hw->pcID,$this->listOisystems);
        }else{
            exceptionHandlerClass::saveError("New server address is not valid.");
        }
        $r = exceptionHandlerClass::listAlljson();
        echo $r;
        exit;
    }

    function executeSaveConfig($request) {
        if(ImageServerOppClass::savePcConfig($this->hw->registryArray()) ){
            exceptionHandlerClass::saveMessage("REGISTRY CLIENT IN SERVER");;
        }else{
            exceptionHandlerClass::saveMessage("NO VALID SERVER ADDRESS!!!");
        }
        $r = exceptionHandlerClass::listAlljson();
        echo $r;
        exit;

    }

    function executeHostname($request) {

        $hostName = $request->getParameter('hostname');
        if (!empty($hostName)) {
            $liveCD=true;
            foreach ($this->listOisystems->oisystems as $oisystem) {
                if ($oisystem->isMinilinuxInstalled()) {
                    $true=false;
                    $this->hw->network->changeHostname($hostName, $oisystem->mount());
                }
            }
            if($liveCD){
                $this->hw->network->changeHostname($hostName, '/');
            }
            //exceptionHandlerClass::saveMessage("New name has been registered");
        } else {
            exceptionHandlerClass::saveMessage("NO VALID SERVER ADDRESS!!!");
        }

        ImageServerOppClass::savePcConfig($this->hw->registryArray());
        
        $r = exceptionHandlerClass::listAlljson();
        echo $r;
        exit;
        
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



}
