<?php

class networkOppClass {

    private $devices;
    private $ipAddress;
    private $deviceHwInfo;
    private $route;
    private $dns;
    private $hostname;

    function __construct() {
        $this->set_devices();
        $this->set_ipAddress();
        $this->set_deviceHwInfo();
    }

    function __get($propertyName) {
        try {
            if (property_exists('networkOppClass', $propertyName)) {
                if (!isset($this->$propertyName)) {
                    $this->__set($propertyName, '');
                }
                return $this->$propertyName;
            }
            throw new Exception("Invalid property name \"{$propertyName}\"");
        } catch (Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function __set($propertyName, $value) {
        try {
            if (!property_exists('networkOppClass', $propertyName)) {
                throw new Exception("Invalid property value \"{$propertyName}\" in networkOppClass ");
            }
            if (method_exists($this, 'set_' . $propertyName)) {
                call_user_func(array($this, 'set_' . $propertyName), $value);
            } else {
                throw new Exception("*Invalid property value \"{$propertyName}\" in networkOppClass ");
            }
        } catch (Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function set_devices() {
        $net = executeClass::execute(sfConfig::get('app_command_getethdevices'));
        $this->devices = $net['output'];
        $this->set_ipAddress();


    }

    function isDhcp($device) {

        $cmd = sfConfig::get('app_command_isDhcp');
        $r1 = executeClass::execute($cmd);
        if (!empty($r1['output']) && is_array($r1['output'])) {
            if (in_array($device, $r1['output'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function set_ipAddress() {


        $this->ipAddress = array();
        $this->ipAddress['main']['device'] = '';
        $this->ipAddress['main']['ip'] = '';
        $this->ipAddress['main']['net'] = '';
        $this->ipAddress['main']['netmask'] = '';
        $this->ipAddress['main']['dhcp'] = false;

        $cmd_org = sfConfig::get('app_command_getipaddress');

        foreach ($this->devices as $device) {
            $cmd = str_replace('$device', $device, $cmd_org);
            $net = executeClass::execute($cmd);
            $patron = '^ inet addr:(([0-9]{1,3}\.){3}[0-9]{1,3}) Bcast:(([0-9]{1,3}\.){3}[0-9]{1,3}) Mask:(([0-9]{1,3}\.){3}[0-9]{1,3})';

            if (isset($net['output'][0])) {
                if (ereg($patron, $net['output'][0], $addr)) {

                    $z = split(':', $device);
                    if (count($z) == 1) {
                        $this->ipAddress['main']['device'] = $device;
                        $this->ipAddress['main']['ip'] = $addr[1];
                        $this->ipAddress['main']['net'] = $addr[3];
                        $this->ipAddress['main']['netmask'] = $addr[5];
                        $this->ipAddress['main']['dhcp'] = $this->isDhcp($device);
                    } else {
                        $this->ipAddress['alias'][$z[1]]['device'] = $z[0];
                        $this->ipAddress['alias'][$z[1]]['ip'] = $addr[1];
                        $this->ipAddress['alias'][$z[1]]['net'] = $addr[3];
                        $this->ipAddress['alias'][$z[1]]['netmask'] = $addr[5];
                        $this->ipAddress['alias'][$z[1]]['dhcp'] = $this->isDhcp($device);
                    }
                }
            } else {
                $z = split(':', $device);
                if (count($z) == 1) {
                    $this->ipAddress['main']['device'] = $device;
                    $this->ipAddress['main']['ip'] = "";
                    $this->ipAddress['main']['net'] = "";
                    $this->ipAddress['main']['netmask'] = "";
                    $this->ipAddress['main']['dhcp'] = $this->isDhcp($device);
                } else {
                    $this->ipAddress['alias'][$z[1]]['device'] = $z[0];
                    $this->ipAddress['alias'][$z[1]]['ip'] = "";
                    $this->ipAddress['alias'][$z[1]]['net'] = "";
                    $this->ipAddress['alias'][$z[1]]['netmask'] = "";
                    $this->ipAddress['alias'][$z[1]]['dhcp'] = $this->isDhcp($device);
                }
            }
        }
    }

    function set_hostname() {

        $cmd = sfConfig::get('app_command_gethostname');
        $re = executeClass::execute(trim($cmd));

        if ($re['return'] != 0) {
            exceptionHandlerClass::saveError("error: " . $re['return'] . " result: " . print_r($re['output'], 1));
            return;
        }
        foreach ($re['output'] as $row) {
            if (!empty($row)) {
                $this->hostname = trim($row);
            }
        }
    }

    function set_deviceHwInfo() {
        $cmd = sfConfig::get('app_command_getMACaddress');
        $macList = executeClass::execute($cmd);

        foreach ($macList['output'] as $macRow) {
            $ex = explode('HWaddr', $macRow);
            if ($ex === false) {
                exceptionHandlerClass::saveError("No MAC address detect!! ");
            } else {
                $this->deviceHwInfo = str_replace(':', '', trim($ex[1]));
            }
        }
    }

    function set_route() {
        
        $this->route = array();
        $this->route['default']['gateway'] = '';
        $r = executeClass::execute(sfConfig::get('app_command_getgateway'));
        if ($r['return'] == 0) {
            foreach ($r['output'] as $row) {
                $rule = explode(' ', $row);
                if ($rule[0] == '0.0.0.0') {
                    $this->route['default']['gateway'] = $rule[1];
                    $this->route['default']['dev'] = $rule[7];
                } elseif (ereg('^([0-9]{1,3}\.){3}[0-9]{1,3}', $rule[1])) {

                    $this->route[$rule[0]]['dev'] = $rule[7];
                    if (isset($rule[7]) && ereg('^([0-9]{1,3}\.){3}[0-9]{1,3}', $rule[1])) {
                        $this->route[$rule[0]]['gateway'] = $rule[1];
                    }
                }
            }
        } else {
            exceptionHandlerClass::saveError("Error ip route querying");
        }
    }

    function set_dns() {
       
        $this->dns = array();
        $dnsFile = new manageFilesClass(sfConfig::get('app_path_dnsfile'));

        if ($content = $dnsFile->readArrayFile()) {
            foreach ($content as $row) {

                if (ereg('^nameserver (([0-9]{1,3}\.){3}[0-9]{1,3})', $row, $address)) {
                    $this->dns[] = $address[1];
                }
            }
        } else {
            exceptionHandlerClass::saveError("Error ip dns server querying");
        }
    }

    public function changeIpAddress($newIpAddress, $oisystemPath) {
        //    changeip:       'sudo /var/www/openirudi/bin/slitazConfig.sh changeIp $oisystemPath $static $device $ip $netmask $gateway $dns_server]'

        $cmd = sfConfig::get('app_command_changeip');
        $cmd = str_replace('$oisystemPath', $oisystemPath, $cmd);
        if ($newIpAddress['dhcp'] == 'true') {
            $cmd = str_replace('$static', 'dhcp', $cmd);
        } else {
            $cmd = str_replace('$static', 'static', $cmd);
        }

        $cmd = str_replace('$device', $newIpAddress['device'], $cmd);
        $cmd = str_replace('$ip', $newIpAddress['ip'], $cmd);
        $cmd = str_replace('$netmask', $newIpAddress['netmask'], $cmd);
        
        if(! isset($newIpAddress['gateway'])) $newIpAddress['gateway']= '';
        $cmd = str_replace('$gateway', $newIpAddress['gateway'], $cmd);
        
        if(! isset( $newIpAddress['dns_server'])) $newIpAddress['dns_server']='';
        $cmd = str_replace('$dns_server', $newIpAddress['dns_server'], $cmd);

        $r = executeClass::execute($cmd);
        if ($r['return'] != 0) {
            exceptionHandlerClass::saveError("Error in dhclient:\n" . implode("\n", $r['output']));
        }

        $this->set_ipAddress();
    }

    function changeHostname($hostname='', $oiSystemPath='') {

        if (!empty($hostname)) {
            $cmd = sfConfig::get('app_command_sethostname');
            $cmd = str_replace('$newName', $hostname, $cmd);

            if (!empty($oiSystemPath)) {
                $cmd = str_replace('$oiSystemPath', $oiSystemPath, $cmd);
                $re = executeClass::StrExecute(trim($cmd));
                if ($re['return'] != 0) {
                    exceptionHandlerClass::saveError($re['output']);
                    return;
                }
            }
            $cmd = str_replace('$oiSystemPath', '/', $cmd);
            $re = executeClass::StrExecute(trim($cmd));
            if ($re['return'] != 0) {
                exceptionHandlerClass::saveError($re['output']);
                return;
            }
        }
        $this->set_hostname();
    }

    function loadServerRegistry($pcID, $listOisystems) {

        //$listOisystems->changePassword();

        $host = ImageServerOppClass::getPcConfig($this->deviceHwInfo, $pcID);
        $update=false;

        if (!empty($host['name']) && $host['name'] != $this->hostname) {
            
            foreach ($listOisystems->oisystems as $oisystem) {
                if ($oisystem->isMinilinuxInstalled()) {
                    $this->changeHostname($host['name'], $oisystem->mount());
                    $oisystem->umount();
                    $update=true;
                }
            }
            if ( is_null($listOisystems->activeOiSystem())) {
                $this->changeHostname($host['name'], '/');
                $update=true;
            }
        }

        if (!empty($host['ip']) && ( 
                ( $host['ip'] == 'dhcp' &&  $this->ipAddress['main']['dhcp'] != 1 ) ||
                ( $host['ip'] != 'dhcp' &&  $this->ipAddress['main']['dhcp'] == 1 ) ||
                ( $host['ip'] != 'dhcp' &&  $host['ip'] != $this->ipAddress['main']['ip']  ) ||
                ( $host['ip'] != 'dhcp' &&  $host['netmask'] != $this->ipAddress['main']['netmask']  ) ||
                ( $host['ip'] != 'dhcp' &&  $host['dns'] != $this->dns[0] ) ||
                ( $host['ip'] != 'dhcp' &&  $host['gateway'] != $this->route['default']['gateway'] )
                )
                        ){

            if($host['ip']=='dhcp'){
                $newIpAddress=array('device'=>'eth0', 'ip'=>'','netmask'=>'','dhcp'=>'true');
            }else{
                $newIpAddress=array('device'=>'eth0','ip'=>$host['ip'],'netmask'=>$host['netmask'],'gateway'=>$host['gateway'],'dns_server'=>$host['dns'],'dhcp'=>'' );
            }

            foreach ($listOisystems->oisystems as $oisystem) {
                if ($oisystem->isMinilinuxInstalled()) {
                    $this->changeIpAddress($newIpAddress, $oisystem->mount() );
                    $update=true;
                }
            }

            if(is_null($listOisystems->activeOiSystem())){
                $this->changeIpAddress($newIpAddress, '/');
                $update=true;
            }
        }
        if ($update){
            systemOppClass::getComputer(true);
        }
        //$listOisystems->changePassword();

    }

    function maskbits($netmask){
         return strpos(decbin(ip2long($netmask)),'0');
    }
}

?>