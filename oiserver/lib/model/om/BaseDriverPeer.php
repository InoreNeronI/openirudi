<?php


abstract class BaseDriverPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'driver';

	
	const CLASS_DEFAULT = 'lib.model.Driver';

	
	const NUM_COLUMNS = 10;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;

	
	const ID = 'driver.ID';

	
	const TYPE_ID = 'driver.TYPE_ID';

	
	const VENDOR_ID = 'driver.VENDOR_ID';

	
	const DEVICE_ID = 'driver.DEVICE_ID';

	
	const CLASS_TYPE = 'driver.CLASS_TYPE';

	
	const NAME = 'driver.NAME';

	
	const DATE = 'driver.DATE';

	
	const STRING = 'driver.STRING';

	
	const URL = 'driver.URL';

	
	const CREATED_AT = 'driver.CREATED_AT';

	
	public static $instances = array();

	
	private static $mapBuilder = null;

	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'TypeId', 'VendorId', 'DeviceId', 'ClassType', 'Name', 'Date', 'String', 'Url', 'CreatedAt', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'typeId', 'vendorId', 'deviceId', 'classType', 'name', 'date', 'string', 'url', 'createdAt', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::TYPE_ID, self::VENDOR_ID, self::DEVICE_ID, self::CLASS_TYPE, self::NAME, self::DATE, self::STRING, self::URL, self::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'type_id', 'vendor_id', 'device_id', 'class_type', 'name', 'date', 'string', 'url', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'TypeId' => 1, 'VendorId' => 2, 'DeviceId' => 3, 'ClassType' => 4, 'Name' => 5, 'Date' => 6, 'String' => 7, 'Url' => 8, 'CreatedAt' => 9, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'typeId' => 1, 'vendorId' => 2, 'deviceId' => 3, 'classType' => 4, 'name' => 5, 'date' => 6, 'string' => 7, 'url' => 8, 'createdAt' => 9, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::TYPE_ID => 1, self::VENDOR_ID => 2, self::DEVICE_ID => 3, self::CLASS_TYPE => 4, self::NAME => 5, self::DATE => 6, self::STRING => 7, self::URL => 8, self::CREATED_AT => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'type_id' => 1, 'vendor_id' => 2, 'device_id' => 3, 'class_type' => 4, 'name' => 5, 'date' => 6, 'string' => 7, 'url' => 8, 'created_at' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new DriverMapBuilder();
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
		return str_replace(DriverPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(DriverPeer::ID);

		$criteria->addSelectColumn(DriverPeer::TYPE_ID);

		$criteria->addSelectColumn(DriverPeer::VENDOR_ID);

		$criteria->addSelectColumn(DriverPeer::DEVICE_ID);

		$criteria->addSelectColumn(DriverPeer::CLASS_TYPE);

		$criteria->addSelectColumn(DriverPeer::NAME);

		$criteria->addSelectColumn(DriverPeer::DATE);

		$criteria->addSelectColumn(DriverPeer::STRING);

		$criteria->addSelectColumn(DriverPeer::URL);

		$criteria->addSelectColumn(DriverPeer::CREATED_AT);

	}

	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
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
		$objects = DriverPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return DriverPeer::populateObjects(DriverPeer::doSelectStmt($criteria, $con));
	}
	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			DriverPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

				return BasePeer::doSelect($criteria, $con);
	}
	
	public static function addInstanceToPool(Driver $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getId();
			} 			self::$instances[$key] = $obj;
		}
	}

	
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof Driver) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
								$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Driver object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
				if ($row[$startcol + 0] === null) {
			return null;
		}
		return (string) $row[$startcol + 0];
	}

	
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
				$cls = DriverPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = DriverPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = DriverPeer::getInstanceFromPool($key))) {
																$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				DriverPeer::addInstanceToPool($obj, $key);
			} 		}
		$stmt->closeCursor();
		return $results;
	}

	
	public static function doCountJoinType(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(DriverPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			DriverPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(DriverPeer::TYPE_ID,), array(TypePeer::ID,), $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinVendor(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(DriverPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			DriverPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(DriverPeer::VENDOR_ID,), array(VendorPeer::CODE,), $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinDevice(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(DriverPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			DriverPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(DriverPeer::DEVICE_ID,), array(DevicePeer::CODE,), $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinType(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DriverPeer::addSelectColumns($c);
		$startcol = (DriverPeer::NUM_COLUMNS - DriverPeer::NUM_LAZY_LOAD_COLUMNS);
		TypePeer::addSelectColumns($c);

		$c->addJoin(array(DriverPeer::TYPE_ID,), array(TypePeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = DriverPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = DriverPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = DriverPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				DriverPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = TypePeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = TypePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = TypePeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					TypePeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addDriver($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinVendor(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DriverPeer::addSelectColumns($c);
		$startcol = (DriverPeer::NUM_COLUMNS - DriverPeer::NUM_LAZY_LOAD_COLUMNS);
		VendorPeer::addSelectColumns($c);

		$c->addJoin(array(DriverPeer::VENDOR_ID,), array(VendorPeer::CODE,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = DriverPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = DriverPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = DriverPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				DriverPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = VendorPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = VendorPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = VendorPeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					VendorPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addDriver($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinDevice(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DriverPeer::addSelectColumns($c);
		$startcol = (DriverPeer::NUM_COLUMNS - DriverPeer::NUM_LAZY_LOAD_COLUMNS);
		DevicePeer::addSelectColumns($c);

		$c->addJoin(array(DriverPeer::DEVICE_ID,), array(DevicePeer::CODE,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = DriverPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = DriverPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = DriverPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				DriverPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = DevicePeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = DevicePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = DevicePeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					DevicePeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addDriver($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(DriverPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			DriverPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(DriverPeer::TYPE_ID,), array(TypePeer::ID,), $join_behavior);
		$criteria->addJoin(array(DriverPeer::VENDOR_ID,), array(VendorPeer::CODE,), $join_behavior);
		$criteria->addJoin(array(DriverPeer::DEVICE_ID,), array(DevicePeer::CODE,), $join_behavior);
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

		DriverPeer::addSelectColumns($c);
		$startcol2 = (DriverPeer::NUM_COLUMNS - DriverPeer::NUM_LAZY_LOAD_COLUMNS);

		TypePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (TypePeer::NUM_COLUMNS - TypePeer::NUM_LAZY_LOAD_COLUMNS);

		VendorPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (VendorPeer::NUM_COLUMNS - VendorPeer::NUM_LAZY_LOAD_COLUMNS);

		DevicePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + (DevicePeer::NUM_COLUMNS - DevicePeer::NUM_LAZY_LOAD_COLUMNS);

		$c->addJoin(array(DriverPeer::TYPE_ID,), array(TypePeer::ID,), $join_behavior);
		$c->addJoin(array(DriverPeer::VENDOR_ID,), array(VendorPeer::CODE,), $join_behavior);
		$c->addJoin(array(DriverPeer::DEVICE_ID,), array(DevicePeer::CODE,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = DriverPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = DriverPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = DriverPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				DriverPeer::addInstanceToPool($obj1, $key1);
			} 
			
			$key2 = TypePeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = TypePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = TypePeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					TypePeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addDriver($obj1);
			} 
			
			$key3 = VendorPeer::getPrimaryKeyHashFromRow($row, $startcol3);
			if ($key3 !== null) {
				$obj3 = VendorPeer::getInstanceFromPool($key3);
				if (!$obj3) {

					$omClass = VendorPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					VendorPeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addDriver($obj1);
			} 
			
			$key4 = DevicePeer::getPrimaryKeyHashFromRow($row, $startcol4);
			if ($key4 !== null) {
				$obj4 = DevicePeer::getInstanceFromPool($key4);
				if (!$obj4) {

					$omClass = DevicePeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					DevicePeer::addInstanceToPool($obj4, $key4);
				} 
								$obj4->addDriver($obj1);
			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAllExceptType(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			DriverPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(DriverPeer::VENDOR_ID,), array(VendorPeer::CODE,), $join_behavior);
				$criteria->addJoin(array(DriverPeer::DEVICE_ID,), array(DevicePeer::CODE,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinAllExceptVendor(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			DriverPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(DriverPeer::TYPE_ID,), array(TypePeer::ID,), $join_behavior);
				$criteria->addJoin(array(DriverPeer::DEVICE_ID,), array(DevicePeer::CODE,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinAllExceptDevice(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			DriverPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(DriverPeer::TYPE_ID,), array(TypePeer::ID,), $join_behavior);
				$criteria->addJoin(array(DriverPeer::VENDOR_ID,), array(VendorPeer::CODE,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinAllExceptType(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DriverPeer::addSelectColumns($c);
		$startcol2 = (DriverPeer::NUM_COLUMNS - DriverPeer::NUM_LAZY_LOAD_COLUMNS);

		VendorPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (VendorPeer::NUM_COLUMNS - VendorPeer::NUM_LAZY_LOAD_COLUMNS);

		DevicePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (DevicePeer::NUM_COLUMNS - DevicePeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(DriverPeer::VENDOR_ID,), array(VendorPeer::CODE,), $join_behavior);
				$c->addJoin(array(DriverPeer::DEVICE_ID,), array(DevicePeer::CODE,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = DriverPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = DriverPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = DriverPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				DriverPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = VendorPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = VendorPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = VendorPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					VendorPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addDriver($obj1);

			} 
				
				$key3 = DevicePeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = DevicePeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$omClass = DevicePeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					DevicePeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addDriver($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinAllExceptVendor(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DriverPeer::addSelectColumns($c);
		$startcol2 = (DriverPeer::NUM_COLUMNS - DriverPeer::NUM_LAZY_LOAD_COLUMNS);

		TypePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (TypePeer::NUM_COLUMNS - TypePeer::NUM_LAZY_LOAD_COLUMNS);

		DevicePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (DevicePeer::NUM_COLUMNS - DevicePeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(DriverPeer::TYPE_ID,), array(TypePeer::ID,), $join_behavior);
				$c->addJoin(array(DriverPeer::DEVICE_ID,), array(DevicePeer::CODE,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = DriverPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = DriverPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = DriverPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				DriverPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = TypePeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = TypePeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = TypePeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					TypePeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addDriver($obj1);

			} 
				
				$key3 = DevicePeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = DevicePeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$omClass = DevicePeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					DevicePeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addDriver($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinAllExceptDevice(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DriverPeer::addSelectColumns($c);
		$startcol2 = (DriverPeer::NUM_COLUMNS - DriverPeer::NUM_LAZY_LOAD_COLUMNS);

		TypePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (TypePeer::NUM_COLUMNS - TypePeer::NUM_LAZY_LOAD_COLUMNS);

		VendorPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (VendorPeer::NUM_COLUMNS - VendorPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(DriverPeer::TYPE_ID,), array(TypePeer::ID,), $join_behavior);
				$c->addJoin(array(DriverPeer::VENDOR_ID,), array(VendorPeer::CODE,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = DriverPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = DriverPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = DriverPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				DriverPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = TypePeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = TypePeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = TypePeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					TypePeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addDriver($obj1);

			} 
				
				$key3 = VendorPeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = VendorPeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$omClass = VendorPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					VendorPeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addDriver($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


  static public function getUniqueColumnNames()
  {
    return array(array('string'));
  }
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return DriverPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		if ($criteria->containsKey(DriverPeer::ID) && $criteria->keyContainsValue(DriverPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.DriverPeer::ID.')');
		}


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
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(DriverPeer::ID);
			$selectCriteria->add(DriverPeer::ID, $criteria->remove(DriverPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; 		try {
									$con->beginTransaction();
			$affectedRows += DriverPeer::doOnDeleteCascade(new Criteria(DriverPeer::DATABASE_NAME), $con);
			$affectedRows += BasePeer::doDeleteAll(DriverPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
												DriverPeer::clearInstancePool();

						$criteria = clone $values;
		} elseif ($values instanceof Driver) {
						DriverPeer::removeInstanceFromPool($values);
						$criteria = $values->buildPkeyCriteria();
		} else {
			


			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(DriverPeer::ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
								DriverPeer::removeInstanceFromPool($singleval);
			}
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->beginTransaction();
			$affectedRows += DriverPeer::doOnDeleteCascade($criteria, $con);
			
																if ($values instanceof Criteria) {
					DriverPeer::clearInstancePool();
				} else { 					DriverPeer::removeInstanceFromPool($values);
				}
			
			$affectedRows += BasePeer::doDelete($criteria, $con);

						SystemPeer::clearInstancePool();

						PathPeer::clearInstancePool();

			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	protected static function doOnDeleteCascade(Criteria $criteria, PropelPDO $con)
	{
				$affectedRows = 0;

				$objects = DriverPeer::doSelect($criteria, $con);
		foreach ($objects as $obj) {


						$c = new Criteria(SystemPeer::DATABASE_NAME);
			
			$c->add(SystemPeer::DRIVER_ID, $obj->getId());
			$affectedRows += SystemPeer::doDelete($c, $con);

						$c = new Criteria(PathPeer::DATABASE_NAME);
			
			$c->add(PathPeer::DRIVER_ID, $obj->getId());
			$affectedRows += PathPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	
	public static function doValidate(Driver $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(DriverPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(DriverPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(DriverPeer::DATABASE_NAME, DriverPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = DriverPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = DriverPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(DriverPeer::DATABASE_NAME);
		$criteria->add(DriverPeer::ID, $pk);

		$v = DriverPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(DriverPeer::DATABASE_NAME);
			$criteria->add(DriverPeer::ID, $pks, Criteria::IN);
			$objs = DriverPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 

Propel::getDatabaseMap(BaseDriverPeer::DATABASE_NAME)->addTableBuilder(BaseDriverPeer::TABLE_NAME, BaseDriverPeer::getMapBuilder());

