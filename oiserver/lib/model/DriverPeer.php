<?php

/**
 * Subclass for performing query and update operations on the 'driver' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DriverPeer extends BaseDriverPeer
{
    static function version($date) {
        $temp = explode(',', $date);
        $date = trim($temp[0]);
        if (strlen($date) > 10) {
            if (strpos($date, 'mon') !== false) {
                $date = trim(str_replace('mon', '', $date));
            } elseif (strpos($date, 'tue') !== false) {
                $date = trim(str_replace('tue', '', $date));
            } elseif (strpos($date, 'wed') !== false) {
                $date = trim(str_replace('wed', '', $date));
            } elseif (strpos($date, 'thu') !== false) {
                $date = trim(str_replace('thu', '', $date));
            } elseif (strpos($date, 'fri') !== false) {
                $date = trim(str_replace('fri', '', $date));
            } elseif (strpos($date, 'sat') !== false) {
                $date = trim(str_replace('sat', '', $date));
            } elseif (strpos($date, 'sun') !== false) {
                $date = trim(str_replace('sun', '', $date));
            }
        }
        if ((int)substr($date, 0, 2) > 12 && strlen(substr($date, 6, strlen($date))) == 4) {
             $temp = explode('/', $date);
             $date = $temp[1].'/'.$temp[0].'/'.$temp[2];
        }
        if (strpos($date, '(') !== false) $date = trim(substr($date, 0, strpos($date, '(')));
        if (strpos($date, ')') !== false) $date = trim(substr($date, 0, strpos($date, ')')));
        return $date;
    }

    static function dbUpdateHook(&$class, &$date, &$name, &$url, &$dr_id) {
        $dr = DriverPeer::retrieveByPK($dr_id);
        $dr->setClassType($class);
        $dr->setDate($date);
        $dr->setName($name);
        $dr->setUrl($url);
        try {
            $dr->save();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    static function saveDriver($string, $driver, $dr_cont, $sub_cont, $os, $file_path) {
        if (isset($string[7]) && $string[6] == 'subsys') {
            //Check if Subsys exists
            $c = new Criteria;
            $c->add(DevicePeer::CODE, $string[5]);
            $device = DevicePeer::doSelectOne($c);
            if (!is_null($device)) {
                $device_id = $device->getId();
                unset($c, $device);
                $c = new Criteria;
                $c->add(SubsysPeer::CODE, $string[7]);
                $c->add(SubsysPeer::DEVICE_ID, $device_id);
                if (isset($string[9]) && $string[8] == 'rev') {
                    $c->add(SubsysPeer::REVISION, $string[9]);
                } else  $c->add(SubsysPeer::REVISION, '0');
                $subsys = SubsysPeer::doSelectOne($c);
                if (is_null($subsys)) {
                    $sub = new Subsys();
                    $sub->setCode($string[7]);
                    $sub->setDeviceId($device_id);
                    if (isset($string[9]) && $string[8] == 'rev')   $sub->setRevision($string[9]);
                    $sub->save();
                    unset($sub);
                    $sub_cont ++;
                }
                unset($c, $device_id, $subsys, $subs);
            }
        }
        $dr_cont ++;
        $dr_id = $driver->getId();
        //New System
        $system = new System();
        $system->setDriverId($dr_id);
        $system->setName('$'.str_replace('$', '', $os).'$');
        $system->save();
        unset($system);
        //New Path
        $path = new Path();
        $path->setDriverId($dr_id);
        $path->setPath(pathinfo($file_path, PATHINFO_DIRNAME));
        $path->save();
        $path_id = $path->getId();
        unset($path);
        //New Pack
        
        unset($dr_id);
        return array($sub_cont, $dr_cont);
    }

    static function updateDriverDependencies($string, $dr_id, $os, $file_path) {
        //Update System
        $c = new Criteria;
        $c->add(SystemPeer::DRIVER_ID, $dr_id);
        $system = SystemPeer::doSelectOne($c);
        $system->setName('$'.str_replace('$', '', $os).'$');
        $system->save();
        unset($system, $c);
        //Update Path
        $c = new Criteria;
        $c->add(PathPeer::DRIVER_ID, $dr_id);
        $path = PathPeer::doSelectOne($c);
        $path->setPath(pathinfo($file_path, PATHINFO_DIRNAME));
        $path->save();
        $path_id = $path->getId();
        unset($path, $c);
        //Update Pack

        unset($dr_id);
        return;
    }

    static function searchDriver($params) {
        $string = self::stringSearch($params);
        //echo 'string='.$string.'<BR/>';
        if ($string == '0') return false;
        else {
            //Check if String exists in Driver table
            $c = new Criteria;
            $c->add(DriverPeer::STRING, $string);
            $driver = DriverPeer::doSelectOne($c);
            unset($c);
            if (!is_null($driver)) {
                $result = true;
                //$result = Driver::returnSearch($driver);
            } else {
                $result = false;
                unset($driver);
            }
            if (!$result) {
                if (stripos($string, '&REV_') !== false) {
                    $string = substr($string, 0, (stripos($string, '&REV_')));
                    $c = new Criteria;
                    $c->add(DriverPeer::STRING, $string);
                    $driver = DriverPeer::doSelectOne($c);
                    unset($c);
                    if (!is_null($driver)) {
                        $result = true;
                        //$result = Driver::returnSearch($driver);
                    } else {
                        $result = false;
                        unset($driver);
                    }
                }
                if (!$result) {
                    if (stripos($string, '&SUBSYS_') !== false) {
                        $string = substr($string, 0, (stripos($string, '&SUBSYS_')));
                        $c = new Criteria;
                        $c->add(DriverPeer::STRING, $string);
                        $driver = DriverPeer::doSelectOne($c);
                        unset($c);
                        if (!is_null($driver)) {
                            $result = true;
                            //$result = Driver::returnSearch($driver);
                        } else {
                            $result = false;
                            unset($driver);
                        }
                    }
                }
            }
            if ($result === true) {
                return $driver;
            } elseif ($result === false) {
                return false;
            }
        }
    }

    static function stringSearch($params) {
        //kam
        //$act = '/driver/search';
        
        //$needle='/drivers/web/index.php/en/driver/search';
        //$req = str_replace($_SERVER['SCRIPT_NAME'].$act, '', stristr(ParseINF::selfURL(), $needle));
        //$req_old = str_replace($needle, '', stristr(ParseINF::selfURL(), $needle));
       
        //echo $req_old.'<BR/>';

        $req=$params;

       
        $data = explode('&', str_replace('?', '', $req));
        if (count($data) < 3 || count($data) > 5)   $ret = 0;
        elseif (count($data) > 2 && count($data) < 6) {
            $string = array();
            foreach($data as $item) {
                $item_array = explode('=', $item);
                if ($item_array[0] == 'type')
                    $string['type'] = $item_array[1].'\\';
                elseif ($item_array[0] == 'vid' && isset($string['type']) && strtolower($string['type']) == 'usb\\')
                    $string['vid'] = 'vid_'.$item_array[1];
                elseif ($item_array[0] == 'vid' && isset($string['type']) && strtolower($string['type']) == 'pci\\')
                    $string['vid'] = 'ven_'.$item_array[1];
                elseif ($item_array[0] == 'pid' && isset($string['type']) && isset($string['vid']) && strtolower($string['type']) == 'usb\\')
                    $string['pid'] = '&pid_'.$item_array[1];
                elseif ($item_array[0] == 'pid' && isset($string['type']) && isset($string['vid']) && strtolower($string['type']) == 'pci\\')
                    $string['pid'] = '&dev_'.$item_array[1];
                elseif (count($data) > 3 && $item_array[0] == 'subsys' && isset($string['type']) && isset($string['vid']) && isset($string['pid']))
                    $string['subsys'] = '&subsys_'.$item_array[1];
                elseif (count($data) > 4 && $item_array[0] == 'rev' && isset($string['type']) && isset($string['vid']) && isset($string['pid']) && isset($string['subsys']))
                    $string['rev'] = '&rev_'.$item_array[1];
                else    $ret = 0;
                unset($item);
                }
            unset($item, $item_array);
            if (!isset($ret)) {
                $ret = '';
                foreach($string as $item)   $ret .= $item;
                unset($item, $string);
            }
        }
        else    $ret = 0;
        unset($data, $req, $act, $zipfile);
        return $ret;
    }
	//
	public static function is_no_query($filters){

		if(count($filters)>0){
			foreach($filters as $name=>$value){
				if(is_array($value)){
					if(count($value)>0){
						foreach($value as $value_name=>$v){
							if(!empty($v)){
								return 0;
							}
						}
					}
				}else if(!empty($value)){
					return 0;
				}
			}
		}
		return 1;
	}
	//kam
	public static function doSelectCustom(Criteria $criteria, PropelPDO $con = null)
	{
		//kam
		if(self::is_apply_custom_criteria()){					
			$criteria=self::add_custom_criteria($criteria);
		}		
		//
		return DriverPeer::populateObjects(DriverPeer::doSelectStmt($criteria, $con));
	}
	//kam
	private static function add_custom_criteria(Criteria $criteria){
		//OHARRA::::device_id bat aukeratzean, code,vendor_id ta type_id arabera begiratu behar da
		$criteria=clone $criteria;

		$sf_user=sfContext::getInstance()->getUser();
		$filters=$sf_user->getAttribute('driver.filters',array(),'admin_module');

		if(empty($filters['vendor_id'])){
			$criteria->add(self::VENDOR_ID,$sf_user->getAttribute('device_driver_filters_vendor_id'));		
		}
		if(empty($filters['type_id'])){
			$criteria->add(self::TYPE_ID,$sf_user->getAttribute('device_driver_filters_type_id'));
		}
		return $criteria;
	}
	//
	//kam
	public static function doCountCustom(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(DriverPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			DriverPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		//kam
		if(self::is_apply_custom_criteria()){						
			$criteria=self::add_custom_criteria($criteria);			
		}
		//
				$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}
	//kam
	private static function is_apply_custom_criteria(){

		$sf_user=sfContext::getInstance()->getUser();
		/*$my_array=sfConfig::get('app_driver_custom_criteria_fields');
		if(count($my_array)>0){
			foreach($my_array as $i=>$f){
				if($sf_user->getAttribute($f)){
					return 1;
				}
			}
		}*/
		if($sf_user->getAttribute('driver_filters_device_id')){
			return 1;
		}
		return 0;
	}
	//kam	
	public static function get_autocomplete_driver_name_list($q='', $limit=10) {
		$c=new Criteria();
				
		$c->add(self::NAME, $q.'%', Criteria::LIKE);
		$c->addAscendingOrderByColumn(self::NAME);
		$c->addGroupByColumn(self::NAME);
		$c->setLimit($limit);
		
		$cfg=self::doSelect($c);

		return $cfg;
	}	
}