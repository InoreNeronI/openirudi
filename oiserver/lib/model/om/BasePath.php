<?php


abstract class BasePath extends BaseObject  implements Persistent {


  const PEER = 'PathPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $driver_id;

	
	protected $path;

	
	protected $aDriver;

	
	protected $collPacks;

	
	private $lastPackCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	
	public function applyDefaultValues()
	{
	}

	
	public function getId()
	{
		return $this->id;
	}

	
	public function getDriverId()
	{
		return $this->driver_id;
	}

	
	public function getPath()
	{
		return $this->path;
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PathPeer::ID;
		}

		return $this;
	} 
	
	public function setDriverId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->driver_id !== $v) {
			$this->driver_id = $v;
			$this->modifiedColumns[] = PathPeer::DRIVER_ID;
		}

		if ($this->aDriver !== null && $this->aDriver->getId() !== $v) {
			$this->aDriver = null;
		}

		return $this;
	} 
	
	public function setPath($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->path !== $v) {
			$this->path = $v;
			$this->modifiedColumns[] = PathPeer::PATH;
		}

		return $this;
	} 
	
	public function hasOnlyDefaultValues()
	{
						if (array_diff($this->modifiedColumns, array())) {
				return false;
			}

				return true;
	} 
	
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->driver_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->path = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Path object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aDriver !== null && $this->driver_id !== $this->aDriver->getId()) {
			$this->aDriver = null;
		}
	} 
	
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PathPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = PathPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aDriver = null;
			$this->collPacks = null;
			$this->lastPackCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PathPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			PathPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PathPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			PathPeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

												
			if ($this->aDriver !== null) {
				if ($this->aDriver->isModified() || $this->aDriver->isNew()) {
					$affectedRows += $this->aDriver->save($con);
				}
				$this->setDriver($this->aDriver);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = PathPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PathPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += PathPeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collPacks !== null) {
				foreach ($this->collPacks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aDriver !== null) {
				if (!$this->aDriver->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDriver->getValidationFailures());
				}
			}


			if (($retval = PathPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPacks !== null) {
					foreach ($this->collPacks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PathPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getDriverId();
				break;
			case 2:
				return $this->getPath();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = PathPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getDriverId(),
			$keys[2] => $this->getPath(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PathPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setDriverId($value);
				break;
			case 2:
				$this->setPath($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = PathPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDriverId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPath($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(PathPeer::DATABASE_NAME);

		if ($this->isColumnModified(PathPeer::ID)) $criteria->add(PathPeer::ID, $this->id);
		if ($this->isColumnModified(PathPeer::DRIVER_ID)) $criteria->add(PathPeer::DRIVER_ID, $this->driver_id);
		if ($this->isColumnModified(PathPeer::PATH)) $criteria->add(PathPeer::PATH, $this->path);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(PathPeer::DATABASE_NAME);

		$criteria->add(PathPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setDriverId($this->driver_id);

		$copyObj->setPath($this->path);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getPacks() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addPack($relObj->copy($deepCopy));
				}
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PathPeer();
		}
		return self::$peer;
	}

	
	public function setDriver(Driver $v = null)
	{
		if ($v === null) {
			$this->setDriverId(NULL);
		} else {
			$this->setDriverId($v->getId());
		}

		$this->aDriver = $v;

						if ($v !== null) {
			$v->addPath($this);
		}

		return $this;
	}


	
	public function getDriver(PropelPDO $con = null)
	{
		if ($this->aDriver === null && ($this->driver_id !== null)) {
			$c = new Criteria(DriverPeer::DATABASE_NAME);
			$c->add(DriverPeer::ID, $this->driver_id);
			$this->aDriver = DriverPeer::doSelectOne($c, $con);
			
		}
		return $this->aDriver;
	}

	
	public function clearPacks()
	{
		$this->collPacks = null; 	}

	
	public function initPacks()
	{
		$this->collPacks = array();
	}

	
	public function getPacks($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PathPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPacks === null) {
			if ($this->isNew()) {
			   $this->collPacks = array();
			} else {

				$criteria->add(PackPeer::PATH_ID, $this->id);

				PackPeer::addSelectColumns($criteria);
				$this->collPacks = PackPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(PackPeer::PATH_ID, $this->id);

				PackPeer::addSelectColumns($criteria);
				if (!isset($this->lastPackCriteria) || !$this->lastPackCriteria->equals($criteria)) {
					$this->collPacks = PackPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPackCriteria = $criteria;
		return $this->collPacks;
	}

	
	public function countPacks(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PathPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPacks === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PackPeer::PATH_ID, $this->id);

				$count = PackPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(PackPeer::PATH_ID, $this->id);

				if (!isset($this->lastPackCriteria) || !$this->lastPackCriteria->equals($criteria)) {
					$count = PackPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collPacks);
				}
			} else {
				$count = count($this->collPacks);
			}
		}
		$this->lastPackCriteria = $criteria;
		return $count;
	}

	
	public function addPack(Pack $l)
	{
		if ($this->collPacks === null) {
			$this->initPacks();
		}
		if (!in_array($l, $this->collPacks, true)) { 			array_push($this->collPacks, $l);
			$l->setPath($this);
		}
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collPacks) {
				foreach ((array) $this->collPacks as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collPacks = null;
			$this->aDriver = null;
	}

} 