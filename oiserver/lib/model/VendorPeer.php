<?php

class VendorPeer extends BaseVendorPeer {

    /**
     *   Funcion de actualizacion||insercion de los datos y ficheros para las nuevas listas usb|pci:
     */
    static function updateIds($ids, $ids_file, $T_id, $time1) {
        $new_v = array();
        $c_new_v = 0;
        $updated_v = array();
        $c_updated_v = 0;
        $updated_old_v = array();

        $new_d = array();
        $c_new_d = 0;
        $updated_d = array();
        $c_updated_d = 0;
        $updated_old_d = array();

        $new_s = array();
        $c_new_s = 0;
        $updated_s = array();
        $c_updated_s = 0;
        $updated_old_s = array();
        
        foreach ($ids as $id) {
            $st_char = substr($id, 0, 1);
            if ($id != '---' && ($st_char == '>' || $st_char == '+' || $st_char == '<' || $st_char == '-')) {
                if (substr($id, 0, 1) == '>' || substr($id, 0, 1) == '+') {
                    $id = substr($id, 2, strlen($id) - 2);
                    if (substr($id, 0, 1) == '*') { // Vendor
                        $V_id = substr($id, 1, 4);
                        $V_name = substr($id, 6, strlen($id) - 6);
                        $v = new Vendor();
                        $v->setCode($V_id);
                        $v->setTypeId($T_id);
                        $v->setName($V_name);
                        try {   // New Vendor in DB. Insert:
                            $v->save();
                            //if ($v->isNew() === true) {
                                file_put_contents($ids_file, '*'.$V_id.'*'.$V_name."\r\n", FILE_APPEND);
                                $new_v[$V_id] = $V_name;
                                $c_new_v ++;
                            //}
                        }
                        catch(Exception $e) {   // Vendor exists in DB. Update:
                            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                                $v = self::retrieveByPK($V_id, $T_id);
                                if ($v->getName() != $V_name) {
                                    $updated_old_v[$V_id] = $v->getName();
                                    $string_old = str_replace(' ', '\ ', escapeshellcmd('*'.$V_id.'*'.$v->getName()));
                                    $string_new = str_replace(' ', '\ ', escapeshellcmd('*'.$V_id.'*'.$V_name));
                                    $v->setName($V_name);
                                    $v->save();
                                    //if ($v->isModified()) {
                                        $updated_v[$V_id] = $V_name;
                                        $c_updated_v ++;
                                        executeClass::ArrExecute("sed 's/$string_old/$string_new/i' $ids_file");
                                    //}
                                    unset($string_new, $string_old, $e);
                                }
                            }
                        }
                        unset($v);
                    }
                    elseif (substr($id, 0, 2) == '#*') {    // Device
                        $V_id = substr($id, 2, 4);
                        $D_id = substr($id, 7, 4);
                        $D_name = substr($id, 12, strlen($id) - 12);
                        $d = new Device();
                        $d->setCode($D_id);
                        $d->setVendorId($V_id);
                        $d->setTypeId($T_id);
                        $d->setName($D_name);
                        try {   // New Device in DB. Insert:
                            $d->save();
                            file_put_contents($ids_file, '#*'.$V_id.'*'.$D_id.'*'.$D_name."\r\n", FILE_APPEND);
                            $new_d[$V_id][$D_id] = $D_name;
                            $c_new_d ++;
                        }
                        catch(Exception $e) {   // Device exists in DB. Update:
                            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                                $c = new Criteria;
                                $c->add(DevicePeer::CODE, $D_id);
                                $c->add(DevicePeer::VENDOR_ID, $V_id);
                                $c->add(DevicePeer::TYPE_ID, $T_id);
                                $d = DevicePeer::doSelectOne($c);
                                if ($d->getName() != $D_name) {
                                    $updated_old_d[$V_id][$D_id] = $d->getName();
                                    $string_old = str_replace(' ', '\ ', escapeshellcmd('#*'.$V_id.'*'.$D_id.'*'.$d->getName()));
                                    $string_new = str_replace(' ', '\ ', escapeshellcmd('#*'.$V_id.'*'.$D_id.'*'.$D_name));
                                    $d->setName($D_name);
                                    $d->save();
                                    $updated_d[$V_id][$D_id] = $D_name;
                                    $c_updated_d ++;
                                    executeClass::ArrExecute("sed 's/$string_old/$string_new/i' $ids_file");
                                    unset($string_new, $string_old, $c, $e);
                                }
                            }
                        }
                        $Dev_id = $d->getId();
                        unset($d);
                    }
                    elseif (substr($id, 0, 3) == '##*') {    // Subsys
                        $V_id = substr($id, 3, 4);
                        $D_id = substr($id, 8, 4);
                        $S_id = substr($id, 13, 8);
                        $S_name = substr($id, 22, strlen($id) - 22);
                        $s = new Subsys();
                        $s->setCode($S_id);
                        $s->setDeviceId($Dev_id);
                        $s->setName($S_name);
                        try {   // New Device in DB. Insert:
                            $s->save();
                            file_put_contents($ids_file, '##*'.$V_id.'*'.$D_id.'*'.$S_id.'*'.$S_name."\r\n", FILE_APPEND);
                            $new_s[$V_id][$D_id][$S_id] = $S_name;
                            $c_new_s ++;
                        }
                        catch(Exception $e) {   // Subsys exists in DB. Update:
                            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                                $s = SubsysPeer::retrieveByPK($S_id, $Dev_id, '00');
                                if ($s->getName() != $S_name) {
                                    $updated_old_s[$V_id][$D_id][$S_id] = $s->getName();
                                    $string_old = str_replace(' ', '\ ', escapeshellcmd('##*'.$V_id.'*'.$D_id.'*'.$S_id.'*'.$s->getName()));
                                    $string_new = str_replace(' ', '\ ', escapeshellcmd('##*'.$V_id.'*'.$D_id.'*'.$S_id.'*'.$S_name));
                                    $s->setName($S_name);
                                    $s->save();
                                    $updated_s[$V_id][$D_id][$S_id] = $S_name;
                                    $c_updated_s ++;
                                    executeClass::ArrExecute("sed 's/$string_old/$string_new/i' $ids_file");
                                    unset($string_new, $string_old, $e);
                                }
                            }
                        }
                        unset($s);
                    }
                }
//                elseif ($st_char == '<' || $st_char == '-') {
//
//                        /* TODO */
//
//                }
            }
        }
        $t2 = time();
        $time = $t2 - $time1;
        return array(
            'new_v' => $new_v, 'c_new_v' => $c_new_v, 'updated_v' => $updated_v, 'updated_old_v' => $updated_old_v, 'c_updated_v' => $c_updated_v,
            'new_d' => $new_d, 'c_new_d' => $c_new_d, 'updated_d' => $updated_d, 'updated_old_d' => $updated_old_d, 'c_updated_d' => $c_updated_d,
            'new_s' => $new_s, 'c_new_s' => $c_new_s, 'updated_s' => $updated_s, 'updated_old_s' => $updated_old_s, 'c_updated_s' => $c_updated_s,
            'type_id' => $T_id, 'time' => $time);
    }
    //kam
	public static function get_vendor_id_list(){
		$c=new Criteria();
		$my_array=array();

		
		$c->addAscendingOrderByColumn(self::CODE);
		$c->addGroupByColumn(self::CODE);

		//$vendor_list=self::doSelect($c);
		$cfg=self::doSelect($c);

		/*if(count($vendor_list)>0){
			foreach($vendor_list as $i=>$v){
				$code=$v->getCode();
				if(!in_array($code,$my_array)){
					$my_array[]=$code;
					$vendor_new=clone $v;
					$vendor_new->setName($code);
					$cfg[]=$vendor_new;
				}
			}
		}*/

		return $cfg;
	}
	//kam
	public static function get_autocomplete_vendor_list($q='', $limit=10) {
		$c=new Criteria();
		$my_array=array();

		//$c->add(self::NOMBRE, '%'.$q.'%', Criteria::LIKE);
		$c->add(self::CODE, $q.'%', Criteria::LIKE);
		$c->addAscendingOrderByColumn(self::CODE);
		$c->addGroupByColumn(self::CODE);
		$c->setLimit($limit);
		
		$cfg=self::doSelect($c);

		return $cfg;
	}
	//kam
	public static function get_choices_primary_compose(){
		$cfg=array();
		$c=new Criteria();		
		$vendor_list=self::doSelect($c);	
		
		if(count($vendor_list)>0){
			foreach($vendor_list as $i=>$v){
				$cfg[]=$v->getCode().'-'.$v->getTypeId();
			}
		}

		return $cfg;		
	}
}