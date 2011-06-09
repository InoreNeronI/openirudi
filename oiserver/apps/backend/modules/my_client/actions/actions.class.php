<?php

/**
 * my_client actions.
 *
 * @package    drivers
 * @subpackage my_client
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
define('HEX2BIN_WS', " \t\n\r");

class my_clientActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        $this->forward('default', 'module');
        

    }

    public function executeUpdateClient(){

        $this->lastVersion=$this->lastVersion();
        $this->myVersion=$this->myVersion();

        if(!isset($this->lastVersion['version']) || !isset($this->lastVersion['url']) ){
            $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__("I can't get last client version"));
            $this->forward('my_client', 'edit');
        }

        if($this->lastVersion['version'] >= $this->myVersion['version'] || true ){
            $isoPath=sfConfig::get('app_const_root_dir')."/".sfConfig::get('app_const_isopath')."/";
            $clientPath=sfConfig::get('app_const_root_dir')."/".sfConfig::get('app_const_clientpath')."/";;

            $cmd = 'sudo ' . sfConfig::get('sf_root_dir') . "/bin/oiserver.sh update  {$this->lastVersion['url']} {$clientPath} {$isoPath}";
            $re = exec($cmd, $output, $result);
            $this->getUser()->setFlash('notice','result::' ."$result");

            if ($result == 1) {
                $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__('update result:'). ' ' . implode('<br>', $output) );
                $this->forward('my_client', 'edit');
            }

            $this->getUser()->setFlash('notice','result:: '."$result");

            $con = Propel::getConnection();
            $sql = "UPDATE my_client SET version='{$this->lastVersion['version']}' ";
            $this->getUser()->setFlash('notice',"sql:: $sql",true);

            $stmt = $con->prepare($sql);
            $stmt->execute();
            $this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('Openirudi client has been updated.'));
        }

        $this->forward('my_client', 'edit');
    }

    public function executeEdit(sfWebRequest $request) {

        $this->lastVersion=$this->lastVersion();
        $this->myVersion=$this->myVersion();
        $this->my_error = $this->create_my_error();
        $this->server_list = $this->get_server_list();
        $this->my_client = $this->load_my_client_array();
        $this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('last version: ').$this->lastVersion['version'].' '.$this->getContext()->getI18N()->__('my version: ').$this->myVersion['version'],false );
    }

    private function get_server_list() {
        $resultDevs = array();
        $re = exec('sudo ' . sfConfig::get('sf_root_dir') . '/bin/oiserver.sh getNetDevices', $output, $result);
        $devs1 = explode('!@@@', implode(' ', $output));
        if ($result == 0 && isset($devs1[1])) {
            $devs = explode(';', $devs1[1]);
            for ($i = 0; $i < count($devs) - 1; $i = $i + 2) {
                //$resultDevs[$devs[$i]]=$devs[$i+1];
                $resultDevs[$devs[$i + 1]] = $devs[$i + 1];
            }
        }
        return $resultDevs;
    }

    private function new_my_client_array() {
        $result = array();
        $fields = sfConfig::get('app_my_client_fields');
        if (count($fields) > 0) {
            $result['id'] = '';
            foreach ($fields as $i => $f) {
                $result[$f] = '';
            }
        }
        return $result;
    }

    private function load_my_client_array() {
        $result = $this->get_my_client();
        if (empty($result)) {
            $result = $this->new_my_client_array();
        }
        return $result;
    }

    public function executeSave(sfWebRequest $request) {

        $my_client = $request->getParameter('my_client');
        //echo print_r($my_client);
        $my_error = $this->validate_my_client($my_client);
        if ($my_error['error']) {
            $this->server_list = $this->get_server_list();
            $this->my_error = $my_error;
            $this->my_client = $my_client;
            $this->setTemplate('edit');
        } else {
            if (!empty($my_client['password'])) {
                $cmd = 'sudo ' . sfConfig::get('sf_root_dir') . "/bin/oiserver.sh changeSshPassword  " . $my_client['password'];
                $re = exec($cmd, $output, $result);
                if ($result == 1) {
                    echo "<br>ERROR: changing ssh password " . implode('<br>', $output);
                    return;
                }
                $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
                $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, sfConfig::get('app_const_pwd'), $my_client['password'], MCRYPT_MODE_ECB, $iv);

                if (!isset($my_client['ip']))
                    $my_client['ip'] = '';
                if (!isset($my_client['netmask']))
                    $my_client['netmask'] = '';
                if (!isset($my_client['gateway']))
                    $my_client['gateway'] = '';
                if (!isset($my_client['dns1']))
                    $my_client['dns1'] = '';
                if (!isset($my_client['dns2']))
                    $my_client['dns2'] = '';

                $md5Pwd=md5($my_client['password']);
                $cmd = 'sudo ' . sfConfig::get('sf_root_dir') . "/bin/oiserver.sh genOpenirudiIso " . sfConfig::get('sf_root_dir') . "/client/rootcd " . sfConfig::get('sf_root_dir') . "/".sfConfig::get('app_const_isopath'). " {$my_client['server']}  {$my_client['user']} {$md5Pwd} {$my_client['type']} {$my_client['ip']} {$my_client['netmask']} {$my_client['gateway']} {$my_client['dns1']} {$my_client['dns2']}";
                $re = exec($cmd, $output, $result);
                if ($result == 1) {
                    echo "<br>ERROR: " . implode('<br>', $output);
                }

                $my_client['password'] = bin2hex($crypttext) . '#@#@#' . bin2hex($iv);
                $this->save_my_client($my_client);
            }
        }
        $this->forward('my_client', 'edit');
    }

    private function create_my_error() {
        $my_error = array();
        $my_error['error'] = 0;
        $my_error['fields'] = array();
        $fields = sfConfig::get('app_my_client_fields');
        if (count($fields) > 0) {
            foreach ($fields as $i => $f) {
                $my_error['fields'][$f] = array();
                $my_error['fields'][$f]['error'] = 0;
                $my_error['fields'][$f]['msg'] = '';
            }
        }

        return $my_error;
    }

    private function validate_my_client($my_client) {

        $my_error = $this->create_my_error();
        $fields = sfConfig::get('app_my_client_fields');

        if ($my_client['type'] == 'dhcp') {
            $fields = array('server', 'type', 'user', 'password');
        }
        if (count($fields) > 0) {
            foreach ($fields as $i => $f) {
                if (empty($my_client[$f]) && $f == 'password' && empty($my_client['id'])) {

                    $my_error['error'] = 1;
                    $my_error['fields'][$f]['error'] = 1;
                    $my_error['fields'][$f]['msg'] = 'Required.';
                } else if (empty($my_client[$f]) && !in_array($f, array('dns2', 'password'))) {

                    $my_error['error'] = 1;
                    $my_error['fields'][$f]['error'] = 1;
                    $my_error['fields'][$f]['msg'] = 'Required.';
                } else if (!in_array($f, array('server', 'type', 'user', 'password'))) {
                    if (!$this->validateIpAddress($my_client[$f])) {
                        if ($f == 'dns2' && !empty($my_client[$f])) {
                            $my_error['error'] = 1;
                            $my_error['fields'][$f]['error'] = 1;
                            $my_error['fields'][$f]['msg'] = 'Invalid.';
                        }
                    }
                }
            }
        }

        return $my_error;
    }

    //function to validate ip address format in php by Roshan Bhattarai(http://roshanbh.com.np)
    private function validateIpAddress($ip_addr) {
        //first of all the format of the ip address is matched
        if (preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/", $ip_addr)) {
            //now all the intger values are separated
            $parts = explode(".", $ip_addr);
            //now we need to check each part can range from 0-255
            foreach ($parts as $ip_parts) {
                if (intval($ip_parts) > 255 || intval($ip_parts) < 0)
                    return false; //if number is not within range of 0-255

            }
            return true;
        }
        else
            return false; //if format of ip address doesn't matches

    }

    private function get_my_client() {
        $my_client = array();
        $con = Propel::getConnection();
        $sql = 'SELECT * FROM my_client WHERE 1';
        $result = $con->prepare($sql);
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $my_client = $row;
            $my_client['password'] = '';
        }
        return $my_client;
    }

    private function save_my_client($my_client) {
        $sql = '';

        $con = Propel::getConnection();
        
        
        if (empty($my_client['id'])) {
            $info = $this->get_query_info($my_client, 'insert');
            $sql = 'INSERT INTO my_client(' . $info['insert_fields'] . ') VALUES(' . $info['values'] . ')';
        } else {
            $info = $this->get_query_info($my_client, 'update');
            $sql = 'UPDATE my_client SET ' . $info['set'] . ' WHERE id=' . $my_client['id'];
        }
        //

        $stmt = $con->prepare($sql);

        $stmt->execute();
    }

    private function get_query_info($my_client_in, $type_query) {
        $info = array();
        $my_client = $my_client_in;
        if (isset($my_client['id'])) {
            unset($my_client['id']);
        }
        if (!empty($my_client)) {
            if ($type_query == 'insert') {
                $keys = array_keys($my_client);
                $values = array_values($my_client);
                $info['insert_fields'] = implode(',', $keys);
                $info['values'] = '"' . implode('","', $values) . '"';
            } else {
                $set_array = array();
                foreach ($my_client as $f => $v) {
                    $bai = 1;
                    if (empty($v) && $f == 'password') {
                        $bai = 0;
                    }
                    if ($bai) {
                        $set_array[] = $f . '="' . $v . '"';
                    }
                }
                $info['set'] = implode(',', $set_array);
            }
        }

        return $info;
    }
    private function lastVersion(){
        $lastVersion=$this->getUser()->getAttribute('lastVersion');
        if(empty($lastVersion)){
            $u=sfConfig::get('app_const_lastClient')."?ramdom=".rand();
            $last1=file_get_contents(sfConfig::get('app_const_lastClient')."?ramdom=".rand() );
            if($last1 === false ){
                $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__("I can't get last client version"));
                return false;
            }
            $last=explode('@@@', $last1);
            if( ! isset ($last[1]) || ! isset ($last[2])){
                $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__("I can't get last client version"));
                return false;
            }
            $newVersion=$last[2];
            $newFile=$last[1];
            $this->getUser()->setFlash('notice', "version== $newVersion file= $newFile");
            $lastVersion=array('version'=>$newVersion,'url'=>$newFile);

            $this->getUser()->setAttribute('lastVersion', $lastVersion);
        }

        return $lastVersion;

    }

    private function myVersion(){
        $con = Propel::getConnection();

        $sql="SELECT version FROM my_client WHERE 1";
        $result = $con->prepare($sql);
        $result->execute();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $oldVersion=$row['version'];
        }
        $myVersion=array('version'=>$oldVersion);
        return $myVersion;
    }

    public function executeDownload_iso(sfWebRequest $request) {
        $path = sfConfig::get('sf_root_dir') . sfConfig::get('app_const_isopath').'/openirudi.iso';
        if (file_exists($path)) {

            header('Cache-Control: public'); // needed for i.e.
            header('Content-Type: application/download');

            header('Content-Disposition: attachment; filename="openirudi.iso"');
            readfile($path);
            exit();
        }
    }

}
