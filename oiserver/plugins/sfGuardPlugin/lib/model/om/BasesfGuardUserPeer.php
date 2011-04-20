<?php


abstract class BasesfGuardUserPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_guard_user';

	
	const CLASS_DEFAULT = 'plugins.sfGuardPlugin.lib.model.sfGuardUser';

	
	const NUM_COLUMNS = 9;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;

	
	const ID = 'sf_guard_user.ID';

	
	const USERNAME = 'sf_guard_user.USERNAME';

	
	const ALGORITHM = 'sf_guard_user.ALGORITHM';

	
	const SALT = 'sf_guard_user.SALT';

	
	const PASSWORD = 'sf_guard_user.PASSWORD';

	
	const CREATED_AT = 'sf_guard_user.CREATED_AT';

	
	const LAST_LOGIN = 'sf_guard_user.LAST_LOGIN';

	
	const IS_ACTIVE = 'sf_guard_user.IS_ACTIVE';

	
	const IS_SUPER_ADMIN = 'sf_guard_user.IS_SUPER_ADMIN';

	
	public static $instances = array();

	
	private static $mapBuilder = null;

	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Username', 'Algorithm', 'Salt', 'Password', 'CreatedAt', 'LastLogin', 'IsActive', 'IsSuperAdmin', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'username', 'algorithm', 'salt', 'password', 'createdAt', 'lastLogin', 'isActive', 'isSuperAdmin', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::USERNAME, self::ALGORITHM, self::SALT, self::PASSWORD, self::CREATED_AT, self::LAST_LOGIN, self::IS_ACTIVE, self::IS_SUPER_ADMIN, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'username', 'algorithm', 'salt', 'password', 'created_at', 'last_login', 'is_active', 'is_super_admin', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Username' => 1, 'Algorithm' => 2, 'Salt' => 3, 'Password' => 4, 'CreatedAt' => 5, 'LastLogin' => 6, 'IsActive' => 7, 'IsSuperAdmin' => 8, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'username' => 1, 'algorithm' => 2, 'salt' => 3, 'password' => 4, 'createdAt' => 5, 'lastLogin' => 6, 'isActive' => 7, 'isSuperAdmin' => 8, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::USERNAME => 1, self::ALGORITHM => 2, self::SALT => 3, self::PASSWORD => 4, self::CREATED_AT => 5, self::LAST_LOGIN => 6, self::IS_ACTIVE => 7, self::IS_SUPER_ADMIN => 8, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'username' => 1, 'algorithm' => 2, 'salt' => 3, 'password' => 4, 'created_at' => 5, 'last_login' => 6, 'is_active' => 7, 'is_super_admin' => 8, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new sfGuardUserMapBuilder();
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
		return str_replace(sfGuardUserPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfGuardUserPeer::ID);

		$criteria->addSelectColumn(sfGuardUserPeer::USERNAME);

		$criteria->addSelectColumn(sfGuardUserPeer::ALGORITHM);

		$criteria->addSelectColumn(sfGuardUserPeer::SALT);

		$criteria->addSelectColumn(sfGuardUserPeer::PASSWORD);

		$criteria->addSelectColumn(sfGuardUserPeer::CREATED_AT);

		$criteria->addSelectColumn(sfGuardUserPeer::LAST_LOGIN);

		$criteria->addSelectColumn(sfGuardUserPeer::IS_ACTIVE);

		$criteria->addSelectColumn(sfGuardUserPeer::IS_SUPER_ADMIN);

	}

	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(sfGuardUserPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			sfGuardUserPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
		$objects = sfGuardUserPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return sfGuardUserPeer::populateObjects(sfGuardUserPeer::doSelectStmt($criteria, $con));
	}
	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			sfGuardUserPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

				return BasePeer::doSelect($criteria, $con);
	}
	
	public static function addInstanceToPool(sfGuardUser $obj, $key = null)
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
			if (is_object($value) && $value instanceof sfGuardUser) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
								$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or sfGuardUser object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	
				$cls = sfGuardUserPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = sfGuardUserPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = sfGuardUserPeer::getInstanceFromPool($key))) {
																$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				sfGuardUserPeer::addInstanceToPool($obj, $key);
			} 		}
		$stmt->closeCursor();
		return $results;
	}

  static public function getUniqueColumnNames()
  {
    return array(array('username'));
  }
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return sfGuardUserPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		if ($criteria->containsKey(sfGuardUserPeer::ID) && $criteria->keyContainsValue(sfGuardUserPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.sfGuardUserPeer::ID.')');
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
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(sfGuardUserPeer::ID);
			$selectCriteria->add(sfGuardUserPeer::ID, $criteria->remove(sfGuardUserPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; 		try {
									$con->beginTransaction();
			$affectedRows += sfGuardUserPeer::doOnDeleteCascade(new Criteria(sfGuardUserPeer::DATABASE_NAME), $con);
			$affectedRows += BasePeer::doDeleteAll(sfGuardUserPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
												sfGuardUserPeer::clearInstancePool();

						$criteria = clone $values;
		} elseif ($values instanceof sfGuardUser) {
						sfGuardUserPeer::removeInstanceFromPool($values);
						$criteria = $values->buildPkeyCriteria();
		} else {
			


			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfGuardUserPeer::ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
								sfGuardUserPeer::removeInstanceFromPool($singleval);
			}
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->beginTransaction();
			$affectedRows += sfGuardUserPeer::doOnDeleteCascade($criteria, $con);
			
																if ($values instanceof Criteria) {
					sfGuardUserPeer::clearInstancePool();
				} else { 					sfGuardUserPeer::removeInstanceFromPool($values);
				}
			
			$affectedRows += BasePeer::doDelete($criteria, $con);

						sfGuardUserPermissionPeer::clearInstancePool();

						sfGuardUserGroupPeer::clearInstancePool();

						sfGuardRememberKeyPeer::clearInstancePool();

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

				$objects = sfGuardUserPeer::doSelect($criteria, $con);
		foreach ($objects as $obj) {


						$c = new Criteria(sfGuardUserPermissionPeer::DATABASE_NAME);
			
			$c->add(sfGuardUserPermissionPeer::USER_ID, $obj->getId());
			$affectedRows += sfGuardUserPermissionPeer::doDelete($c, $con);

						$c = new Criteria(sfGuardUserGroupPeer::DATABASE_NAME);
			
			$c->add(sfGuardUserGroupPeer::USER_ID, $obj->getId());
			$affectedRows += sfGuardUserGroupPeer::doDelete($c, $con);

						$c = new Criteria(sfGuardRememberKeyPeer::DATABASE_NAME);
			
			$c->add(sfGuardRememberKeyPeer::USER_ID, $obj->getId());
			$affectedRows += sfGuardRememberKeyPeer::doDelete($c, $con);
		}
		return $affectedRows;
	}

	
	public static function doValidate(sfGuardUser $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfGuardUserPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfGuardUserPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(sfGuardUserPeer::DATABASE_NAME, sfGuardUserPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfGuardUserPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = sfGuardUserPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);
		$criteria->add(sfGuardUserPeer::ID, $pk);

		$v = sfGuardUserPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(sfGuardUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(sfGuardUserPeer::DATABASE_NAME);
			$criteria->add(sfGuardUserPeer::ID, $pks, Criteria::IN);
			$objs = sfGuardUserPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 

Propel::getDatabaseMap(BasesfGuardUserPeer::DATABASE_NAME)->addTableBuilder(BasesfGuardUserPeer::TABLE_NAME, BasesfGuardUserPeer::getMapBuilder());

