<?php

/**
 * Subclass for performing query and update operations on the 'device' table.
 *
 * 
 *
 * @package lib.model
 */ 
class DevicePeer extends BaseDevicePeer
{
	//kam
	//OHARRA::::ajax executeDevice ta executeDevice_id-n erabiltzen da
	public static function get_autocomplete_device_list($q='', $limit=10) {
		$c=new Criteria();
		//$my_array=array();

		
		$c->add(self::NAME, $q.'%', Criteria::LIKE);
		$c->addAscendingOrderByColumn(self::NAME);
		$c->addGroupByColumn(self::NAME);
		$c->setLimit($limit);
		
		$cfg=self::doSelect($c);

		return $cfg;
	}
	//kam
	public static function get_device_by_code($code){
		$c=new Criteria();
		$c->add(self::CODE,$code);		
		return self::doSelectOne($c);
	}	
}
