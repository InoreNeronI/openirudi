<?php

class Vendor extends BaseVendor {

    static $pci_ids_array;
    static $usb_ids_array;

    /**
     *   Lectura y tratamiento del nuevo fichero pci.txt:
     */
    static function readPciIds() {
        $t1 = time();
        $first_time = false;
        $ids_path = sfConfig::get('app_const_root_dir').'/data/vids/';
        $ids_file = $ids_path.'pci.txt';
        $ids_old_file = $ids_path.'pci.old';
        $type_id = TypePeer::getTypeId('PCI');
        if (!is_file($ids_file))    $first_time = true;
        else    rename($ids_file, $ids_old_file);
        if (!is_file($ids_old_file))    touch($ids_old_file);
        self::readyPciIds(executeClass::ArrExecute(sfConfig::get('app_command_wget1.pci.ids')));
        self::readyIds(executeClass::ArrExecute(sfConfig::get('app_command_wget2.pci.ids')), 'pci');
        self::createNewIdsFile(self::$pci_ids_array, $ids_file);
        $diff = executeClass::ArrExecute(sfConfig::get('app_command_diff.pci.ids'));
        if ($first_time)    unlink($ids_file);
        return VendorPeer::updateIds($diff, $ids_file, $type_id, $t1);
    }

    /**
     *   Lectura y tratamiento del nuevo fichero usb.txt:
     */
    static function readUsbIds() {
        $t1 = time();
        $first_time = false;
        $ids_path = sfConfig::get('app_const_root_dir').'/data/vids/';
        $ids_file = $ids_path.'usb.txt';
        $ids_old_file = $ids_path.'usb.old';
        $type_id = TypePeer::getTypeId('USB');
        if (!is_file($ids_file))    $first_time = true;
        else    rename($ids_file, $ids_old_file);
        if (!is_file($ids_old_file))    touch($ids_old_file);
        self::readyIds(executeClass::ArrExecute(sfConfig::get('app_command_wget.usb.ids')), 'usb');
        self::createNewIdsFile(self::$usb_ids_array, $ids_file);
        $diff = executeClass::ArrExecute(sfConfig::get('app_command_diff.usb.ids'));
        if ($first_time)    unlink($ids_file);
        return VendorPeer::updateIds($diff, $ids_file, $type_id, $t1);
    }

    /**
     *   Llenar los arrays globales con los datos consultados de las diferentes urls:
     */
    static function readyPciIds($ids) {
        foreach ($ids as $id) {
            $id = str_replace("\n", '', $id);
            if ((strlen(trim($id)) != 0) && (substr(trim($id), 0, 1) != ';')) {
                if (substr($id, 0, 1) != "\t")  {   //Vendor
                    $V_id = strtolower(substr($id, 0, 4));
                    $V_name = substr($id, 5, strlen($id) - 5);
                    self::$pci_ids_array[$V_id] = array('name' => $V_name);
                }
                elseif (substr($id, 0, 1) == "\t")  {   //Device
                    $D_id = strtolower(substr($id, 1, 4));
                    $D_name = trim(substr($id, 6, strlen($id) - 6));
                    self::$pci_ids_array[$V_id][$D_id] = array('name' => $D_name);
                }
            }
        }
    }

    static function readyIds($ids, $type) {
        foreach ($ids as $id) {
            $id = str_replace("\n", '', $id);
            if (stripos($id, '# List of known device classes') !== false) break;
            elseif ((strlen($id) != 0) && (substr($id, 0, 1) != '#')) {
                if (substr($id, 0, 1) != "\t")  {  // Vendor
                    $V_id = strtolower(substr($id, 0, 4));
                    $V_name = substr($id, 6, strlen($id) - 6);
                    if ($type == 'pci') self::$pci_ids_array[$V_id] = array('name' => $V_name);
                    elseif ($type == 'usb') self::$usb_ids_array[$V_id] = array('name' => $V_name);
                }
                elseif (substr($id, 0, 2) == "\t\t")  { // Subsys
                    $S_id = strtolower(str_replace(' ', '', substr($id, 2, 9)));
                    $S_name = trim(substr($id, 13, strlen($id) - 13));
                    if ($type == 'pci') self::$pci_ids_array[$V_id][$D_id][$S_id] = array('name' => $S_name);
                    elseif ($type == 'usb') self::$usb_ids_array[$V_id][$D_id][$S_id] = array('name' => $S_name);
                }
                elseif (substr($id, 0, 1) == "\t")  {   // Device
                    $D_id = strtolower(substr($id, 1, 4));
                    $D_name = trim(substr($id, 7, strlen($id) - 7));
                    if ($type == 'pci') self::$pci_ids_array[$V_id][$D_id] = array('name' => $D_name);
                    elseif ($type == 'usb') self::$usb_ids_array[$V_id][$D_id] = array('name' => $D_name);
                }
            }
        }
    }

    /**
     *   Crear fichero nuevo con los datos de los arrays globales:
     */
    static function createNewIdsFile($ids_array, $ids_file) {
        foreach ($ids_array as $V_id => $val1) {
            file_put_contents($ids_file, '*'.$V_id.'*'.$val1['name']."\r\n", FILE_APPEND);
            unset($val1['name']);
            foreach ($val1 as $D_id => $val2) {
                file_put_contents($ids_file, '#*'.$V_id.'*'.$D_id.'*'.$val2['name']."\r\n", FILE_APPEND);
                unset($val2['name']);
                foreach ($val2 as $S_id => $val3) {
                    file_put_contents($ids_file, '##*'.$V_id.'*'.$D_id.'*'.$S_id.'*'.$val3['name']."\r\n", FILE_APPEND);
                    unset($val3);
                }
                unset($val2);
            }
            unset($val1);
        }
    }
    
    /*
     * To avoid sfWidgetFormPropelChoice error in Forms and Filters;
     */
    public function getPrimaryKeys() {
        return $this->getCode().'-'.$this->getTypeId();
    }

    function __toString() {
        if ($this->name)
            return $this->name;
        else
            return 'NULL';
    }	
}