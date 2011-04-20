<?php


abstract class BaseDriver extends BaseObject  implements Persistent {


  const PEER = 'DriverPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $type_id;

	
	protected $vendor_id;

	
	protected $device_id;

	
	protected $class_type;

	
	protected $name;

	
	protected $date;

	
	protected $string;

	
	protected $url;

	
	protected $created_at;

	
	protected $aType;

	
	protected $aVendor;

	
	protected $aDevice;

	
	protected $collSystems;

	
	private $lastSystemCriteria = null;

	
	protected $collPaths;

	
	private $lastPathCriteria = null;

	
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

	
	public function getTypeId()
	{
		return $this->type_id;
	}

	
	public function getVendorId()
	{
		return $this->vendor_id;
	}

	
	public function getDeviceId()
	{
		return $this->device_id;
	}

	
	public function getClassType()
	{
		return $this->class_type;
	}

	
	public function getName()
	{
		return $this->name;
	}

	
	public function getDate($format = 'Y/m/d')
	{
		if ($this->date === null) {
			return null;
		}


		if ($this->date === '0000-00-00') {
									return null;
		} else {
			try {
				$dt = new DateTime($this->date);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date, true), $x);
			}
		}

		if ($format === null) {
						return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	
	public function getString()
	{
		return $this->string;
	}

	
	public function getUrl()
	{
		return $this->url;
	}

	
	public function getCreatedAt($format = 'Y/m/d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
									return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
						return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = DriverPeer::ID;
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
			$this->modifiedColumns[] = DriverPeer::TYPE_ID;
		}

		if ($this->aType !== null && $this->aType->getId() !== $v) {
			$this->aType = null;
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
			$this->modifiedColumns[] = DriverPeer::VENDOR_ID;
		}

		if ($this->aVendor !== null && $this->aVendor->getCode() !== $v) {
			$this->aVendor = null;
		}

		return $this;
	} 
	
	public function setDeviceId($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->device_id !== $v) {
			$this->device_id = $v;
			$this->modifiedColumns[] = DriverPeer::DEVICE_ID;
		}

		if ($this->aDevice !== null && $this->aDevice->getCode() !== $v) {
			$this->aDevice = null;
		}

		return $this;
	} 
	
	public function setClassType($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->class_type !== $v) {
			$this->class_type = $v;
			$this->modifiedColumns[] = DriverPeer::CLASS_TYPE;
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
			$this->modifiedColumns[] = DriverPeer::NAME;
		}

		return $this;
	} 
	
	public function setDate($v)
	{
						if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
									try {
				if (is_numeric($v)) { 					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
															$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->date !== null || $dt !== null ) {
			
			$currNorm = ($this->date !== null && $tmpDt = new DateTime($this->date)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) 					)
			{
				$this->date = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = DriverPeer::DATE;
			}
		} 
		return $this;
	} 
	
	public function setString($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->string !== $v) {
			$this->string = $v;
			$this->modifiedColumns[] = DriverPeer::STRING;
		}

		return $this;
	} 
	
	public function setUrl($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = DriverPeer::URL;
		}

		return $this;
	} 
	
	public function setCreatedAt($v)
	{
						if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
									try {
				if (is_numeric($v)) { 					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
															$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			
			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) 					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = DriverPeer::CREATED_AT;
			}
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
			$this->type_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->vendor_id = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->device_id = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->class_type = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->name = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->date = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->string = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->url = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->created_at = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Driver object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aType !== null && $this->type_id !== $this->aType->getId()) {
			$this->aType = null;
		}
		if ($this->aVendor !== null && $this->vendor_id !== $this->aVendor->getCode()) {
			$this->aVendor = null;
		}
		if ($this->aDevice !== null && $this->device_id !== $this->aDevice->getCode()) {
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
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = DriverPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aType = null;
			$this->aVendor = null;
			$this->aDevice = null;
			$this->collSystems = null;
			$this->lastSystemCriteria = null;

			$this->collPaths = null;
			$this->lastPathCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			DriverPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	public function save(PropelPDO $con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(DriverPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(DriverPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			DriverPeer::addInstanceToPool($this);
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

			if ($this->aVendor !== null) {
				if ($this->aVendor->isModified() || $this->aVendor->isNew()) {
					$affectedRows += $this->aVendor->save($con);
				}
				$this->setVendor($this->aVendor);
			}

			if ($this->aDevice !== null) {
				if ($this->aDevice->isModified() || $this->aDevice->isNew()) {
					$affectedRows += $this->aDevice->save($con);
				}
				$this->setDevice($this->aDevice);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = DriverPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = DriverPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += DriverPeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collSystems !== null) {
				foreach ($this->collSystems as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPaths !== null) {
				foreach ($this->collPaths as $referrerFK) {
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

			if ($this->aVendor !== null) {
				if (!$this->aVendor->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aVendor->getValidationFailures());
				}
			}

			if ($this->aDevice !== null) {
				if (!$this->aDevice->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDevice->getValidationFailures());
				}
			}


			if (($retval = DriverPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collSystems !== null) {
					foreach ($this->collSystems as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPaths !== null) {
					foreach ($this->collPaths as $referrerFK) {
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
		$pos = DriverPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getTypeId();
				break;
			case 2:
				return $this->getVendorId();
				break;
			case 3:
				return $this->getDeviceId();
				break;
			case 4:
				return $this->getClassType();
				break;
			case 5:
				return $this->getName();
				break;
			case 6:
				return $this->getDate();
				break;
			case 7:
				return $this->getString();
				break;
			case 8:
				return $this->getUrl();
				break;
			case 9:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = DriverPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTypeId(),
			$keys[2] => $this->getVendorId(),
			$keys[3] => $this->getDeviceId(),
			$keys[4] => $this->getClassType(),
			$keys[5] => $this->getName(),
			$keys[6] => $this->getDate(),
			$keys[7] => $this->getString(),
			$keys[8] => $this->getUrl(),
			$keys[9] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = DriverPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTypeId($value);
				break;
			case 2:
				$this->setVendorId($value);
				break;
			case 3:
				$this->setDeviceId($value);
				break;
			case 4:
				$this->setClassType($value);
				break;
			case 5:
				$this->setName($value);
				break;
			case 6:
				$this->setDate($value);
				break;
			case 7:
				$this->setString($value);
				break;
			case 8:
				$this->setUrl($value);
				break;
			case 9:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = DriverPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTypeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setVendorId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDeviceId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setClassType($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDate($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setString($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUrl($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCreatedAt($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(DriverPeer::DATABASE_NAME);

		if ($this->isColumnModified(DriverPeer::ID)) $criteria->add(DriverPeer::ID, $this->id);
		if ($this->isColumnModified(DriverPeer::TYPE_ID)) $criteria->add(DriverPeer::TYPE_ID, $this->type_id);
		if ($this->isColumnModified(DriverPeer::VENDOR_ID)) $criteria->add(DriverPeer::VENDOR_ID, $this->vendor_id);
		if ($this->isColumnModified(DriverPeer::DEVICE_ID)) $criteria->add(DriverPeer::DEVICE_ID, $this->device_id);
		if ($this->isColumnModified(DriverPeer::CLASS_TYPE)) $criteria->add(DriverPeer::CLASS_TYPE, $this->class_type);
		if ($this->isColumnModified(DriverPeer::NAME)) $criteria->add(DriverPeer::NAME, $this->name);
		if ($this->isColumnModified(DriverPeer::DATE)) $criteria->add(DriverPeer::DATE, $this->date);
		if ($this->isColumnModified(DriverPeer::STRING)) $criteria->add(DriverPeer::STRING, $this->string);
		if ($this->isColumnModified(DriverPeer::URL)) $criteria->add(DriverPeer::URL, $this->url);
		if ($this->isColumnModified(DriverPeer::CREATED_AT)) $criteria->add(DriverPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(DriverPeer::DATABASE_NAME);

		$criteria->add(DriverPeer::ID, $this->id);

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

		$copyObj->setTypeId($this->type_id);

		$copyObj->setVendorId($this->vendor_id);

		$copyObj->setDeviceId($this->device_id);

		$copyObj->setClassType($this->class_type);

		$copyObj->setName($this->name);

		$copyObj->setDate($this->date);

		$copyObj->setString($this->string);

		$copyObj->setUrl($this->url);

		$copyObj->setCreatedAt($this->created_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getSystems() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addSystem($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPaths() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addPath($relObj->copy($deepCopy));
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
			self::$peer = new DriverPeer();
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
			$v->addDriver($this);
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

	
	public function setVendor(Vendor $v = null)
	{
		if ($v === null) {
			$this->setVendorId(NULL);
		} else {
			$this->setVendorId($v->getCode());
		}

		$this->aVendor = $v;

						if ($v !== null) {
			$v->addDriver($this);
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

	
	public function setDevice(Device $v = null)
	{
		if ($v === null) {
			$this->setDeviceId(NULL);
		} else {
			$this->setDeviceId($v->getCode());
		}

		$this->aDevice = $v;

						if ($v !== null) {
			$v->addDriver($this);
		}

		return $this;
	}


	
	public function getDevice(PropelPDO $con = null)
	{
		if ($this->aDevice === null && (($this->device_id !== "" && $this->device_id !== null))) {
			$c = new Criteria(DevicePeer::DATABASE_NAME);
			$c->add(DevicePeer::CODE, $this->device_id);
			$this->aDevice = DevicePeer::doSelectOne($c, $con);
			
		}
		return $this->aDevice;
	}

	
	public function clearSystems()
	{
		$this->collSystems = null; 	}

	
	public function initSystems()
	{
		$this->collSystems = array();
	}

	
	public function getSystems($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DriverPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collSystems === null) {
			if ($this->isNew()) {
			   $this->collSystems = array();
			} else {

				$criteria->add(SystemPeer::DRIVER_ID, $this->id);

				SystemPeer::addSelectColumns($criteria);
				$this->collSystems = SystemPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SystemPeer::DRIVER_ID, $this->id);

				SystemPeer::addSelectColumns($criteria);
				if (!isset($this->lastSystemCriteria) || !$this->lastSystemCriteria->equals($criteria)) {
					$this->collSystems = SystemPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastSystemCriteria = $criteria;
		return $this->collSystems;
	}

	
	public function countSystems(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DriverPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collSystems === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(SystemPeer::DRIVER_ID, $this->id);

				$count = SystemPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(SystemPeer::DRIVER_ID, $this->id);

				if (!isset($this->lastSystemCriteria) || !$this->lastSystemCriteria->equals($criteria)) {
					$count = SystemPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collSystems);
				}
			} else {
				$count = count($this->collSystems);
			}
		}
		$this->lastSystemCriteria = $criteria;
		return $count;
	}

	
	public function addSystem(System $l)
	{
		if ($this->collSystems === null) {
			$this->initSystems();
		}
		if (!in_array($l, $this->collSystems, true)) { 			array_push($this->collSystems, $l);
			$l->setDriver($this);
		}
	}

	
	public function clearPaths()
	{
		$this->collPaths = null; 	}

	
	public function initPaths()
	{
		$this->collPaths = array();
	}

	
	public function getPaths($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DriverPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPaths === null) {
			if ($this->isNew()) {
			   $this->collPaths = array();
			} else {

				$criteria->add(PathPeer::DRIVER_ID, $this->id);

				PathPeer::addSelectColumns($criteria);
				$this->collPaths = PathPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(PathPeer::DRIVER_ID, $this->id);

				PathPeer::addSelectColumns($criteria);
				if (!isset($this->lastPathCriteria) || !$this->lastPathCriteria->equals($criteria)) {
					$this->collPaths = PathPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPathCriteria = $criteria;
		return $this->collPaths;
	}

	
	public function countPaths(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(DriverPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collPaths === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(PathPeer::DRIVER_ID, $this->id);

				$count = PathPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(PathPeer::DRIVER_ID, $this->id);

				if (!isset($this->lastPathCriteria) || !$this->lastPathCriteria->equals($criteria)) {
					$count = PathPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collPaths);
				}
			} else {
				$count = count($this->collPaths);
			}
		}
		$this->lastPathCriteria = $criteria;
		return $count;
	}

	
	public function addPath(Path $l)
	{
		if ($this->collPaths === null) {
			$this->initPaths();
		}
		if (!in_array($l, $this->collPaths, true)) { 			array_push($this->collPaths, $l);
			$l->setDriver($this);
		}
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collSystems) {
				foreach ((array) $this->collSystems as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPaths) {
				foreach ((array) $this->collPaths as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collSystems = null;
		$this->collPaths = null;
			$this->aType = null;
			$this->aVendor = null;
			$this->aDevice = null;
	}

} 