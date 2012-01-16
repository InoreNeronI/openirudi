<?php

/**
 * my_login actions.
 *
 * @package    openirudi
 * @subpackage my_login
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class my_loginActions extends sfActions {

    public function preExecute() {
        $this->getComputer();
        $this->getListOisystems();
    }

    public function executeIndex(sfWebRequest $request) {
        //$this->forward('default', 'module');
        $this->listOisystems->sclient=true;
        if ($this->getUser()->getAttribute('login_incorrect')) {
            exceptionHandlerClass::saveError('Login incorrect');
        }
        $this->getUser()->removeCredential('my_edit_all');
        $this->getUser()->setAuthenticated(false);

    }

    public function executeEqual(sfWebRequest $request) {
        if ($this->is_login_ok($request)) {
            $this->getUser()->getAttributeHolder()->remove('login_incorrect');
            if (!$this->getUser()->hasCredential('my_edit_all')) {
                $this->getUser()->addCredential('my_edit_all');
                $this->getUser()->setAuthenticated(true);
            }
            $this->redirect('menu/index');
        } else {
            $this->getUser()->setAttribute('login_incorrect', 1);
            $this->redirect('my_login/index');
        }
    }

    private function is_login_ok($request) {
        if ($request->getParameter('my_login')) {
            $my_login = $request->getParameter('my_login');
            if (isset($my_login['user']) && isset($my_login['password'])) {
                $user_list = $this->get_user_list();
                if (count($user_list) > 0) {
                    foreach ($user_list as $i => $user) {
                        if ($user['user'] == $my_login['user'] && md5(trim($my_login['password'])) == trim($user['password'])) {
                            //if($user['user']==$my_login['user']){
                            return 1;
                        }
                    }
                }
            }
        }
        return 0;
    }

    private function get_user_list() {
        $result = array();
        $handle = @fopen("../lib/common/user_list.txt", "r");

        if ($handle) {
            while (!feof($handle)) {
                $buffer = fgets($handle);
                $my_array = explode(':', $buffer);
                if (count($my_array) > 1) {
                    $user = array();
                    $user['user'] = $my_array[0];
                    $user['password'] = $my_array[1];
                    $result[] = $user;
                }
            }
            fclose($handle);
        }
        return $result;
    }

    public function executeLogin(sfWebRequest $request) {
        
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
