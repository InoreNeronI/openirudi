<?php


abstract class BaseType extends BaseObject  implements Persistent {


  const PEER = 'TypePeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $type;

	
	protected $collDrivers;

	
	private $lastDriverCriteria = null;

	
	protected $collVendors;

	
	private $lastVendorCriteria = null;

	
	protected $collDevices;

	
	private $lastDeviceCriteria = null;

	
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

	
	public function getType()
	{
		return $this->type;
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = TypePeer::ID;
		}

		return $this;
	} 
	
	public function setType($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->type !== $v) {
			$this->type = $v;
			$this->modifiedColumns[] = TypePeer::TYPE;
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
			$this->type = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Type object", $e);
		}
	}

	
	public function ensureConsistency()
	{

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
			$con = Propel::getConnection(TypePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = TypePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->collDrivers = null;
			$this->lastDriverCriteria = null;

			$this->collVendors = null;
			$this->lastVendorCriteria = null;

			$this->collDevices = null;
			$this->lastDeviceCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TypePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			TypePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(TypePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			TypePeer::addInstanceToPool($this);
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

			if ($this->isNew() ) {
				$this->modifiedColumns[] = TypePeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TypePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TypePeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collDrivers !== null) {
				foreach ($this->collDrivers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collVendors !== null) {
				foreach ($this->collVendors as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDevices !== null) {
				foreach ($this->collDevices as $referrerFK) {
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


			if (($retval = TypePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDrivers !== null) {
					foreach ($this->collDrivers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collVendors !== null) {
					foreach ($this->collVendors as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDevices !== null) {
					foreach ($this->collDevices as $referrerFK) {
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
		$pos = TypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getType();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = TypePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getType(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setType($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TypePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setType($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TypePeer::DATABASE_NAME);

		if ($this->isColumnModified(TypePeer::ID)) $criteria->add(TypePeer::ID, $this->id);
		if ($this->isColumnModified(TypePeer::TYPE)) $criteria->add(TypePeer::TYPE, $this->type);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TypePeer::DATABASE_NAME);

		$criteria->add(TypePeer::ID, $this->id);

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

		$copyObj->setType($this->type);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getDrivers() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addDriver($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getVendors() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addVendor($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getDevices() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addDevice($relObj->copy($deepCopy));
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
			self::$peer = new TypePeer();
		}
		return self::$peer;
	}

	
	public function clearDrivers()
	{
		$this->collDrivers = null; 	}

	
	public function initDrivers()
	{
		$this->collDrivers = array();
	}

	
	public function getDrivers($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(TypePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDrivers === null) {
			if ($this->isNew()) {
			   $this->collDrivers = array();
			} else {

				$criteria->add(DriverPeer::TYPE_ID, $this->id);

				DriverPeer::addSelectColumns($criteria);
				$this->collDrivers = DriverPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DriverPeer::TYPE_ID, $this->id);

				DriverPeer::addSelectColumns($criteria);
				if (!isset($this->lastDriverCriteria) || !$this->lastDriverCriteria->equals($criteria)) {
					$this->collDrivers = DriverPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDriverCriteria = $criteria;
		return $this->collDrivers;
	}

	
	public function countDrivers(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(TypePeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collDrivers === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(DriverPeer::TYPE_ID, $this->id);

				$count = DriverPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DriverPeer::TYPE_ID, $this->id);

				if (!isset($this->lastDriverCriteria) || !$this->lastDriverCriteria->equals($criteria)) {
					$count = DriverPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collDrivers);
				}
			} else {
				$count = count($this->collDrivers);
			}
		}
		$this->lastDriverCriteria = $criteria;
		return $count;
	}

	
	public function addDriver(Driver $l)
	{
		if ($this->collDrivers === null) {
			$this->initDrivers();
		}
		if (!in_array($l, $this->collDrivers, true)) { 			array_push($this->collDrivers, $l);
			$l->setType($this);
		}
	}


	
	public function getDriversJoinVendor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(TypePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDrivers === null) {
			if ($this->isNew()) {
				$this->collDrivers = array();
			} else {

				$criteria->add(DriverPeer::TYPE_ID, $this->id);

				$this->collDrivers = DriverPeer::doSelectJoinVendor($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(DriverPeer::TYPE_ID, $this->id);

			if (!isset($this->lastDriverCriteria) || !$this->lastDriverCriteria->equals($criteria)) {
				$this->collDrivers = DriverPeer::doSelectJoinVendor($criteria, $con, $join_behavior);
			}
		}
		$this->lastDriverCriteria = $criteria;

		return $this->collDrivers;
	}


	
	public function getDriversJoinDevice($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(TypePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDrivers === null) {
			if ($this->isNew()) {
				$this->collDrivers = array();
			} else {

				$criteria->add(DriverPeer::TYPE_ID, $this->id);

				$this->collDrivers = DriverPeer::doSelectJoinDevice($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(DriverPeer::TYPE_ID, $this->id);

			if (!isset($this->lastDriverCriteria) || !$this->lastDriverCriteria->equals($criteria)) {
				$this->collDrivers = DriverPeer::doSelectJoinDevice($criteria, $con, $join_behavior);
			}
		}
		$this->lastDriverCriteria = $criteria;

		return $this->collDrivers;
	}

	
	public function clearVendors()
	{
		$this->collVendors = null; 	}

	
	public function initVendors()
	{
		$this->collVendors = array();
	}

	
	public function getVendors($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(TypePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collVendors === null) {
			if ($this->isNew()) {
			   $this->collVendors = array();
			} else {

				$criteria->add(VendorPeer::TYPE_ID, $this->id);

				VendorPeer::addSelectColumns($criteria);
				$this->collVendors = VendorPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(VendorPeer::TYPE_ID, $this->id);

				VendorPeer::addSelectColumns($criteria);
				if (!isset($this->lastVendorCriteria) || !$this->lastVendorCriteria->equals($criteria)) {
					$this->collVendors = VendorPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastVendorCriteria = $criteria;
		return $this->collVendors;
	}

	
	public function countVendors(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(TypePeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collVendors === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(VendorPeer::TYPE_ID, $this->id);

				$count = VendorPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(VendorPeer::TYPE_ID, $this->id);

				if (!isset($this->lastVendorCriteria) || !$this->lastVendorCriteria->equals($criteria)) {
					$count = VendorPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collVendors);
				}
			} else {
				$count = count($this->collVendors);
			}
		}
		$this->lastVendorCriteria = $criteria;
		return $count;
	}

	
	public function addVendor(Vendor $l)
	{
		if ($this->collVendors === null) {
			$this->initVendors();
		}
		if (!in_array($l, $this->collVendors, true)) { 			array_push($this->collVendors, $l);
			$l->setType($this);
		}
	}

	
	public function clearDevices()
	{
		$this->collDevices = null; 	}

	
	public function initDevices()
	{
		$this->collDevices = array();
	}

	
	public function getDevices($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(TypePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDevices === null) {
			if ($this->isNew()) {
			   $this->collDevices = array();
			} else {

				$criteria->add(DevicePeer::TYPE_ID, $this->id);

				DevicePeer::addSelectColumns($criteria);
				$this->collDevices = DevicePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DevicePeer::TYPE_ID, $this->id);

				DevicePeer::addSelectColumns($criteria);
				if (!isset($this->lastDeviceCriteria) || !$this->lastDeviceCriteria->equals($criteria)) {
					$this->collDevices = DevicePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDeviceCriteria = $criteria;
		return $this->collDevices;
	}

	
	public function countDevices(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(TypePeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collDevices === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(DevicePeer::TYPE_ID, $this->id);

				$count = DevicePeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DevicePeer::TYPE_ID, $this->id);

				if (!isset($this->lastDeviceCriteria) || !$this->lastDeviceCriteria->equals($criteria)) {
					$count = DevicePeer::doCount($criteria, $con);
				} else {
					$count = count($this->collDevices);
				}
			} else {
				$count = count($this->collDevices);
			}
		}
		$this->lastDeviceCriteria = $criteria;
		return $count;
	}

	
	public function addDevice(Device $l)
	{
		if ($this->collDevices === null) {
			$this->initDevices();
		}
		if (!in_array($l, $this->collDevices, true)) { 			array_push($this->collDevices, $l);
			$l->setType($this);
		}
	}


	
	public function getDevicesJoinVendor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(TypePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDevices === null) {
			if ($this->isNew()) {
				$this->collDevices = array();
			} else {

				$criteria->add(DevicePeer::TYPE_ID, $this->id);

				$this->collDevices = DevicePeer::doSelectJoinVendor($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(DevicePeer::TYPE_ID, $this->id);

			if (!isset($this->lastDeviceCriteria) || !$this->lastDeviceCriteria->equals($criteria)) {
				$this->collDevices = DevicePeer::doSelectJoinVendor($criteria, $con, $join_behavior);
			}
		}
		$this->lastDeviceCriteria = $criteria;

		return $this->collDevices;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collDrivers) {
				foreach ((array) $this->collDrivers as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collVendors) {
				foreach ((array) $this->collVendors as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collDevices) {
				foreach ((array) $this->collDevices as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collDrivers = null;
		$this->collVendors = null;
		$this->collDevices = null;
	}

} 