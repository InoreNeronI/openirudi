<?php

/**
 * partition actions.
 *
 * @package    openirudi
 * @subpackage partition
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class partitionActions extends sfActions {

    public function preExecute() {
        // Obtenemos la configuracion
        $this->getComputer();
        $this->listOisystems = $this->getListOisystems();
    }

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex($request) {
        // Obtenemos la configuracion
        $this->partitionModule = true;
        $this->partitionTypes = $this->getUser()->getAttribute('partitionTypes');
        $this->listSizeUnits = unitsClass::listSizeUnits();
    }

    /**
     * Executes change action
     * Muestra el formulario para modificar la particion
     *
     * @param sfRequest $request A request object
     */
    public function executeChange($request) {
        $this->partitionModule = true;
        $this->partitionName = $request->getParameter('id');
        $this->listSizeUnits = unitsClass::listSizeUnits();
        $this->partitionTypes = $this->getUser()->getAttribute('partitionTypes');
        
        //$this->redirect('partition/index');
//        $r = exceptionHandlerClass::listAlljson();
//
//        echo $r;
//        exit;
    }

    /**
     * Executes save action
     * Guarda los datos de la particion
     *
     * @param sfRequest $request A request object
     */
    public function executeSave($request) {


        $partition['partitionName'] = $request->getParameter('partitionName');
        $partition['diskName'] = $request->getParameter('diskName');
        $partition['sizeB'] = $request->getParameter('sizeB');
        $partition['unit'] = $request->getParameter('unit');
        $partition['id'] = $request->getParameter('id');

        $result = $this->hw->listDisks->disks[$partition['diskName']]->savePartition($partition);
        $this->getComputer(true);
        $this->getListOisystems(true);

        $r = exceptionHandlerClass::listAlljson();
        echo $r;
        exit;
    }

    /**
     * Executes remove action
     * Elimina la particion
     *
     * @param sfRequest $request A request object
     */
    public function executeRemove($request) {
        $partitionName = $request->getParameter('partitionName');
        $diskName = $this->hw->listDisks->diskOfpartition($partitionName);

        $this->hw->listDisks->disks[$diskName]->removePartition($partitionName);
        $this->getComputer(true);
        $this->getListOisystems(true);
        $r = exceptionHandlerClass::listAlljson();
        echo $r;
        exit;
    }

    /**
     * Executes add action
     * Añade una nueva particion
     *
     * @param sfRequest $request A request object
     */
    public function executeAdd($request) {
        $this->getComputer(true);

        $candidate['diskName'] = $request->getParameter('diskName');
        $candidate['type'] = $request->getParameter('type');
        $candidate['fs'] = $request->getParameter('fs');
        $candidate['boot'] = $request->getParameter('boot');
        $candidate['size']['size'] = $request->getParameter('size');
        $candidate['size']['unit'] = $request->getParameter('unit');

        //partition[diskName] partition[type] partition[fs] partition[boot] partition[size] partition[unit]
        $fs_opts = explode(',', sfConfig::get('app_oipartition_fsImageCreateType'));

        if ($candidate['type'] == 'extended') {
            unset($candidate['fs']);
        }elseif (!isset($fs_opts[$candidate['fs']])) {
            exceptionHandlerClass::saveError("No valid format selected");
        }else{
            $candidate['fs'] = $fs_opts[$candidate['fs']];
        }

        if ($candidate['type'] == 'oisystem') {
            $this->listOisystems->createOiSystem($candidate);
        } else {
            $this->hw->listDisks->disks[$candidate['diskName']]->addPartition($candidate);
        }

        $this->getComputer(true);
        $this->getListOisystems(true);

        $r = exceptionHandlerClass::listAlljson();
        echo $r;
        exit;
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
