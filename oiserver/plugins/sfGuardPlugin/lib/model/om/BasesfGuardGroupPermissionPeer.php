<?php


abstract class BasesfGuardGroupPermissionPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_guard_group_permission';

	
	const CLASS_DEFAULT = 'plugins.sfGuardPlugin.lib.model.sfGuardGroupPermission';

	
	const NUM_COLUMNS = 2;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;

	
	const GROUP_ID = 'sf_guard_group_permission.GROUP_ID';

	
	const PERMISSION_ID = 'sf_guard_group_permission.PERMISSION_ID';

	
	public static $instances = array();

	
	private static $mapBuilder = null;

	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('GroupId', 'PermissionId', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('groupId', 'permissionId', ),
		BasePeer::TYPE_COLNAME => array (self::GROUP_ID, self::PERMISSION_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('group_id', 'permission_id', ),
		BasePeer::TYPE_NUM => array (0, 1, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('GroupId' => 0, 'PermissionId' => 1, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('groupId' => 0, 'permissionId' => 1, ),
		BasePeer::TYPE_COLNAME => array (self::GROUP_ID => 0, self::PERMISSION_ID => 1, ),
		BasePeer::TYPE_FIELDNAME => array ('group_id' => 0, 'permission_id' => 1, ),
		BasePeer::TYPE_NUM => array (0, 1, )
	);

	
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new sfGuardGroupPermissionMapBuilder();
		}
		return self::$mapBuilder;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(sfGuardGroupPermissionPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfGuardGroupPermissionPeer::GROUP_ID);

		$criteria->addSelectColumn(sfGuardGroupPermissionPeer::PERMISSION_ID);

	}

	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(sfGuardGroupPermissionPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			sfGuardGroupPermissionPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}
	
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = sfGuardGroupPermissionPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return sfGuardGroupPermissionPeer::populateObjects(sfGuardGroupPermissionPeer::doSelectStmt($criteria, $con));
	}
	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			sfGuardGroupPermissionPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

				return BasePeer::doSelect($criteria, $con);
	}
	
	public static function addInstanceToPool(sfGuardGroupPermission $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = serialize(array((string) $obj->getGroupId(), (string) $obj->getPermissionId()));
			} 			self::$instances[$key] = $obj;
		}
	}

	
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof sfGuardGroupPermission) {
				$key = serialize(array((string) $value->getGroupId(), (string) $value->getPermissionId()));
			} elseif (is_array($value) && count($value) === 2) {
								$key = serialize(array((string) $value[0], (string) $value[1]));
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or sfGuardGroupPermission object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} 
	
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; 	}
	
	
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
				if ($row[$startcol + 0] === null && $row[$startcol + 1] === null) {
			return null;
		}
		return serialize(array((string) $row[$startcol + 0], (string) $row[$startcol + 1]));
	}

	
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
				$cls = sfGuardGroupPermissionPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = sfGuardGroupPermissionPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = sfGuardGroupPermissionPeer::getInstanceFromPool($key))) {
																$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				sfGuardGroupPermissionPeer::addInstanceToPool($obj, $key);
			} 		}
		$stmt->closeCursor();
		return $results;
	}

	
	public static function doCountJoinsfGuardGroup(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(sfGuardGroupPermissionPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			sfGuardGroupPermissionPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(sfGuardGroupPermissionPeer::GROUP_ID,), array(sfGuardGroupPeer::ID,), $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinsfGuardPermission(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(sfGuardGroupPermissionPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			sfGuardGroupPermissionPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(sfGuardGroupPermissionPeer::PERMISSION_ID,), array(sfGuardPermissionPeer::ID,), $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinsfGuardGroup(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfGuardGroupPermissionPeer::addSelectColumns($c);
		$startcol = (sfGuardGroupPermissionPeer::NUM_COLUMNS - sfGuardGroupPermissionPeer::NUM_LAZY_LOAD_COLUMNS);
		sfGuardGroupPeer::addSelectColumns($c);

		$c->addJoin(array(sfGuardGroupPermissionPeer::GROUP_ID,), array(sfGuardGroupPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = sfGuardGroupPermissionPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = sfGuardGroupPermissionPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = sfGuardGroupPermissionPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				sfGuardGroupPermissionPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = sfGuardGroupPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = sfGuardGroupPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = sfGuardGroupPeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					sfGuardGroupPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addsfGuardGroupPermission($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinsfGuardPermission(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfGuardGroupPermissionPeer::addSelectColumns($c);
		$startcol = (sfGuardGroupPermissionPeer::NUM_COLUMNS - sfGuardGroupPermissionPeer::NUM_LAZY_LOAD_COLUMNS);
		sfGuardPermissionPeer::addSelectColumns($c);

		$c->addJoin(array(sfGuardGroupPermissionPeer::PERMISSION_ID,), array(sfGuardPermissionPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = sfGuardGroupPermissionPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = sfGuardGroupPermissionPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = sfGuardGroupPermissionPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				sfGuardGroupPermissionPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = sfGuardPermissionPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = sfGuardPermissionPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = sfGuardPermissionPeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					sfGuardPermissionPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addsfGuardGroupPermission($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(sfGuardGroupPermissionPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			sfGuardGroupPermissionPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(sfGuardGroupPermissionPeer::GROUP_ID,), array(sfGuardGroupPeer::ID,), $join_behavior);
		$criteria->addJoin(array(sfGuardGroupPermissionPeer::PERMISSION_ID,), array(sfGuardPermissionPeer::ID,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}

	
	public static function doSelectJoinAll(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfGuardGroupPermissionPeer::addSelectColumns($c);
		$startcol2 = (sfGuardGroupPermissionPeer::NUM_COLUMNS - sfGuardGroupPermissionPeer::NUM_LAZY_LOAD_COLUMNS);

		sfGuardGroupPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (sfGuardGroupPeer::NUM_COLUMNS - sfGuardGroupPeer::NUM_LAZY_LOAD_COLUMNS);

		sfGuardPermissionPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (sfGuardPermissionPeer::NUM_COLUMNS - sfGuardPermissionPeer::NUM_LAZY_LOAD_COLUMNS);

		$c->addJoin(array(sfGuardGroupPermissionPeer::GROUP_ID,), array(sfGuardGroupPeer::ID,), $join_behavior);
		$c->addJoin(array(sfGuardGroupPermissionPeer::PERMISSION_ID,), array(sfGuardPermissionPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = sfGuardGroupPermissionPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = sfGuardGroupPermissionPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = sfGuardGroupPermissionPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				sfGuardGroupPermissionPeer::addInstanceToPool($obj1, $key1);
			} 
			
			$key2 = sfGuardGroupPeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = sfGuardGroupPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = sfGuardGroupPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					sfGuardGroupPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addsfGuardGroupPermission($obj1);
			} 
			
			$key3 = sfGuardPermissionPeer::getPrimaryKeyHashFromRow($row, $startcol3);
			if ($key3 !== null) {
				$obj3 = sfGuardPermissionPeer::getInstanceFromPool($key3);
				if (!$obj3) {

					$omClass = sfGuardPermissionPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					sfGuardPermissionPeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addsfGuardGroupPermission($obj1);
			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAllExceptsfGuardGroup(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			sfGuardGroupPermissionPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(sfGuardGroupPermissionPeer::PERMISSION_ID,), array(sfGuardPermissionPeer::ID,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinAllExceptsfGuardPermission(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			sfGuardGroupPermissionPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(sfGuardGroupPermissionPeer::GROUP_ID,), array(sfGuardGroupPeer::ID,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinAllExceptsfGuardGroup(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfGuardGroupPermissionPeer::addSelectColumns($c);
		$startcol2 = (sfGuardGroupPermissionPeer::NUM_COLUMNS - sfGuardGroupPermissionPeer::NUM_LAZY_LOAD_COLUMNS);

		sfGuardPermissionPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (sfGuardPermissionPeer::NUM_COLUMNS - sfGuardPermissionPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(sfGuardGroupPermissionPeer::PERMISSION_ID,), array(sfGuardPermissionPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = sfGuardGroupPermissionPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = sfGuardGroupPermissionPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = sfGuardGroupPermissionPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				sfGuardGroupPermissionPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = sfGuardPermissionPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = sfGuardPermissionPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = sfGuardPermissionPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					sfGuardPermissionPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addsfGuardGroupPermission($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinAllExceptsfGuardPermission(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfGuardGroupPermissionPeer::addSelectColumns($c);
		$startcol2 = (sfGuardGroupPermissionPeer::NUM_COLUMNS - sfGuardGroupPermissionPeer::NUM_LAZY_LOAD_COLUMNS);

		sfGuardGroupPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (sfGuardGroupPeer::NUM_COLUMNS - sfGuardGroupPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(sfGuardGroupPermissionPeer::GROUP_ID,), array(sfGuardGroupPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = sfGuardGroupPermissionPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = sfGuardGroupPermissionPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = sfGuardGroupPermissionPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				sfGuardGroupPermissionPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = sfGuardGroupPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = sfGuardGroupPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = sfGuardGroupPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					sfGuardGroupPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addsfGuardGroupPermission($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


  static public function getUniqueColumnNames()
  {
    return array();
  }
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return sfGuardGroupPermissionPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}


				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollBack();
			throw $e;
		}

		return $pk;
	}

	
	public static function doUpdate($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(sfGuardGroupPermissionPeer::GROUP_ID);
			$selectCriteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $criteria->remove(sfGuardGroupPermissionPeer::GROUP_ID), $comparison);

			$comparison = $criteria->getComparison(sfGuardGroupPermissionPeer::PERMISSION_ID);
			$selectCriteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $criteria->remove(sfGuardGroupPermissionPeer::PERMISSION_ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; 		try {
									$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(sfGuardGroupPermissionPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
												sfGuardGroupPermissionPeer::clearInstancePool();

						$criteria = clone $values;
		} elseif ($values instanceof sfGuardGroupPermission) {
						sfGuardGroupPermissionPeer::removeInstanceFromPool($values);
						$criteria = $values->buildPkeyCriteria();
		} else {
			


			$criteria = new Criteria(self::DATABASE_NAME);
												if (count($values) == count($values, COUNT_RECURSIVE)) {
								$values = array($values);
			}

			foreach ($values as $value) {

				$criterion = $criteria->getNewCriterion(sfGuardGroupPermissionPeer::GROUP_ID, $value[0]);
				$criterion->addAnd($criteria->getNewCriterion(sfGuardGroupPermissionPeer::PERMISSION_ID, $value[1]));
				$criteria->addOr($criterion);

								sfGuardGroupPermissionPeer::removeInstanceFromPool($value);
			}
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);

			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	public static function doValidate(sfGuardGroupPermission $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfGuardGroupPermissionPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfGuardGroupPermissionPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(sfGuardGroupPermissionPeer::DATABASE_NAME, sfGuardGroupPermissionPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfGuardGroupPermissionPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($group_id, $permission_id, PropelPDO $con = null) {
		$key = serialize(array((string) $group_id, (string) $permission_id));
 		if (null !== ($obj = sfGuardGroupPermissionPeer::getInstanceFromPool($key))) {
 			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$criteria = new Criteria(sfGuardGroupPermissionPeer::DATABASE_NAME);
		$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $group_id);
		$criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $permission_id);
		$v = sfGuardGroupPermissionPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 

Propel::getDatabaseMap(BasesfGuardGroupPermissionPeer::DATABASE_NAME)->addTableBuilder(BasesfGuardGroupPermissionPeer::TABLE_NAME, BasesfGuardGroupPermissionPeer::getMapBuilder());

