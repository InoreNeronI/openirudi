<?php

/**
 * oiserver actions.
 *
 * @package    openirudi
 * @subpackage oiserver
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class oiserverActions extends sfActions {

    public function preExecute() {
        $this->hw = $this->getHw();
        $this->getListOisystems();
    }

    /*
     * Zerbitzarian dauzkagun imaginen zerrenda bota
     */

    public function executeServerListOiSystems() {

        echo ImageServerOppClass::queryListOisystems($this->listOisystems);
        exit;
        return sfView :: NONE;
    }

    /*
     * Oisystem partitiziaoaren mountatze puntua emanten du systemId-a ezagututa.
     */

    public function executeServerOiSystemPath($request) {
        $systemId = $request->getParameter('systemId');
        echo ImageServerOppClass::queryOisystemPath($this->listOisystems, $systemId);
        exit;
        return sfView :: NONE;
    }

    /*
     * Imagin baten kokapen zehatza ematen bueltazen dio nabigatzaileari.
     */

    public function executeServerImagePath($request) {
        $systemId = $request->getParameter('systemId');
        $imageId = $request->getParameter('imageId');

        echo ImageServerOppClass::queryImagePath($this->listOisystems, $systemId, $imageId);
        exit;
        return sfView :: NONE;
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
