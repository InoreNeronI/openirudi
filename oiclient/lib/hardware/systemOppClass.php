<?php

class systemOppClass {


    static function getComputer($f=false) {
        if($f) {
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('computer');
        }
        if(!sfContext::getInstance()->getUser()->getAttribute('computer', false) || $f ) {
            // Store data in the user session
            sfContext::getInstance()->getUser()->setAttribute('computer', new hardwareDetectOppClass());
        }
        // Obtenemos la configuracion de la sesion de usuario
        $hw= sfContext::getInstance()->getUser()->getAttribute('computer');
        return $hw;
    }


    static  function getListOisystems($f=false) {
        if($f) {
            sfContext::getInstance()->getUser()->getAttributeHolder()->remove('listOiSystem');
        }
        if(!sfContext::getInstance()->getUser()->getAttribute('listOiSystem',false) || $f ) {
            sfContext::getInstance()->getUser()->setAttribute('listOiSystem', new listOiSystemsOppClass());
        }
        $listOiSystems = sfContext::getInstance()->getUser()->getAttribute('listOiSystem');
        return $listOiSystems;
    }


}
?>
