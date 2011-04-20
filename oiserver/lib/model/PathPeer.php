<?php

/**
 * Subclass for performing query and update operations on the 'path' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PathPeer extends BasePathPeer
{
	//kam
	public static function doSelectCustom(Criteria $criteria, PropelPDO $con = null)
	{
		//kam
		if(self::is_apply_custom_criteria()){					
			$criteria=self::add_custom_criteria($criteria);
		}		
		//
		return PathPeer::populateObjects(PathPeer::doSelectStmt($criteria, $con));
	}
	//kam
	public static function doCountCustom(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(PathPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			PathPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(PathPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
		$filters=$sf_user->getAttribute('path.filters',array(),'admin_module');
		$my_custom_criteria_fields=sfConfig::get('app_path_custom_criteria_fields');
		
		if(count($my_custom_criteria_fields)>0){
			foreach($my_custom_criteria_fields as $i=>$name){
				if(!empty($filters[$name])){
					return 1;
				}
			}
		}

		return 0;
	}
	//kam
	private static function add_custom_criteria(Criteria $criteria){
		//OHARRA::::device_id bat aukeratzean, code,vendor_id ta type_id arabera begiratu behar da
		$criteria=clone $criteria;

		$sf_user=sfContext::getInstance()->getUser();
		$filters=$sf_user->getAttribute('path.filters',array(),'admin_module');
		
		$criteria->addJoin(self::DRIVER_ID,DriverPeer::ID,Criteria::LEFT_JOIN);

		if(!empty($filters['driver_name'])){
			$criteria->add(DriverPeer::NAME, $filters['driver_name'].'%', Criteria::LIKE);
		}

		if(!empty($filters['type_id'])){
			$criteria->add(DriverPeer::TYPE_ID, $filters['type_id']);
		}
		
		if(!empty($filters['vendor_id'])){
			$criteria->add(DriverPeer::VENDOR_ID, $filters['vendor_id']);
		}
		return $criteria;
	}
}
