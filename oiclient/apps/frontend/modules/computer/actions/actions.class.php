<?php

/**
 * computer actions.
 *
 * @package    openirudi
 * @subpackage computer
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class computerActions extends sfActions {


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
        //$a=$this->hw->network;
        $this->listSizeUnits = unitsClass::listSizeUnits();

    }

    /**
     * Executes detail action
     * Show all hardware
     *
     * @param sfRequest $request A request object
     */
    public function executeDetail($request) {
//   	 $computer = $this->getUser()->getAttribute('computer');
//     $this->getComputer();
        //$this->hw = $computer->getHw();
    }

    /**
     * Executes reload action
     * Carga la configuracion actual del hardware
     *
     * @param sfRequest $request A request object
     */
    public function executeReload($request) {
        //Limpiar la sesion del usuario
        $this->getUser()->getAttributeHolder()->remove('isMiniLinuxInstalled');
        $this->getUser()->getAttributeHolder()->remove('computer');
        $this->getUser()->getAttributeHolder()->remove('listOiSystem');
        //$this->getResponse()->setCookie('openirudi', '', time() - 3600, '/');

        $this->getComputer(true);
        $this->getListOisystems(true);
        $this->redirect('computer/index');
    }



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
