<?php

/**
 * oiclient actions.
 *
 * @package    openirudi
 * @subpackage oiclient
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class oiclientActions extends sfActions {

    public function preExecute() {
        $this->hw = $this->getHw();
        $this->getListOisystems();
    }

    /*
     * zerbitzarari konsulta egin ze imagin dauzkagun
     */

    public function executeQueryServerListOisystems() {
        if (empty($this->listOisystems->imageServer['host'])) {
            exceptionHandlerClass::saveError('You must set OpenIrudi server IP');
            $this->redirect('image/index');
        }
        $this->listOisystems->create_serverOisystems();

        $this->redirect('image/index');
    }

    /*
     * zerbitzaritik imagin bat deskargatu.
     */

    public function executeDownloadImage($request) {
        $RemoteOisystemName = $request->getParameter('oisystem');
        $imageIdKey = $diskName = $request->getParameter('imageIdKey');

        if (empty($this->listOisystems->imageServer['host'])) {
            exceptionHandlerClass::saveError('You must set OpenIrudi server IP');
            $this->redirect('image/index');
        }

        $server = $this->listOisystems->imageServer;
        $a = $this->listOisystems->localOisystems;
        $lOi = array_shift($a);

        $rOi = $this->listOisystems->serverOisystems->oisystems[$RemoteOisystemName];

        $l = ImageClientOppClass::serverDownloadImage($server, $lOi, $rOi, $imageIdKey);
        $this->redirect('image/index');
    }

    /*
     * Lokaletik zerbitzarira imagin bat igo
     */

    public function executeUploadImage($request) {
        $localOisystemName = $request->getParameter('oisystem');
        $imageIdKey = $diskName = $request->getParameter('imageIdKey');

        if (empty($this->listOisystems->imageServer['host'])) {
            exceptionHandlerClass::saveError('You must set OpenIrudi server IP');
            $this->redirect('image/index');
        }
        $server = $this->listOisystems->imageServer;
        $lOi = $this->listOisystems->localOisystems[$localOisystemName];

        $rOi = array_shift($this->listOisystems->serverOisystems->oisystems);
        //$lOi=array_shift($a);
        //exceptionHandlerClass::saveError('rOS: '.print_r($rOi,1));
        // exceptionHandlerClass::saveError('lOi: '.print_r($lOi,1));
        //$rOi=$this->listOisystems->serverOisystems->oisystems[$RemoteOisystemName];



        if (empty($rOi) | !is_object($rOi)) {
            exceptionHandlerClass::saveError('You must connect to server first to upload image');
            $this->redirect('image/index');
        }

        $l = ImageClientOppClass::serverUploadImage($server, $lOi, $rOi, $imageIdKey);
        $this->redirect('image/index');
    }

    /**
     * Obtiene la configuracion hardware del equipo
     */
    private function getHw() {
        return $this->getComputer()->getHw();
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
