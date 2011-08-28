<?php

/**
 * info actions.
 *
 * @package    openirudi
 * @subpackage info
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
define('_SEPARATOR', '#*#23#*#');

class infoActions extends sfActions {

    public function preExecute() {
        $this->hw = $this->getHw();
        $this->getListOisystems();
    }

    /*
     * Zerbitzaritik imagina deskargatzeko eskaria
     */

    function executeQueryServerDownloadImage($request) {
        $RemoteOisystemName = $request->getParameter('oisystem');
        $imageIdKey = $diskName = $request->getParameter('imageIdKey');

//    exceptionHandlerClass::saveError("download image $RemoteOisystemName $imageIdKey ");
        if (empty($this->listOisystems->imageServer['host'])) {
            exceptionHandlerClass::saveError('You must set OpenIrudi server IP');
            $this->redirect('image/index');
        }

//        if (empty($this->listOisystems->localOisystems)){
//			exceptionHandlerClass::saveError('You must set OpenIrudi partition in you computer');
//			$this->redirect('image/index');
//		}

        $localOisystem = array_shift($this->listOisystems->localOisystems);
        $remoteOisystem = $this->listOisystems->serverOisystems->oisystems[$RemoteOisystemName]->partition;

//exceptionHandlerClass::saveError('localOisystem '. print_r($localOisystem,1) .' <br><br> 222: '.print_r($remoteOisystem,1) );


        $a = ImageServerOppClass::queryServerDownloadImage($this->listOisystems->imageServer, $oisystem1, $imageIdKey);
        if (!empty($a)) {
            $this->listOisystems->create_serverOisystems($a);
        }
        $this->redirect('image/index');
    }

    /*
     * imagin bat zerbitzarira igo
     */

    function executeQueryServerUploadImage($request) {
        $oisystem = $request->getParameter('oisystem');
        $imageIdKey = $diskName = $request->getParameter('imageIdKey');

        exceptionHandlerClass::saveError("upload image $oisystem $imageIdKey ");
        if (empty($this->listOisystems->imageServer['host'])) {
            exceptionHandlerClass::saveError('You must set OpenIrudi server IP');
            $this->redirect('image/index');
        }

        $a = ImageServerOppClass::queryServerUploadImage($this->listOisystems->imageServer, $oisystem, $imageIdKey);
        if (!empty($a)) {
            $this->listOisystems->create_serverOisystems($a);
        }
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
