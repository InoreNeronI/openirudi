<?php


abstract class BasePartition extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $size = 0;


	
	protected $bootable;


	
	protected $start = 0;


	
	protected $end = 0;


	
	protected $cyls = 0;


	
	protected $blocks = 0;


	
	protected $device;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getSize()
	{

		return $this->size;
	}

	
	public function getBootable()
	{

		return $this->bootable;
	}

	
	public function getStart()
	{

		return $this->start;
	}

	
	public function getEnd()
	{

		return $this->end;
	}

	
	public function getCyls()
	{

		return $this->cyls;
	}

	
	public function getBlocks()
	{

		return $this->blocks;
	}

	
	public function getDevice()
	{

		return $this->device;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PartitionPeer::ID;
		}

	} 
	
	public function setSize($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->size !== $v || $v === 0) {
			$this->size = $v;
			$this->modifiedColumns[] = PartitionPeer::SIZE;
		}

	} 
	
	public function setBootable($v)
	{

		if ($this->bootable !== $v) {
			$this->bootable = $v;
			$this->modifiedColumns[] = PartitionPeer::BOOTABLE;
		}

	} 
	
	public function setStart($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->start !== $v || $v === 0) {
			$this->start = $v;
			$this->modifiedColumns[] = PartitionPeer::START;
		}

	} 
	
	public function setEnd($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->end !== $v || $v === 0) {
			$this->end = $v;
			$this->modifiedColumns[] = PartitionPeer::END;
		}

	} 
	
	public function setCyls($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->cyls !== $v || $v === 0) {
			$this->cyls = $v;
			$this->modifiedColumns[] = PartitionPeer::CYLS;
		}

	} 
	
	public function setBlocks($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->blocks !== $v || $v === 0) {
			$this->blocks = $v;
			$this->modifiedColumns[] = PartitionPeer::BLOCKS;
		}

	} 
	
	public function setDevice($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->device !== $v) {
			$this->device = $v;
			$this->modifiedColumns[] = PartitionPeer::DEVICE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->size = $rs->getInt($startcol + 1);

			$this->bootable = $rs->getBoolean($startcol + 2);

			$this->start = $rs->getInt($startcol + 3);

			$this->end = $rs->getInt($startcol + 4);

			$this->cyls = $rs->getInt($startcol + 5);

			$this->blocks = $rs->getInt($startcol + 6);

			$this->device = $rs->getString($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Partition object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PartitionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			PartitionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PartitionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PartitionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += PartitionPeer::doUpdate($this, $con);
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


			if (($retval = PartitionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PartitionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getSize();
				break;
			case 2:
				return $this->getBootable();
				break;
			case 3:
				return $this->getStart();
				break;
			case 4:
				return $this->getEnd();
				break;
			case 5:
				return $this->getCyls();
				break;
			case 6:
				return $this->getBlocks();
				break;
			case 7:
				return $this->getDevice();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = PartitionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getSize(),
			$keys[2] => $this->getBootable(),
			$keys[3] => $this->getStart(),
			$keys[4] => $this->getEnd(),
			$keys[5] => $this->getCyls(),
			$keys[6] => $this->getBlocks(),
			$keys[7] => $this->getDevice(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PartitionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setSize($value);
				break;
			case 2:
				$this->setBootable($value);
				break;
			case 3:
				$this->setStart($value);
				break;
			case 4:
				$this->setEnd($value);
				break;
			case 5:
				$this->setCyls($value);
				break;
			case 6:
				$this->setBlocks($value);
				break;
			case 7:
				$this->setDevice($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = PartitionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSize($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setBootable($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setStart($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setEnd($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCyls($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setBlocks($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDevice($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(PartitionPeer::DATABASE_NAME);

		if ($this->isColumnModified(PartitionPeer::ID)) $criteria->add(PartitionPeer::ID, $this->id);
		if ($this->isColumnModified(PartitionPeer::SIZE)) $criteria->add(PartitionPeer::SIZE, $this->size);
		if ($this->isColumnModified(PartitionPeer::BOOTABLE)) $criteria->add(PartitionPeer::BOOTABLE, $this->bootable);
		if ($this->isColumnModified(PartitionPeer::START)) $criteria->add(PartitionPeer::START, $this->start);
		if ($this->isColumnModified(PartitionPeer::END)) $criteria->add(PartitionPeer::END, $this->end);
		if ($this->isColumnModified(PartitionPeer::CYLS)) $criteria->add(PartitionPeer::CYLS, $this->cyls);
		if ($this->isColumnModified(PartitionPeer::BLOCKS)) $criteria->add(PartitionPeer::BLOCKS, $this->blocks);
		if ($this->isColumnModified(PartitionPeer::DEVICE)) $criteria->add(PartitionPeer::DEVICE, $this->device);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(PartitionPeer::DATABASE_NAME);

		$criteria->add(PartitionPeer::ID, $this->id);

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

		$copyObj->setSize($this->size);

		$copyObj->setBootable($this->bootable);

		$copyObj->setStart($this->start);

		$copyObj->setEnd($this->end);

		$copyObj->setCyls($this->cyls);

		$copyObj->setBlocks($this->blocks);

		$copyObj->setDevice($this->device);


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
			self::$peer = new PartitionPeer();
		}
		return self::$peer;
	}

} 