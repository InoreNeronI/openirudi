<?php


abstract class BaseMyTask extends BaseObject  implements Persistent {


  const PEER = 'MyTaskPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $day;

	
	protected $hour;

	
	protected $associate;

	
	protected $oiimages_id;

	
	protected $partition;

	
	protected $pc_id;

	
	protected $is_imageset;

	
	protected $imageset_id;

	
	protected $is_boot;

	
	protected $disk;

	
	protected $aOiimages;

	
	protected $aPc;

	
	protected $aImageset;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	
	public function applyDefaultValues()
	{
		$this->associate = false;
		$this->is_imageset = false;
		$this->is_boot = false;
	}

	
	public function getId()
	{
		return $this->id;
	}

	
	public function getDay($format = 'Y/m/d')
	{
		if ($this->day === null) {
			return null;
		}


		if ($this->day === '0000-00-00') {
									return null;
		} else {
			try {
				$dt = new DateTime($this->day);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->day, true), $x);
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

	
	public function getHour($format = 'H:i:s')
	{
		if ($this->hour === null) {
			return null;
		}



		try {
			$dt = new DateTime($this->hour);
		} catch (Exception $x) {
			throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->hour, true), $x);
		}

		if ($format === null) {
						return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	
	public function getAssociate()
	{
		return $this->associate;
	}

	
	public function getOiimagesId()
	{
		return $this->oiimages_id;
	}

	
	public function getPartition()
	{
		return $this->partition;
	}

	
	public function getPcId()
	{
		return $this->pc_id;
	}

	
	public function getIsImageset()
	{
		return $this->is_imageset;
	}

	
	public function getImagesetId()
	{
		return $this->imageset_id;
	}

	
	public function getIsBoot()
	{
		return $this->is_boot;
	}

	
	public function getDisk()
	{
		return $this->disk;
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MyTaskPeer::ID;
		}

		return $this;
	} 
	
	public function setDay($v)
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

		if ( $this->day !== null || $dt !== null ) {
			
			$currNorm = ($this->day !== null && $tmpDt = new DateTime($this->day)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) 					)
			{
				$this->day = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = MyTaskPeer::DAY;
			}
		} 
		return $this;
	} 
	
	public function setHour($v)
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

		if ( $this->hour !== null || $dt !== null ) {
			
			$currNorm = ($this->hour !== null && $tmpDt = new DateTime($this->hour)) ? $tmpDt->format('H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('H:i:s') : null;

			if ( ($currNorm !== $newNorm) 					)
			{
				$this->hour = ($dt ? $dt->format('H:i:s') : null);
				$this->modifiedColumns[] = MyTaskPeer::HOUR;
			}
		} 
		return $this;
	} 
	
	public function setAssociate($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->associate !== $v || $v === false) {
			$this->associate = $v;
			$this->modifiedColumns[] = MyTaskPeer::ASSOCIATE;
		}

		return $this;
	} 
	
	public function setOiimagesId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->oiimages_id !== $v) {
			$this->oiimages_id = $v;
			$this->modifiedColumns[] = MyTaskPeer::OIIMAGES_ID;
		}

		if ($this->aOiimages !== null && $this->aOiimages->getId() !== $v) {
			$this->aOiimages = null;
		}

		return $this;
	} 
	
	public function setPartition($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->partition !== $v) {
			$this->partition = $v;
			$this->modifiedColumns[] = MyTaskPeer::PARTITION;
		}

		return $this;
	} 
	
	public function setPcId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->pc_id !== $v) {
			$this->pc_id = $v;
			$this->modifiedColumns[] = MyTaskPeer::PC_ID;
		}

		if ($this->aPc !== null && $this->aPc->getId() !== $v) {
			$this->aPc = null;
		}

		return $this;
	} 
	
	public function setIsImageset($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_imageset !== $v || $v === false) {
			$this->is_imageset = $v;
			$this->modifiedColumns[] = MyTaskPeer::IS_IMAGESET;
		}

		return $this;
	} 
	
	public function setImagesetId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->imageset_id !== $v) {
			$this->imageset_id = $v;
			$this->modifiedColumns[] = MyTaskPeer::IMAGESET_ID;
		}

		if ($this->aImageset !== null && $this->aImageset->getId() !== $v) {
			$this->aImageset = null;
		}

		return $this;
	} 
	
	public function setIsBoot($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_boot !== $v || $v === false) {
			$this->is_boot = $v;
			$this->modifiedColumns[] = MyTaskPeer::IS_BOOT;
		}

		return $this;
	} 
	
	public function setDisk($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->disk !== $v) {
			$this->disk = $v;
			$this->modifiedColumns[] = MyTaskPeer::DISK;
		}

		return $this;
	} 
	
	public function hasOnlyDefaultValues()
	{
						if (array_diff($this->modifiedColumns, array(MyTaskPeer::ASSOCIATE,MyTaskPeer::IS_IMAGESET,MyTaskPeer::IS_BOOT))) {
				return false;
			}

			if ($this->associate !== false) {
				return false;
			}

			if ($this->is_imageset !== false) {
				return false;
			}

			if ($this->is_boot !== false) {
				return false;
			}

				return true;
	} 
	
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->day = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->hour = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->associate = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
			$this->oiimages_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
			$this->partition = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->pc_id = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
			$this->is_imageset = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
			$this->imageset_id = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->is_boot = ($row[$startcol + 9] !== null) ? (boolean) $row[$startcol + 9] : null;
			$this->disk = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 11; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MyTask object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aOiimages !== null && $this->oiimages_id !== $this->aOiimages->getId()) {
			$this->aOiimages = null;
		}
		if ($this->aPc !== null && $this->pc_id !== $this->aPc->getId()) {
			$this->aPc = null;
		}
		if ($this->aImageset !== null && $this->imageset_id !== $this->aImageset->getId()) {
			$this->aImageset = null;
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
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = MyTaskPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aOiimages = null;
			$this->aPc = null;
			$this->aImageset = null;
		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			MyTaskPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			MyTaskPeer::addInstanceToPool($this);
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

												
			if ($this->aOiimages !== null) {
				if ($this->aOiimages->isModified() || $this->aOiimages->isNew()) {
					$affectedRows += $this->aOiimages->save($con);
				}
				$this->setOiimages($this->aOiimages);
			}

			if ($this->aPc !== null) {
				if ($this->aPc->isModified() || $this->aPc->isNew()) {
					$affectedRows += $this->aPc->save($con);
				}
				$this->setPc($this->aPc);
			}

			if ($this->aImageset !== null) {
				if ($this->aImageset->isModified() || $this->aImageset->isNew()) {
					$affectedRows += $this->aImageset->save($con);
				}
				$this->setImageset($this->aImageset);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = MyTaskPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MyTaskPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MyTaskPeer::doUpdate($this, $con);
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


												
			if ($this->aOiimages !== null) {
				if (!$this->aOiimages->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOiimages->getValidationFailures());
				}
			}

			if ($this->aPc !== null) {
				if (!$this->aPc->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPc->getValidationFailures());
				}
			}

			if ($this->aImageset !== null) {
				if (!$this->aImageset->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aImageset->getValidationFailures());
				}
			}


			if (($retval = MyTaskPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MyTaskPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getDay();
				break;
			case 2:
				return $this->getHour();
				break;
			case 3:
				return $this->getAssociate();
				break;
			case 4:
				return $this->getOiimagesId();
				break;
			case 5:
				return $this->getPartition();
				break;
			case 6:
				return $this->getPcId();
				break;
			case 7:
				return $this->getIsImageset();
				break;
			case 8:
				return $this->getImagesetId();
				break;
			case 9:
				return $this->getIsBoot();
				break;
			case 10:
				return $this->getDisk();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = MyTaskPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getDay(),
			$keys[2] => $this->getHour(),
			$keys[3] => $this->getAssociate(),
			$keys[4] => $this->getOiimagesId(),
			$keys[5] => $this->getPartition(),
			$keys[6] => $this->getPcId(),
			$keys[7] => $this->getIsImageset(),
			$keys[8] => $this->getImagesetId(),
			$keys[9] => $this->getIsBoot(),
			$keys[10] => $this->getDisk(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MyTaskPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setDay($value);
				break;
			case 2:
				$this->setHour($value);
				break;
			case 3:
				$this->setAssociate($value);
				break;
			case 4:
				$this->setOiimagesId($value);
				break;
			case 5:
				$this->setPartition($value);
				break;
			case 6:
				$this->setPcId($value);
				break;
			case 7:
				$this->setIsImageset($value);
				break;
			case 8:
				$this->setImagesetId($value);
				break;
			case 9:
				$this->setIsBoot($value);
				break;
			case 10:
				$this->setDisk($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MyTaskPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDay($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setHour($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setAssociate($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOiimagesId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPartition($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPcId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsImageset($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setImagesetId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsBoot($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setDisk($arr[$keys[10]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MyTaskPeer::DATABASE_NAME);

		if ($this->isColumnModified(MyTaskPeer::ID)) $criteria->add(MyTaskPeer::ID, $this->id);
		if ($this->isColumnModified(MyTaskPeer::DAY)) $criteria->add(MyTaskPeer::DAY, $this->day);
		if ($this->isColumnModified(MyTaskPeer::HOUR)) $criteria->add(MyTaskPeer::HOUR, $this->hour);
		if ($this->isColumnModified(MyTaskPeer::ASSOCIATE)) $criteria->add(MyTaskPeer::ASSOCIATE, $this->associate);
		if ($this->isColumnModified(MyTaskPeer::OIIMAGES_ID)) $criteria->add(MyTaskPeer::OIIMAGES_ID, $this->oiimages_id);
		if ($this->isColumnModified(MyTaskPeer::PARTITION)) $criteria->add(MyTaskPeer::PARTITION, $this->partition);
		if ($this->isColumnModified(MyTaskPeer::PC_ID)) $criteria->add(MyTaskPeer::PC_ID, $this->pc_id);
		if ($this->isColumnModified(MyTaskPeer::IS_IMAGESET)) $criteria->add(MyTaskPeer::IS_IMAGESET, $this->is_imageset);
		if ($this->isColumnModified(MyTaskPeer::IMAGESET_ID)) $criteria->add(MyTaskPeer::IMAGESET_ID, $this->imageset_id);
		if ($this->isColumnModified(MyTaskPeer::IS_BOOT)) $criteria->add(MyTaskPeer::IS_BOOT, $this->is_boot);
		if ($this->isColumnModified(MyTaskPeer::DISK)) $criteria->add(MyTaskPeer::DISK, $this->disk);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MyTaskPeer::DATABASE_NAME);

		$criteria->add(MyTaskPeer::ID, $this->id);

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

		$copyObj->setDay($this->day);

		$copyObj->setHour($this->hour);

		$copyObj->setAssociate($this->associate);

		$copyObj->setOiimagesId($this->oiimages_id);

		$copyObj->setPartition($this->partition);

		$copyObj->setPcId($this->pc_id);

		$copyObj->setIsImageset($this->is_imageset);

		$copyObj->setImagesetId($this->imageset_id);

		$copyObj->setIsBoot($this->is_boot);

		$copyObj->setDisk($this->disk);


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
			self::$peer = new MyTaskPeer();
		}
		return self::$peer;
	}

	
	public function setOiimages(Oiimages $v = null)
	{
		if ($v === null) {
			$this->setOiimagesId(NULL);
		} else {
			$this->setOiimagesId($v->getId());
		}

		$this->aOiimages = $v;

						if ($v !== null) {
			$v->addMyTask($this);
		}

		return $this;
	}


	
	public function getOiimages(PropelPDO $con = null)
	{
		if ($this->aOiimages === null && ($this->oiimages_id !== null)) {
			$c = new Criteria(OiimagesPeer::DATABASE_NAME);
			$c->add(OiimagesPeer::ID, $this->oiimages_id);
			$this->aOiimages = OiimagesPeer::doSelectOne($c, $con);
			
		}
		return $this->aOiimages;
	}

	
	public function setPc(Pc $v = null)
	{
		if ($v === null) {
			$this->setPcId(NULL);
		} else {
			$this->setPcId($v->getId());
		}

		$this->aPc = $v;

						if ($v !== null) {
			$v->addMyTask($this);
		}

		return $this;
	}


	
	public function getPc(PropelPDO $con = null)
	{
		if ($this->aPc === null && ($this->pc_id !== null)) {
			$c = new Criteria(PcPeer::DATABASE_NAME);
			$c->add(PcPeer::ID, $this->pc_id);
			$this->aPc = PcPeer::doSelectOne($c, $con);
			
		}
		return $this->aPc;
	}

	
	public function setImageset(Imageset $v = null)
	{
		if ($v === null) {
			$this->setImagesetId(NULL);
		} else {
			$this->setImagesetId($v->getId());
		}

		$this->aImageset = $v;

						if ($v !== null) {
			$v->addMyTask($this);
		}

		return $this;
	}


	
	public function getImageset(PropelPDO $con = null)
	{
		if ($this->aImageset === null && ($this->imageset_id !== null)) {
			$c = new Criteria(ImagesetPeer::DATABASE_NAME);
			$c->add(ImagesetPeer::ID, $this->imageset_id);
			$this->aImageset = ImagesetPeer::doSelectOne($c, $con);
			
		}
		return $this->aImageset;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} 
			$this->aOiimages = null;
			$this->aPc = null;
			$this->aImageset = null;
	}

} 