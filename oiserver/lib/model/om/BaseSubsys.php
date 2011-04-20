<?php


abstract class BaseSubsys extends BaseObject  implements Persistent {


  const PEER = 'SubsysPeer';

	
	protected static $peer;

	
	protected $code;

	
	protected $device_id;

	
	protected $revision;

	
	protected $name;

	
	protected $aDevice;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	
	public function applyDefaultValues()
	{
		$this->revision = '00';
	}

	
	public function getCode()
	{
		return $this->code;
	}

	
	public function getDeviceId()
	{
		return $this->device_id;
	}

	
	public function getRevision()
	{
		return $this->revision;
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
			$this->modifiedColumns[] = SubsysPeer::CODE;
		}

		return $this;
	} 
	
	public function setDeviceId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->device_id !== $v) {
			$this->device_id = $v;
			$this->modifiedColumns[] = SubsysPeer::DEVICE_ID;
		}

		if ($this->aDevice !== null && $this->aDevice->getId() !== $v) {
			$this->aDevice = null;
		}

		return $this;
	} 
	
	public function setRevision($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->revision !== $v || $v === '00') {
			$this->revision = $v;
			$this->modifiedColumns[] = SubsysPeer::REVISION;
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
			$this->modifiedColumns[] = SubsysPeer::NAME;
		}

		return $this;
	} 
	
	public function hasOnlyDefaultValues()
	{
						if (array_diff($this->modifiedColumns, array(SubsysPeer::REVISION))) {
				return false;
			}

			if ($this->revision !== '00') {
				return false;
			}

				return true;
	} 
	
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->code = ($row[$startcol + 0] !== null) ? (string) $row[$startcol + 0] : null;
			$this->device_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->revision = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Subsys object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aDevice !== null && $this->device_id !== $this->aDevice->getId()) {
			$this->aDevice = null;
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
			$con = Propel::getConnection(SubsysPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = SubsysPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aDevice = null;
		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SubsysPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			SubsysPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(SubsysPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			SubsysPeer::addInstanceToPool($this);
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

												
			if ($this->aDevice !== null) {
				if ($this->aDevice->isModified() || $this->aDevice->isNew()) {
					$affectedRows += $this->aDevice->save($con);
				}
				$this->setDevice($this->aDevice);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = SubsysPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += SubsysPeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

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


												
			if ($this->aDevice !== null) {
				if (!$this->aDevice->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDevice->getValidationFailures());
				}
			}


			if (($retval = SubsysPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SubsysPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getDeviceId();
				break;
			case 2:
				return $this->getRevision();
				break;
			case 3:
				return $this->getName();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = SubsysPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCode(),
			$keys[1] => $this->getDeviceId(),
			$keys[2] => $this->getRevision(),
			$keys[3] => $this->getName(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SubsysPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setCode($value);
				break;
			case 1:
				$this->setDeviceId($value);
				break;
			case 2:
				$this->setRevision($value);
				break;
			case 3:
				$this->setName($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SubsysPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCode($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDeviceId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setRevision($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SubsysPeer::DATABASE_NAME);

		if ($this->isColumnModified(SubsysPeer::CODE)) $criteria->add(SubsysPeer::CODE, $this->code);
		if ($this->isColumnModified(SubsysPeer::DEVICE_ID)) $criteria->add(SubsysPeer::DEVICE_ID, $this->device_id);
		if ($this->isColumnModified(SubsysPeer::REVISION)) $criteria->add(SubsysPeer::REVISION, $this->revision);
		if ($this->isColumnModified(SubsysPeer::NAME)) $criteria->add(SubsysPeer::NAME, $this->name);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SubsysPeer::DATABASE_NAME);

		$criteria->add(SubsysPeer::CODE, $this->code);
		$criteria->add(SubsysPeer::DEVICE_ID, $this->device_id);
		$criteria->add(SubsysPeer::REVISION, $this->revision);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getCode();

		$pks[1] = $this->getDeviceId();

		$pks[2] = $this->getRevision();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setCode($keys[0]);

		$this->setDeviceId($keys[1]);

		$this->setRevision($keys[2]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCode($this->code);

		$copyObj->setDeviceId($this->device_id);

		$copyObj->setRevision($this->revision);

		$copyObj->setName($this->name);


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
			self::$peer = new SubsysPeer();
		}
		return self::$peer;
	}

	
	public function setDevice(Device $v = null)
	{
		if ($v === null) {
			$this->setDeviceId(NULL);
		} else {
			$this->setDeviceId($v->getId());
		}

		$this->aDevice = $v;

						if ($v !== null) {
			$v->addSubsys($this);
		}

		return $this;
	}


	
	public function getDevice(PropelPDO $con = null)
	{
		if ($this->aDevice === null && ($this->device_id !== null)) {
			$c = new Criteria(DevicePeer::DATABASE_NAME);
			$c->add(DevicePeer::ID, $this->device_id);
			$this->aDevice = DevicePeer::doSelectOne($c, $con);
			
		}
		return $this->aDevice;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} 
			$this->aDevice = null;
	}

} 