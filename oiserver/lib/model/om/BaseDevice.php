<?php


abstract class BaseDevice extends BaseObject  implements Persistent {


  const PEER = 'DevicePeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $code;

	
	protected $vendor_id;

	
	protected $type_id;

	
	protected $name;

	
	protected $aVendor;

	
	protected $aType;

	
	protected $collDrivers;

	
	private $lastDriverCriteria = null;

	
	protected $collSubsyss;

	
	private $lastSubsysCriteria = null;

	
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

	
	public function getCode()
	{
		return $this->code;
	}

	
	public function getVendorId()
	{
		return $this->vendor_id;
	}

	
	public function getTypeId()
	{
		return $this->type_id;
	}

	
	public function getName()
	{
		return $this->name;
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = DevicePeer::ID;
		}

		return $this;
	} 
	
	public function setCode($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->code !== $v) {
			$this->code = $v;
			$this->modifiedColumns[] = DevicePeer::CODE;
		}

		return $this;
	} 
	
	public function setVendorId($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->vendor_id !== $v) {
			$this->vendor_id = $v;
			$this->modifiedColumns[] = DevicePeer::VENDOR_ID;
		}

		if ($this->aVendor !== null && $this->aVendor->getCode() !== $v) {
			$this->aVendor = null;
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
			$this->modifiedColumns[] = DevicePeer::TYPE_ID;
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
			$this->modifiedColumns[] = DevicePeer::NAME;
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
			$this->code = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->vendor_id = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->type_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->name = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Device object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aVendor !== null && $this->vendor_id !== $this->aVendor->getCode()) {
			$this->aVendor = null;
		}
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
			$con = Propel::getConnection(DevicePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = DevicePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aVendor = null;
			$this->aType = null;
			$this->collDrivers = null;
			$this->lastDriverCriteria = null;

			$this->collSubsyss = null;
			$this->lastSubsysCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DevicePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			DevicePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(DevicePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			DevicePeer::addInstanceToPool($this);
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

												
			if ($this->aVendor !== null) {
				if ($this->aVendor->isModified() || $this->aVendor->isNew()) {
					$affectedRows += $this->aVendor->save($con);
				}
				$this->setVendor($this->aVendor);
			}

			if ($this->aType !== null) {
				if ($this->aType->isModified() || $this->aType->isNew()) {
					$affectedRows += $this->aType->save($con);
				}
				$this->setType($this->aType);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = DevicePeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DevicePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += DevicePeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collDrivers !== null) {
				foreach ($this->collDrivers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collSubsyss !== null) {
				foreach ($this->collSubsyss as $referrerFK) {
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


												
			if ($this->aVendor !== null) {
				if (!$this->aVendor->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aVendor->getValidationFailures());
				}
			}

			if ($this->aType !== null) {
				if (!$this->aType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aType->getValidationFailures());
				}
			}


			if (($retval = DevicePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDrivers !== null) {
					foreach ($this->collDrivers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collSubsyss !== null) {
					foreach ($this->collSubsyss as $referrerFK) {
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
		$pos = DevicePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCode();
				break;
			case 2:
				return $this->getVendorId();
				break;
			case 3:
				return $this->getTypeId();
				break;
			case 4:
				return $this->getName();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = DevicePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCode(),
			$keys[2] => $this->getVendorId(),
			$keys[3] => $this->getTypeId(),
			$keys[4] => $this->getName(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DevicePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCode($value);
				break;
			case 2:
				$this->setVendorId($value);
				break;
			case 3:
				$this->setTypeId($value);
				break;
			case 4:
				$this->setName($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = DevicePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCode($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setVendorId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTypeId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setName($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(DevicePeer::DATABASE_NAME);

		if ($this->isColumnModified(DevicePeer::ID)) $criteria->add(DevicePeer::ID, $this->id);
		if ($this->isColumnModified(DevicePeer::CODE)) $criteria->add(DevicePeer::CODE, $this->code);
		if ($this->isColumnModified(DevicePeer::VENDOR_ID)) $criteria->add(DevicePeer::VENDOR_ID, $this->vendor_id);
		if ($this->isColumnModified(DevicePeer::TYPE_ID)) $criteria->add(DevicePeer::TYPE_ID, $this->type_id);
		if ($this->isColumnModified(DevicePeer::NAME)) $criteria->add(DevicePeer::NAME, $this->name);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(DevicePeer::DATABASE_NAME);

		$criteria->add(DevicePeer::ID, $this->id);

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

		$copyObj->setCode($this->code);

		$copyObj->setVendorId($this->vendor_id);

		$copyObj->setTypeId($this->type_id);

		$copyObj->setName($this->name);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getDrivers() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addDriver($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getSubsyss() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addSubsys($relObj->copy($deepCopy));
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
			self::$peer = new DevicePeer();
		}
		return self::$peer;
	}

	
	public function setVendor(Vendor $v = null)
	{
		if ($v === null) {
			$this->setVendorId(NULL);
		} else {
			$this->setVendorId($v->getCode());
		}

		$this->aVendor = $v;

						if ($v !== null) {
			$v->addDevice($this);
		}

		return $this;
	}


	
	public function getVendor(PropelPDO $con = null)
	{
		if ($this->aVendor === null && (($this->vendor_id !== "" && $this->vendor_id !== null))) {
			$c = new Criteria(VendorPeer::DATABASE_NAME);
			$c->add(VendorPeer::CODE, $this->vendor_id);
			$this->aVendor = VendorPeer::doSelectOne($c, $con);
			
		}
		return $this->aVendor;
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
			$v->addDevice($this);
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
			$criteria = new Criteria(DevicePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDrivers === null) {
			if ($this->isNew()) {
			   $this->collDrivers = array();
			} else {

				$criteria->add(DriverPeer::DEVICE_ID, $this->code);

				DriverPeer::addSelectColumns($criteria);
				$this->collDrivers = DriverPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DriverPeer::DEVICE_ID, $this->code);

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
			$criteria = new Criteria(DevicePeer::DATABASE_NAME);
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

				$criteria->add(DriverPeer::DEVICE_ID, $this->code);

				$count = DriverPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(DriverPeer::DEVICE_ID, $this->code);

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
			$l->setDevice($this);
		}
	}


	
	public function getDriversJoinType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DevicePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDrivers === null) {
			if ($this->isNew()) {
				$this->collDrivers = array();
			} else {

				$criteria->add(DriverPeer::DEVICE_ID, $this->code);

				$this->collDrivers = DriverPeer::doSelectJoinType($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(DriverPeer::DEVICE_ID, $this->code);

			if (!isset($this->lastDriverCriteria) || !$this->lastDriverCriteria->equals($criteria)) {
				$this->collDrivers = DriverPeer::doSelectJoinType($criteria, $con, $join_behavior);
			}
		}
		$this->lastDriverCriteria = $criteria;

		return $this->collDrivers;
	}


	
	public function getDriversJoinVendor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DevicePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDrivers === null) {
			if ($this->isNew()) {
				$this->collDrivers = array();
			} else {

				$criteria->add(DriverPeer::DEVICE_ID, $this->code);

				$this->collDrivers = DriverPeer::doSelectJoinVendor($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(DriverPeer::DEVICE_ID, $this->code);

			if (!isset($this->lastDriverCriteria) || !$this->lastDriverCriteria->equals($criteria)) {
				$this->collDrivers = DriverPeer::doSelectJoinVendor($criteria, $con, $join_behavior);
			}
		}
		$this->lastDriverCriteria = $criteria;

		return $this->collDrivers;
	}

	
	public function clearSubsyss()
	{
		$this->collSubsyss = null; 	}

	
	public function initSubsyss()
	{
		$this->collSubsyss = array();
	}

	
	public function getSubsyss($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DevicePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSubsyss === null) {
			if ($this->isNew()) {
			   $this->collSubsyss = array();
			} else {

				$criteria->add(SubsysPeer::DEVICE_ID, $this->id);

				SubsysPeer::addSelectColumns($criteria);
				$this->collSubsyss = SubsysPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SubsysPeer::DEVICE_ID, $this->id);

				SubsysPeer::addSelectColumns($criteria);
				if (!isset($this->lastSubsysCriteria) || !$this->lastSubsysCriteria->equals($criteria)) {
					$this->collSubsyss = SubsysPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSubsysCriteria = $criteria;
		return $this->collSubsyss;
	}

	
	public function countSubsyss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DevicePeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collSubsyss === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(SubsysPeer::DEVICE_ID, $this->id);

				$count = SubsysPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SubsysPeer::DEVICE_ID, $this->id);

				if (!isset($this->lastSubsysCriteria) || !$this->lastSubsysCriteria->equals($criteria)) {
					$count = SubsysPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collSubsyss);
				}
			} else {
				$count = count($this->collSubsyss);
			}
		}
		$this->lastSubsysCriteria = $criteria;
		return $count;
	}

	
	public function addSubsys(Subsys $l)
	{
		if ($this->collSubsyss === null) {
			$this->initSubsyss();
		}
		if (!in_array($l, $this->collSubsyss, true)) { 			array_push($this->collSubsyss, $l);
			$l->setDevice($this);
		}
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collDrivers) {
				foreach ((array) $this->collDrivers as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collSubsyss) {
				foreach ((array) $this->collSubsyss as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collDrivers = null;
		$this->collSubsyss = null;
			$this->aVendor = null;
			$this->aType = null;
	}

} 