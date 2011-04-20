<?php


abstract class BaseMyTaskPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'my_task';

	
	const CLASS_DEFAULT = 'lib.model.MyTask';

	
	const NUM_COLUMNS = 11;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;

	
	const ID = 'my_task.ID';

	
	const DAY = 'my_task.DAY';

	
	const HOUR = 'my_task.HOUR';

	
	const ASSOCIATE = 'my_task.ASSOCIATE';

	
	const OIIMAGES_ID = 'my_task.OIIMAGES_ID';

	
	const PARTITION = 'my_task.PARTITION';

	
	const PC_ID = 'my_task.PC_ID';

	
	const IS_IMAGESET = 'my_task.IS_IMAGESET';

	
	const IMAGESET_ID = 'my_task.IMAGESET_ID';

	
	const IS_BOOT = 'my_task.IS_BOOT';

	
	const DISK = 'my_task.DISK';

	
	public static $instances = array();

	
	private static $mapBuilder = null;

	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Day', 'Hour', 'Associate', 'OiimagesId', 'Partition', 'PcId', 'IsImageset', 'ImagesetId', 'IsBoot', 'Disk', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'day', 'hour', 'associate', 'oiimagesId', 'partition', 'pcId', 'isImageset', 'imagesetId', 'isBoot', 'disk', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::DAY, self::HOUR, self::ASSOCIATE, self::OIIMAGES_ID, self::PARTITION, self::PC_ID, self::IS_IMAGESET, self::IMAGESET_ID, self::IS_BOOT, self::DISK, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'day', 'hour', 'associate', 'oiimages_id', 'partition', 'pc_id', 'is_imageset', 'imageset_id', 'is_boot', 'disk', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Day' => 1, 'Hour' => 2, 'Associate' => 3, 'OiimagesId' => 4, 'Partition' => 5, 'PcId' => 6, 'IsImageset' => 7, 'ImagesetId' => 8, 'IsBoot' => 9, 'Disk' => 10, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'day' => 1, 'hour' => 2, 'associate' => 3, 'oiimagesId' => 4, 'partition' => 5, 'pcId' => 6, 'isImageset' => 7, 'imagesetId' => 8, 'isBoot' => 9, 'disk' => 10, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::DAY => 1, self::HOUR => 2, self::ASSOCIATE => 3, self::OIIMAGES_ID => 4, self::PARTITION => 5, self::PC_ID => 6, self::IS_IMAGESET => 7, self::IMAGESET_ID => 8, self::IS_BOOT => 9, self::DISK => 10, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'day' => 1, 'hour' => 2, 'associate' => 3, 'oiimages_id' => 4, 'partition' => 5, 'pc_id' => 6, 'is_imageset' => 7, 'imageset_id' => 8, 'is_boot' => 9, 'disk' => 10, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
	);

	
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new MyTaskMapBuilder();
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
		return str_replace(MyTaskPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MyTaskPeer::ID);

		$criteria->addSelectColumn(MyTaskPeer::DAY);

		$criteria->addSelectColumn(MyTaskPeer::HOUR);

		$criteria->addSelectColumn(MyTaskPeer::ASSOCIATE);

		$criteria->addSelectColumn(MyTaskPeer::OIIMAGES_ID);

		$criteria->addSelectColumn(MyTaskPeer::PARTITION);

		$criteria->addSelectColumn(MyTaskPeer::PC_ID);

		$criteria->addSelectColumn(MyTaskPeer::IS_IMAGESET);

		$criteria->addSelectColumn(MyTaskPeer::IMAGESET_ID);

		$criteria->addSelectColumn(MyTaskPeer::IS_BOOT);

		$criteria->addSelectColumn(MyTaskPeer::DISK);

	}

	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(MyTaskPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MyTaskPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
		$objects = MyTaskPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return MyTaskPeer::populateObjects(MyTaskPeer::doSelectStmt($criteria, $con));
	}
	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			MyTaskPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

				return BasePeer::doSelect($criteria, $con);
	}
	
	public static function addInstanceToPool(MyTask $obj, $key = null)
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
			if (is_object($value) && $value instanceof MyTask) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
								$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or MyTask object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	
				$cls = MyTaskPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = MyTaskPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = MyTaskPeer::getInstanceFromPool($key))) {
																$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				MyTaskPeer::addInstanceToPool($obj, $key);
			} 		}
		$stmt->closeCursor();
		return $results;
	}

	
	public static function doCountJoinOiimages(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(MyTaskPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MyTaskPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(MyTaskPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinPc(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(MyTaskPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MyTaskPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(MyTaskPeer::PC_ID,), array(PcPeer::ID,), $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinImageset(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(MyTaskPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MyTaskPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(MyTaskPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinOiimages(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MyTaskPeer::addSelectColumns($c);
		$startcol = (MyTaskPeer::NUM_COLUMNS - MyTaskPeer::NUM_LAZY_LOAD_COLUMNS);
		OiimagesPeer::addSelectColumns($c);

		$c->addJoin(array(MyTaskPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = MyTaskPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = MyTaskPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = MyTaskPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				MyTaskPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = OiimagesPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = OiimagesPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = OiimagesPeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					OiimagesPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addMyTask($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinPc(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MyTaskPeer::addSelectColumns($c);
		$startcol = (MyTaskPeer::NUM_COLUMNS - MyTaskPeer::NUM_LAZY_LOAD_COLUMNS);
		PcPeer::addSelectColumns($c);

		$c->addJoin(array(MyTaskPeer::PC_ID,), array(PcPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = MyTaskPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = MyTaskPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = MyTaskPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				MyTaskPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = PcPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = PcPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = PcPeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					PcPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addMyTask($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinImageset(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MyTaskPeer::addSelectColumns($c);
		$startcol = (MyTaskPeer::NUM_COLUMNS - MyTaskPeer::NUM_LAZY_LOAD_COLUMNS);
		ImagesetPeer::addSelectColumns($c);

		$c->addJoin(array(MyTaskPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = MyTaskPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = MyTaskPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = MyTaskPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				MyTaskPeer::addInstanceToPool($obj1, $key1);
			} 
			$key2 = ImagesetPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = ImagesetPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = ImagesetPeer::getOMClass();

					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					ImagesetPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addMyTask($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(MyTaskPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MyTaskPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(MyTaskPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
		$criteria->addJoin(array(MyTaskPeer::PC_ID,), array(PcPeer::ID,), $join_behavior);
		$criteria->addJoin(array(MyTaskPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);
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

		MyTaskPeer::addSelectColumns($c);
		$startcol2 = (MyTaskPeer::NUM_COLUMNS - MyTaskPeer::NUM_LAZY_LOAD_COLUMNS);

		OiimagesPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (OiimagesPeer::NUM_COLUMNS - OiimagesPeer::NUM_LAZY_LOAD_COLUMNS);

		PcPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (PcPeer::NUM_COLUMNS - PcPeer::NUM_LAZY_LOAD_COLUMNS);

		ImagesetPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + (ImagesetPeer::NUM_COLUMNS - ImagesetPeer::NUM_LAZY_LOAD_COLUMNS);

		$c->addJoin(array(MyTaskPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
		$c->addJoin(array(MyTaskPeer::PC_ID,), array(PcPeer::ID,), $join_behavior);
		$c->addJoin(array(MyTaskPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = MyTaskPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = MyTaskPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = MyTaskPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				MyTaskPeer::addInstanceToPool($obj1, $key1);
			} 
			
			$key2 = OiimagesPeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = OiimagesPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = OiimagesPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					OiimagesPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addMyTask($obj1);
			} 
			
			$key3 = PcPeer::getPrimaryKeyHashFromRow($row, $startcol3);
			if ($key3 !== null) {
				$obj3 = PcPeer::getInstanceFromPool($key3);
				if (!$obj3) {

					$omClass = PcPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					PcPeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addMyTask($obj1);
			} 
			
			$key4 = ImagesetPeer::getPrimaryKeyHashFromRow($row, $startcol4);
			if ($key4 !== null) {
				$obj4 = ImagesetPeer::getInstanceFromPool($key4);
				if (!$obj4) {

					$omClass = ImagesetPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					ImagesetPeer::addInstanceToPool($obj4, $key4);
				} 
								$obj4->addMyTask($obj1);
			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAllExceptOiimages(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MyTaskPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(MyTaskPeer::PC_ID,), array(PcPeer::ID,), $join_behavior);
				$criteria->addJoin(array(MyTaskPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinAllExceptPc(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MyTaskPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(MyTaskPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
				$criteria->addJoin(array(MyTaskPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinAllExceptImageset(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MyTaskPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(MyTaskPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
				$criteria->addJoin(array(MyTaskPeer::PC_ID,), array(PcPeer::ID,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinAllExceptOiimages(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MyTaskPeer::addSelectColumns($c);
		$startcol2 = (MyTaskPeer::NUM_COLUMNS - MyTaskPeer::NUM_LAZY_LOAD_COLUMNS);

		PcPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (PcPeer::NUM_COLUMNS - PcPeer::NUM_LAZY_LOAD_COLUMNS);

		ImagesetPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (ImagesetPeer::NUM_COLUMNS - ImagesetPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(MyTaskPeer::PC_ID,), array(PcPeer::ID,), $join_behavior);
				$c->addJoin(array(MyTaskPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = MyTaskPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = MyTaskPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = MyTaskPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				MyTaskPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = PcPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = PcPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = PcPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					PcPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addMyTask($obj1);

			} 
				
				$key3 = ImagesetPeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = ImagesetPeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$omClass = ImagesetPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					ImagesetPeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addMyTask($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinAllExceptPc(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MyTaskPeer::addSelectColumns($c);
		$startcol2 = (MyTaskPeer::NUM_COLUMNS - MyTaskPeer::NUM_LAZY_LOAD_COLUMNS);

		OiimagesPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (OiimagesPeer::NUM_COLUMNS - OiimagesPeer::NUM_LAZY_LOAD_COLUMNS);

		ImagesetPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (ImagesetPeer::NUM_COLUMNS - ImagesetPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(MyTaskPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
				$c->addJoin(array(MyTaskPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = MyTaskPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = MyTaskPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = MyTaskPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				MyTaskPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = OiimagesPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = OiimagesPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = OiimagesPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					OiimagesPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addMyTask($obj1);

			} 
				
				$key3 = ImagesetPeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = ImagesetPeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$omClass = ImagesetPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					ImagesetPeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addMyTask($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinAllExceptImageset(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		MyTaskPeer::addSelectColumns($c);
		$startcol2 = (MyTaskPeer::NUM_COLUMNS - MyTaskPeer::NUM_LAZY_LOAD_COLUMNS);

		OiimagesPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (OiimagesPeer::NUM_COLUMNS - OiimagesPeer::NUM_LAZY_LOAD_COLUMNS);

		PcPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (PcPeer::NUM_COLUMNS - PcPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(MyTaskPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
				$c->addJoin(array(MyTaskPeer::PC_ID,), array(PcPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = MyTaskPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = MyTaskPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = MyTaskPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				MyTaskPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = OiimagesPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = OiimagesPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = OiimagesPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					OiimagesPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addMyTask($obj1);

			} 
				
				$key3 = PcPeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = PcPeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$omClass = PcPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					PcPeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addMyTask($obj1);

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
		return MyTaskPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		if ($criteria->containsKey(MyTaskPeer::ID) && $criteria->keyContainsValue(MyTaskPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.MyTaskPeer::ID.')');
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
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(MyTaskPeer::ID);
			$selectCriteria->add(MyTaskPeer::ID, $criteria->remove(MyTaskPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; 		try {
									$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(MyTaskPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
												MyTaskPeer::clearInstancePool();

						$criteria = clone $values;
		} elseif ($values instanceof MyTask) {
						MyTaskPeer::removeInstanceFromPool($values);
						$criteria = $values->buildPkeyCriteria();
		} else {
			


			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MyTaskPeer::ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
								MyTaskPeer::removeInstanceFromPool($singleval);
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

	
	public static function doValidate(MyTask $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MyTaskPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MyTaskPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(MyTaskPeer::DATABASE_NAME, MyTaskPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = MyTaskPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = MyTaskPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(MyTaskPeer::DATABASE_NAME);
		$criteria->add(MyTaskPeer::ID, $pk);

		$v = MyTaskPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(MyTaskPeer::DATABASE_NAME);
			$criteria->add(MyTaskPeer::ID, $pks, Criteria::IN);
			$objs = MyTaskPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 

Propel::getDatabaseMap(BaseMyTaskPeer::DATABASE_NAME)->addTableBuilder(BaseMyTaskPeer::TABLE_NAME, BaseMyTaskPeer::getMapBuilder());

