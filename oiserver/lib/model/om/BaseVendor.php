<?php


abstract class BaseVendor extends BaseObject  implements Persistent {


  const PEER = 'VendorPeer';

	
	protected static $peer;

	
	protected $code;

	
	protected $type_id;

	
	protected $name;

	
	protected $aType;

	
	protected $collDrivers;

	
	private $lastDriverCriteria = null;

	
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

	
	public function getCode()
	{
		return $this->code;
	}

	
	public function getTypeId()
	{
		return $this->type_id;
	}

	
	public function getName()
	{
		return $this->name;
	}

	
	public function setCode($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->code !== $v) {
			$this->code = $v;
			$this->modifiedColumns[] = VendorPeer::CODE;
		}

		return $this;
	} 
	
	public function setTypeId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->type_id !== $v) {
			$this->type_id = $v;
			$this->modifiedColumns[] = VendorPeer::TYPE_ID;
		}

		if ($this->aType !== null && $this->aType->getId() !== $v) {
			$this->aType = null;
		}

		return $this;
	} 
	
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = VendorPeer::NAME;
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

			$this->code = ($row[$startcol + 0] !== null) ? (string) $row[$startcol + 0] : null;
			$this->type_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Vendor object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aType !== null && $this->type_id !== $this->aType->getId()) {
			$this->aType = null;
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
			$con = Propel::getConnection(VendorPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = VendorPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aType = null;
			$this->collDrivers = null;
			$this->lastDriverCriteria = null;

			$this->collDevices = null;
			$this->lastDeviceCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(VendorPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			VendorPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(VendorPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			VendorPeer::addInstanceToPool($this);
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

												
			if ($this->aType !== null) {
				if ($this->aType->isModified() || $this->aType->isNew()) {
					$affectedRows += $this->aType->save($con);
				}
				$this->setType($this->aType);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = VendorPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += VendorPeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collDrivers !== null) {
				foreach ($this->collDrivers as $referrerFK) {
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


												
			if ($this->aType !== null) {
				if (!$this->aType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aType->getValidationFailures());
				}
			}


			if (($retval = VendorPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDrivers !== null) {
					foreach ($this->collDrivers as $referrerFK) {
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
		$pos = VendorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getCode();
				break;
			case 1:
				return $this->getTypeId();
				break;
			case 2:
				return $this->getName();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = VendorPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCode(),
			$keys[1] => $this->getTypeId(),
			$keys[2] => $this->getName(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = VendorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setCode($value);
				break;
			case 1:
				$this->setTypeId($value);
				break;
			case 2:
				$this->setName($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = VendorPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCode($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTypeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(VendorPeer::DATABASE_NAME);

		if ($this->isColumnModified(VendorPeer::CODE)) $criteria->add(VendorPeer::CODE, $this->code);
		if ($this->isColumnModified(VendorPeer::TYPE_ID)) $criteria->add(VendorPeer::TYPE_ID, $this->type_id);
		if ($this->isColumnModified(VendorPeer::NAME)) $criteria->add(VendorPeer::NAME, $this->name);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(VendorPeer::DATABASE_NAME);

		$criteria->add(VendorPeer::CODE, $this->code);
		$criteria->add(VendorPeer::TYPE_ID, $this->type_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getCode();

		$pks[1] = $this->getTypeId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setCode($keys[0]);

		$this->setTypeId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCode($this->code);

		$copyObj->setTypeId($this->type_id);

		$copyObj->setName($this->name);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getDrivers() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addDriver($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getDevices() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addDevice($relObj->copy($deepCopy));
				}
			}

		} 

		$copyObj->setNew(true);

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
			self::$peer = new VendorPeer();
		}
		return self::$peer;
	}

	
	public function setType(Type $v = null)
	{
		if ($v === null) {
			$this->setTypeId(NULL);
		} else {
			$this->setTypeId($v->getId());
		}

		$this->aType = $v;

						if ($v !== null) {
			$v->addVendor($this);
		}

		return $this;
	}


	
	public function getType(PropelPDO $con = null)
	{
		if ($this->aType === null && ($this->type_id !== null)) {
			$c = new Criteria(TypePeer::DATABASE_NAME);
			$c->add(TypePeer::ID, $this->type_id);
			$this->aType = TypePeer::doSelectOne($c, $con);
			
		}
		return $this->aType;
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
			$criteria = new Criteria(VendorPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDrivers === null) {
			if ($this->isNew()) {
			   $this->collDrivers = array();
			} else {

				$criteria->add(DriverPeer::VENDOR_ID, $this->code);

				DriverPeer::addSelectColumns($criteria);
				$this->collDrivers = DriverPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DriverPeer::VENDOR_ID, $this->code);

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
			$criteria = new Criteria(VendorPeer::DATABASE_NAME);
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

				$criteria->add(DriverPeer::VENDOR_ID, $this->code);

				$count = DriverPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DriverPeer::VENDOR_ID, $this->code);

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
			$l->setVendor($this);
		}
	}


	
	public function getDriversJoinType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(VendorPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDrivers === null) {
			if ($this->isNew()) {
				$this->collDrivers = array();
			} else {

				$criteria->add(DriverPeer::VENDOR_ID, $this->code);

				$this->collDrivers = DriverPeer::doSelectJoinType($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(DriverPeer::VENDOR_ID, $this->code);

			if (!isset($this->lastDriverCriteria) || !$this->lastDriverCriteria->equals($criteria)) {
				$this->collDrivers = DriverPeer::doSelectJoinType($criteria, $con, $join_behavior);
			}
		}
		$this->lastDriverCriteria = $criteria;

		return $this->collDrivers;
	}


	
	public function getDriversJoinDevice($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(VendorPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDrivers === null) {
			if ($this->isNew()) {
				$this->collDrivers = array();
			} else {

				$criteria->add(DriverPeer::VENDOR_ID, $this->code);

				$this->collDrivers = DriverPeer::doSelectJoinDevice($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(DriverPeer::VENDOR_ID, $this->code);

			if (!isset($this->lastDriverCriteria) || !$this->lastDriverCriteria->equals($criteria)) {
				$this->collDrivers = DriverPeer::doSelectJoinDevice($criteria, $con, $join_behavior);
			}
		}
		$this->lastDriverCriteria = $criteria;

		return $this->collDrivers;
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
			$criteria = new Criteria(VendorPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDevices === null) {
			if ($this->isNew()) {
			   $this->collDevices = array();
			} else {

				$criteria->add(DevicePeer::VENDOR_ID, $this->code);

				DevicePeer::addSelectColumns($criteria);
				$this->collDevices = DevicePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DevicePeer::VENDOR_ID, $this->code);

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
			$criteria = new Criteria(VendorPeer::DATABASE_NAME);
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

				$criteria->add(DevicePeer::VENDOR_ID, $this->code);

				$count = DevicePeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DevicePeer::VENDOR_ID, $this->code);

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
			$l->setVendor($this);
		}
	}


	
	public function getDevicesJoinType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(VendorPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDevices === null) {
			if ($this->isNew()) {
				$this->collDevices = array();
			} else {

				$criteria->add(DevicePeer::VENDOR_ID, $this->code);

				$this->collDevices = DevicePeer::doSelectJoinType($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(DevicePeer::VENDOR_ID, $this->code);

			if (!isset($this->lastDeviceCriteria) || !$this->lastDeviceCriteria->equals($criteria)) {
				$this->collDevices = DevicePeer::doSelectJoinType($criteria, $con, $join_behavior);
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
			if ($this->collDevices) {
				foreach ((array) $this->collDevices as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collDrivers = null;
		$this->collDevices = null;
			$this->aType = null;
	}

} 