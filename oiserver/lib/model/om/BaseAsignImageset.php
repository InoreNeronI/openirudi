<?php


abstract class BaseAsignImageset extends BaseObject  implements Persistent {


  const PEER = 'AsignImagesetPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $name;

	
	protected $imageset_id;

	
	protected $oiimages_id;

	
	protected $size;

	
	protected $position;

	
	protected $color;

	
	protected $aImageset;

	
	protected $aOiimages;

	
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

	
	public function getName()
	{
		return $this->name;
	}

	
	public function getImagesetId()
	{
		return $this->imageset_id;
	}

	
	public function getOiimagesId()
	{
		return $this->oiimages_id;
	}

	
	public function getSize()
	{
		return $this->size;
	}

	
	public function getPosition()
	{
		return $this->position;
	}

	
	public function getColor()
	{
		return $this->color;
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = AsignImagesetPeer::ID;
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
			$this->modifiedColumns[] = AsignImagesetPeer::NAME;
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
			$this->modifiedColumns[] = AsignImagesetPeer::IMAGESET_ID;
		}

		if ($this->aImageset !== null && $this->aImageset->getId() !== $v) {
			$this->aImageset = null;
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
			$this->modifiedColumns[] = AsignImagesetPeer::OIIMAGES_ID;
		}

		if ($this->aOiimages !== null && $this->aOiimages->getId() !== $v) {
			$this->aOiimages = null;
		}

		return $this;
	} 
	
	public function setSize($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->size !== $v) {
			$this->size = $v;
			$this->modifiedColumns[] = AsignImagesetPeer::SIZE;
		}

		return $this;
	} 
	
	public function setPosition($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->position !== $v) {
			$this->position = $v;
			$this->modifiedColumns[] = AsignImagesetPeer::POSITION;
		}

		return $this;
	} 
	
	public function setColor($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->color !== $v) {
			$this->color = $v;
			$this->modifiedColumns[] = AsignImagesetPeer::COLOR;
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
			$this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->imageset_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
			$this->oiimages_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->size = ($row[$startcol + 4] !== null) ? (double) $row[$startcol + 4] : null;
			$this->position = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->color = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 7; 
		} catch (Exception $e) {
			throw new PropelException("Error populating AsignImageset object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aImageset !== null && $this->imageset_id !== $this->aImageset->getId()) {
			$this->aImageset = null;
		}
		if ($this->aOiimages !== null && $this->oiimages_id !== $this->aOiimages->getId()) {
			$this->aOiimages = null;
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
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = AsignImagesetPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aImageset = null;
			$this->aOiimages = null;
		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			AsignImagesetPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(AsignImagesetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			AsignImagesetPeer::addInstanceToPool($this);
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

												
			if ($this->aImageset !== null) {
				if ($this->aImageset->isModified() || $this->aImageset->isNew()) {
					$affectedRows += $this->aImageset->save($con);
				}
				$this->setImageset($this->aImageset);
			}

			if ($this->aOiimages !== null) {
				if ($this->aOiimages->isModified() || $this->aOiimages->isNew()) {
					$affectedRows += $this->aOiimages->save($con);
				}
				$this->setOiimages($this->aOiimages);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = AsignImagesetPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = AsignImagesetPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += AsignImagesetPeer::doUpdate($this, $con);
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


												
			if ($this->aImageset !== null) {
				if (!$this->aImageset->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aImageset->getValidationFailures());
				}
			}

			if ($this->aOiimages !== null) {
				if (!$this->aOiimages->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOiimages->getValidationFailures());
				}
			}


			if (($retval = AsignImagesetPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = AsignImagesetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getName();
				break;
			case 2:
				return $this->getImagesetId();
				break;
			case 3:
				return $this->getOiimagesId();
				break;
			case 4:
				return $this->getSize();
				break;
			case 5:
				return $this->getPosition();
				break;
			case 6:
				return $this->getColor();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = AsignImagesetPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getImagesetId(),
			$keys[3] => $this->getOiimagesId(),
			$keys[4] => $this->getSize(),
			$keys[5] => $this->getPosition(),
			$keys[6] => $this->getColor(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = AsignImagesetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setImagesetId($value);
				break;
			case 3:
				$this->setOiimagesId($value);
				break;
			case 4:
				$this->setSize($value);
				break;
			case 5:
				$this->setPosition($value);
				break;
			case 6:
				$this->setColor($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = AsignImagesetPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setImagesetId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setOiimagesId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSize($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPosition($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setColor($arr[$keys[6]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(AsignImagesetPeer::DATABASE_NAME);

		if ($this->isColumnModified(AsignImagesetPeer::ID)) $criteria->add(AsignImagesetPeer::ID, $this->id);
		if ($this->isColumnModified(AsignImagesetPeer::NAME)) $criteria->add(AsignImagesetPeer::NAME, $this->name);
		if ($this->isColumnModified(AsignImagesetPeer::IMAGESET_ID)) $criteria->add(AsignImagesetPeer::IMAGESET_ID, $this->imageset_id);
		if ($this->isColumnModified(AsignImagesetPeer::OIIMAGES_ID)) $criteria->add(AsignImagesetPeer::OIIMAGES_ID, $this->oiimages_id);
		if ($this->isColumnModified(AsignImagesetPeer::SIZE)) $criteria->add(AsignImagesetPeer::SIZE, $this->size);
		if ($this->isColumnModified(AsignImagesetPeer::POSITION)) $criteria->add(AsignImagesetPeer::POSITION, $this->position);
		if ($this->isColumnModified(AsignImagesetPeer::COLOR)) $criteria->add(AsignImagesetPeer::COLOR, $this->color);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(AsignImagesetPeer::DATABASE_NAME);

		$criteria->add(AsignImagesetPeer::ID, $this->id);

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

		$copyObj->setName($this->name);

		$copyObj->setImagesetId($this->imageset_id);

		$copyObj->setOiimagesId($this->oiimages_id);

		$copyObj->setSize($this->size);

		$copyObj->setPosition($this->position);

		$copyObj->setColor($this->color);


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
			self::$peer = new AsignImagesetPeer();
		}
		return self::$peer;
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
			$v->addAsignImageset($this);
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

	
	public function setOiimages(Oiimages $v = null)
	{
		if ($v === null) {
			$this->setOiimagesId(NULL);
		} else {
			$this->setOiimagesId($v->getId());
		}

		$this->aOiimages = $v;

						if ($v !== null) {
			$v->addAsignImageset($this);
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

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} 
			$this->aImageset = null;
			$this->aOiimages = null;
	}

} 