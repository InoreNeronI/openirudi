<?php


abstract class BaseAsignImagesetPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'asign_imageset';

	
	const CLASS_DEFAULT = 'lib.model.AsignImageset';

	
	const NUM_COLUMNS = 7;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;

	
	const ID = 'asign_imageset.ID';

	
	const NAME = 'asign_imageset.NAME';

	
	const IMAGESET_ID = 'asign_imageset.IMAGESET_ID';

	
	const OIIMAGES_ID = 'asign_imageset.OIIMAGES_ID';

	
	const SIZE = 'asign_imageset.SIZE';

	
	const POSITION = 'asign_imageset.POSITION';

	
	const COLOR = 'asign_imageset.COLOR';

	
	public static $instances = array();

	
	private static $mapBuilder = null;

	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Name', 'ImagesetId', 'OiimagesId', 'Size', 'Position', 'Color', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'name', 'imagesetId', 'oiimagesId', 'size', 'position', 'color', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::NAME, self::IMAGESET_ID, self::OIIMAGES_ID, self::SIZE, self::POSITION, self::COLOR, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'name', 'imageset_id', 'oiimages_id', 'size', 'position', 'color', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Name' => 1, 'ImagesetId' => 2, 'OiimagesId' => 3, 'Size' => 4, 'Position' => 5, 'Color' => 6, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'name' => 1, 'imagesetId' => 2, 'oiimagesId' => 3, 'size' => 4, 'position' => 5, 'color' => 6, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::NAME => 1, self::IMAGESET_ID => 2, self::OIIMAGES_ID => 3, self::SIZE => 4, self::POSITION => 5, self::COLOR => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'name' => 1, 'imageset_id' => 2, 'oiimages_id' => 3, 'size' => 4, 'position' => 5, 'color' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new AsignImagesetMapBuilder();
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
		return str_replace(AsignImagesetPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(AsignImagesetPeer::ID);

		$criteria->addSelectColumn(AsignImagesetPeer::NAME);

		$criteria->addSelectColumn(AsignImagesetPeer::IMAGESET_ID);

		$criteria->addSelectColumn(AsignImagesetPeer::OIIMAGES_ID);

		$criteria->addSelectColumn(AsignImagesetPeer::SIZE);

		$criteria->addSelectColumn(AsignImagesetPeer::POSITION);

		$criteria->addSelectColumn(AsignImagesetPeer::COLOR);

	}

	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(AsignImagesetPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			AsignImagesetPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
		$objects = AsignImagesetPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return AsignImagesetPeer::populateObjects(AsignImagesetPeer::doSelectStmt($criteria, $con));
	}
	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			AsignImagesetPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

				return BasePeer::doSelect($criteria, $con);
	}
	
	public static function addInstanceToPool(AsignImageset $obj, $key = null)
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
			if (is_object($value) && $value instanceof AsignImageset) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
								$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or AsignImageset object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	
				$cls = AsignImagesetPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = AsignImagesetPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = AsignImagesetPeer::getInstanceFromPool($key))) {
																$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				AsignImagesetPeer::addInstanceToPool($obj, $key);
			} 		}
		$stmt->closeCursor();
		return $results;
	}

	
	public static function doCountJoinImageset(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(AsignImagesetPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			AsignImagesetPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(AsignImagesetPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinOiimages(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(AsignImagesetPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			AsignImagesetPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(AsignImagesetPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinImageset(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AsignImagesetPeer::addSelectColumns($c);
		$startcol = (AsignImagesetPeer::NUM_COLUMNS - AsignImagesetPeer::NUM_LAZY_LOAD_COLUMNS);
		ImagesetPeer::addSelectColumns($c);

		$c->addJoin(array(AsignImagesetPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = AsignImagesetPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = AsignImagesetPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = AsignImagesetPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				AsignImagesetPeer::addInstanceToPool($obj1, $key1);
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
								$obj2->addAsignImageset($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinOiimages(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AsignImagesetPeer::addSelectColumns($c);
		$startcol = (AsignImagesetPeer::NUM_COLUMNS - AsignImagesetPeer::NUM_LAZY_LOAD_COLUMNS);
		OiimagesPeer::addSelectColumns($c);

		$c->addJoin(array(AsignImagesetPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = AsignImagesetPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = AsignImagesetPeer::getInstanceFromPool($key1))) {
															} else {

				$omClass = AsignImagesetPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				AsignImagesetPeer::addInstanceToPool($obj1, $key1);
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
								$obj2->addAsignImageset($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(AsignImagesetPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			AsignImagesetPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(array(AsignImagesetPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);
		$criteria->addJoin(array(AsignImagesetPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
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

		AsignImagesetPeer::addSelectColumns($c);
		$startcol2 = (AsignImagesetPeer::NUM_COLUMNS - AsignImagesetPeer::NUM_LAZY_LOAD_COLUMNS);

		ImagesetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (ImagesetPeer::NUM_COLUMNS - ImagesetPeer::NUM_LAZY_LOAD_COLUMNS);

		OiimagesPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + (OiimagesPeer::NUM_COLUMNS - OiimagesPeer::NUM_LAZY_LOAD_COLUMNS);

		$c->addJoin(array(AsignImagesetPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);
		$c->addJoin(array(AsignImagesetPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = AsignImagesetPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = AsignImagesetPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = AsignImagesetPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				AsignImagesetPeer::addInstanceToPool($obj1, $key1);
			} 
			
			$key2 = ImagesetPeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = ImagesetPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$omClass = ImagesetPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					ImagesetPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addAsignImageset($obj1);
			} 
			
			$key3 = OiimagesPeer::getPrimaryKeyHashFromRow($row, $startcol3);
			if ($key3 !== null) {
				$obj3 = OiimagesPeer::getInstanceFromPool($key3);
				if (!$obj3) {

					$omClass = OiimagesPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					OiimagesPeer::addInstanceToPool($obj3, $key3);
				} 
								$obj3->addAsignImageset($obj1);
			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doCountJoinAllExceptImageset(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			AsignImagesetPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(AsignImagesetPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doCountJoinAllExceptOiimages(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
				$criteria = clone $criteria;

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			AsignImagesetPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 
				$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
				$criteria->addJoin(array(AsignImagesetPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}


	
	public static function doSelectJoinAllExceptImageset(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AsignImagesetPeer::addSelectColumns($c);
		$startcol2 = (AsignImagesetPeer::NUM_COLUMNS - AsignImagesetPeer::NUM_LAZY_LOAD_COLUMNS);

		OiimagesPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (OiimagesPeer::NUM_COLUMNS - OiimagesPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(AsignImagesetPeer::OIIMAGES_ID,), array(OiimagesPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = AsignImagesetPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = AsignImagesetPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = AsignImagesetPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				AsignImagesetPeer::addInstanceToPool($obj1, $key1);
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
								$obj2->addAsignImageset($obj1);

			} 
			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	
	public static function doSelectJoinAllExceptOiimages(Criteria $c, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		AsignImagesetPeer::addSelectColumns($c);
		$startcol2 = (AsignImagesetPeer::NUM_COLUMNS - AsignImagesetPeer::NUM_LAZY_LOAD_COLUMNS);

		ImagesetPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + (ImagesetPeer::NUM_COLUMNS - ImagesetPeer::NUM_LAZY_LOAD_COLUMNS);

				$c->addJoin(array(AsignImagesetPeer::IMAGESET_ID,), array(ImagesetPeer::ID,), $join_behavior);

		$stmt = BasePeer::doSelect($c, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = AsignImagesetPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = AsignImagesetPeer::getInstanceFromPool($key1))) {
															} else {
				$omClass = AsignImagesetPeer::getOMClass();

				$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
				$obj1 = new $cls();
				$obj1->hydrate($row);
				AsignImagesetPeer::addInstanceToPool($obj1, $key1);
			} 
				
				$key2 = ImagesetPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = ImagesetPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$omClass = ImagesetPeer::getOMClass();


					$cls = substr('.'.$omClass, strrpos('.'.$omClass, '.') + 1);
					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					ImagesetPeer::addInstanceToPool($obj2, $key2);
				} 
								$obj2->addAsignImageset($obj1);

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
		return AsignImagesetPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		if ($criteria->containsKey(AsignImagesetPeer::ID) && $criteria->keyContainsValue(AsignImagesetPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.AsignImagesetPeer::ID.')');
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
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(AsignImagesetPeer::ID);
			$selectCriteria->add(AsignImagesetPeer::ID, $criteria->remove(AsignImagesetPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; 		try {
									$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(AsignImagesetPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
												AsignImagesetPeer::clearInstancePool();

						$criteria = clone $values;
		} elseif ($values instanceof AsignImageset) {
						AsignImagesetPeer::removeInstanceFromPool($values);
						$criteria = $values->buildPkeyCriteria();
		} else {
			


			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(AsignImagesetPeer::ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
								AsignImagesetPeer::removeInstanceFromPool($singleval);
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

	
	public static function doValidate(AsignImageset $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(AsignImagesetPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(AsignImagesetPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(AsignImagesetPeer::DATABASE_NAME, AsignImagesetPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = AsignImagesetPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = AsignImagesetPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(AsignImagesetPeer::DATABASE_NAME);
		$criteria->add(AsignImagesetPeer::ID, $pk);

		$v = AsignImagesetPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(AsignImagesetPeer::DATABASE_NAME);
			$criteria->add(AsignImagesetPeer::ID, $pks, Criteria::IN);
			$objs = AsignImagesetPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 

Propel::getDatabaseMap(BaseAsignImagesetPeer::DATABASE_NAME)->addTableBuilder(BaseAsignImagesetPeer::TABLE_NAME, BaseAsignImagesetPeer::getMapBuilder());

