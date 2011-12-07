<?php

/**
 * list_to_work actions.
 *
 * @package    openirudi
 * @subpackage list_to_work
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class list_to_workActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function preExecute() {
        $this->getComputer(true);
        $this->getListOisystems(true);
    }

    public function executeLoading(){
        $this->getUser()->addCredential('my_edit_all');
        $this->getUser()->setAuthenticated(true);

    }
    
    public function executeIndex(sfWebRequest $request) {
        
        
        if (ImageServerOppClass::is_validServer()) {
            $this->hw->network->loadServerRegistry($this->hw->pcID,$this->listOisystems);
            $taskList = ImageServerOppClass::getTaskToDoNow();
            if (!empty($taskList)) {
                $this->getUser()->addCredential('my_edit_all');
                $this->getUser()->setAuthenticated(true);
                $this->redirect('image/taskDeploy2');
            }
        }
        if (count($this->listOisystems->oisystems) == 0) {
            $this->redirect('my_login/index');
        }
    }

    function executeNextboot($request){
        $this->getUser()->addCredential('my_edit_all');
        $this->getUser()->setAuthenticated(true);
        $diskName=$request->getParameter('diskName');
        $partitionName=$request->getParameter('partitionName');
        
        $this->redirect('image/nextboot?partitionName=' . $partitionName . '&diskName=' . $diskName);

    }
    function executeAfter(){

        $this->getUser()->addCredential('my_edit_all');
        $this->getUser()->setAuthenticated(true);

        $osList=array_keys($this->hw->listDisks->partitionsOS(false));
        $partitionName=array_shift($osList);
        $disk=$this->hw->listDisks->diskOfpartition($partitionName);

        $this->redirect('image/nextboot?partitionName=' . $partitionName . '&diskName=' . $disk);
                
    }
    function executeReboot() {
        $this->getUser()->addCredential('my_edit_all');
        $this->getUser()->setAuthenticated(true);
        grubMenuClass::reboot();
        exit;
        $this->redirect('list_to_work/index');
    }

    function executeHalt() {
        $this->getUser()->addCredential('my_edit_all');
        $this->getUser()->setAuthenticated(true);
        grubMenuClass::halt();
        exit;
        $this->redirect('list_to_work/index');
    }

    /**
     * Obtiene el ordenador
     */
    private function getComputer($f=false) {
        $this->hw = systemOppClass::getComputer($f);
        return $this->hw;
    }

    private function getListOisystems($f=false) {
        $this->listOisystems = systemOppClass::getListOisystems($f);
        return $this->listOisystems;
    }

}
