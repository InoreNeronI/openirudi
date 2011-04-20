<?php


abstract class BaseOiimagesPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'oiimages';

	
	const CLASS_DEFAULT = 'lib.model.Oiimages';

	
	const NUM_COLUMNS = 12;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;

	
	const ID = 'oiimages.ID';

	
	const REF = 'oiimages.REF';

	
	const NAME = 'oiimages.NAME';

	
	const DESCRIPTION = 'oiimages.DESCRIPTION';

	
	const OS = 'oiimages.OS';

	
	const UUID = 'oiimages.UUID';

	
	const CREATED_AT = 'oiimages.CREATED_AT';

	
	const PARTITION_SIZE = 'oiimages.PARTITION_SIZE';

	
	const PARTITION_TYPE = 'oiimages.PARTITION_TYPE';

	
	const FILESYSTEM_SIZE = 'oiimages.FILESYSTEM_SIZE';

	
	const FILESYSTEM_TYPE = 'oiimages.FILESYSTEM_TYPE';

	
	const PATH = 'oiimages.PATH';

	
	public static $instances = array();

	
	private static $mapBuilder = null;

	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Ref', 'Name', 'Description', 'Os', 'Uuid', 'CreatedAt', 'PartitionSize', 'PartitionType', 'FilesystemSize', 'FilesystemType', 'Path', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'ref', 'name', 'description', 'os', 'uuid', 'createdAt', 'partitionSize', 'partitionType', 'filesystemSize', 'filesystemType', 'path', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::REF, self::NAME, self::DESCRIPTION, self::OS, self::UUID, self::CREATED_AT, self::PARTITION_SIZE, self::PARTITION_TYPE, self::FILESYSTEM_SIZE, self::FILESYSTEM_TYPE, self::PATH, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'ref', 'name', 'description', 'os', 'uuid', 'created_at', 'partition_size', 'partition_type', 'filesystem_size', 'filesystem_type', 'path', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Ref' => 1, 'Name' => 2, 'Description' => 3, 'Os' => 4, 'Uuid' => 5, 'CreatedAt' => 6, 'PartitionSize' => 7, 'PartitionType' => 8, 'FilesystemSize' => 9, 'FilesystemType' => 10, 'Path' => 11, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'ref' => 1, 'name' => 2, 'description' => 3, 'os' => 4, 'uuid' => 5, 'createdAt' => 6, 'partitionSize' => 7, 'partitionType' => 8, 'filesystemSize' => 9, 'filesystemType' => 10, 'path' => 11, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::REF => 1, self::NAME => 2, self::DESCRIPTION => 3, self::OS => 4, self::UUID => 5, self::CREATED_AT => 6, self::PARTITION_SIZE => 7, self::PARTITION_TYPE => 8, self::FILESYSTEM_SIZE => 9, self::FILESYSTEM_TYPE => 10, self::PATH => 11, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'ref' => 1, 'name' => 2, 'description' => 3, 'os' => 4, 'uuid' => 5, 'created_at' => 6, 'partition_size' => 7, 'partition_type' => 8, 'filesystem_size' => 9, 'filesystem_type' => 10, 'path' => 11, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
	);

	
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new OiimagesMapBuilder();
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
		return str_replace(OiimagesPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OiimagesPeer::ID);

		$criteria->addSelectColumn(OiimagesPeer::REF);

		$criteria->addSelectColumn(OiimagesPeer::NAME);

		$criteria->addSelectColumn(OiimagesPeer::DESCRIPTION);

		$criteria->addSelectColumn(OiimagesPeer::OS);

		$criteria->addSelectColumn(OiimagesPeer::UUID);

		$criteria->addSelectColumn(OiimagesPeer::CREATED_AT);

		$criteria->addSelectColumn(OiimagesPeer::PARTITION_SIZE);

		$criteria->addSelectColumn(OiimagesPeer::PARTITION_TYPE);

		$criteria->addSelectColumn(OiimagesPeer::FILESYSTEM_SIZE);

		$criteria->addSelectColumn(OiimagesPeer::FILESYSTEM_TYPE);

		$criteria->addSelectColumn(OiimagesPeer::PATH);

	}

	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(OiimagesPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			OiimagesPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
		$objects = OiimagesPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return OiimagesPeer::populateObjects(OiimagesPeer::doSelectStmt($criteria, $con));
	}
	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			OiimagesPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

				return BasePeer::doSelect($criteria, $con);
	}
	
	public static function addInstanceToPool(Oiimages $obj, $key = null)
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
			if (is_object($value) && $value instanceof Oiimages) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
								$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Oiimages object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	
				$cls = OiimagesPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = OiimagesPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = OiimagesPeer::getInstanceFromPool($key))) {
																$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				OiimagesPeer::addInstanceToPool($obj, $key);
			} 		}
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
		return OiimagesPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		if ($criteria->containsKey(OiimagesPeer::ID) && $criteria->keyContainsValue(OiimagesPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.OiimagesPeer::ID.')');
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
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(OiimagesPeer::ID);
			$selectCriteria->add(OiimagesPeer::ID, $criteria->remove(OiimagesPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; 		try {
									$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(OiimagesPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
												OiimagesPeer::clearInstancePool();

						$criteria = clone $values;
		} elseif ($values instanceof Oiimages) {
						OiimagesPeer::removeInstanceFromPool($values);
						$criteria = $values->buildPkeyCriteria();
		} else {
			


			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(OiimagesPeer::ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
								OiimagesPeer::removeInstanceFromPool($singleval);
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

	
	public static function doValidate(Oiimages $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OiimagesPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OiimagesPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OiimagesPeer::DATABASE_NAME, OiimagesPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OiimagesPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = OiimagesPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);
		$criteria->add(OiimagesPeer::ID, $pk);

		$v = OiimagesPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);
			$criteria->add(OiimagesPeer::ID, $pks, Criteria::IN);
			$objs = OiimagesPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 

Propel::getDatabaseMap(BaseOiimagesPeer::DATABASE_NAME)->addTableBuilder(BaseOiimagesPeer::TABLE_NAME, BaseOiimagesPeer::getMapBuilder());

