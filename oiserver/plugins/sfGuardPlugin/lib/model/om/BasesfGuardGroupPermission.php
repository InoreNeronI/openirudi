<?php


abstract class BasesfGuardGroupPermission extends BaseObject  implements Persistent {


  const PEER = 'sfGuardGroupPermissionPeer';

	
	protected static $peer;

	
	protected $group_id;

	
	protected $permission_id;

	
	protected $asfGuardGroup;

	
	protected $asfGuardPermission;

	
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

	
	public function getGroupId()
	{
		return $this->group_id;
	}

	
	public function getPermissionId()
	{
		return $this->permission_id;
	}

	
	public function setGroupId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->group_id !== $v) {
			$this->group_id = $v;
			$this->modifiedColumns[] = sfGuardGroupPermissionPeer::GROUP_ID;
		}

		if ($this->asfGuardGroup !== null && $this->asfGuardGroup->getId() !== $v) {
			$this->asfGuardGroup = null;
		}

		return $this;
	} 
	
	public function setPermissionId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->permission_id !== $v) {
			$this->permission_id = $v;
			$this->modifiedColumns[] = sfGuardGroupPermissionPeer::PERMISSION_ID;
		}

		if ($this->asfGuardPermission !== null && $this->asfGuardPermission->getId() !== $v) {
			$this->asfGuardPermission = null;
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

			$this->group_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->permission_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfGuardGroupPermission object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->asfGuardGroup !== null && $this->group_id !== $this->asfGuardGroup->getId()) {
			$this->asfGuardGroup = null;
		}
		if ($this->asfGuardPermission !== null && $this->permission_id !== $this->asfGuardPermission->getId()) {
			$this->asfGuardPermission = null;
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
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = sfGuardGroupPermissionPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->asfGuardGroup = null;
			$this->asfGuardPermission = null;
		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			sfGuardGroupPermissionPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(sfGuardGroupPermissionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			sfGuardGroupPermissionPeer::addInstanceToPool($this);
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

												
			if ($this->asfGuardGroup !== null) {
				if ($this->asfGuardGroup->isModified() || $this->asfGuardGroup->isNew()) {
					$affectedRows += $this->asfGuardGroup->save($con);
				}
				$this->setsfGuardGroup($this->asfGuardGroup);
			}

			if ($this->asfGuardPermission !== null) {
				if ($this->asfGuardPermission->isModified() || $this->asfGuardPermission->isNew()) {
					$affectedRows += $this->asfGuardPermission->save($con);
				}
				$this->setsfGuardPermission($this->asfGuardPermission);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfGuardGroupPermissionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += sfGuardGroupPermissionPeer::doUpdate($this, $con);
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


												
			if ($this->asfGuardGroup !== null) {
				if (!$this->asfGuardGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardGroup->getValidationFailures());
				}
			}

			if ($this->asfGuardPermission !== null) {
				if (!$this->asfGuardPermission->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfGuardPermission->getValidationFailures());
				}
			}


			if (($retval = sfGuardGroupPermissionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardGroupPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getGroupId();
				break;
			case 1:
				return $this->getPermissionId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = sfGuardGroupPermissionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getGroupId(),
			$keys[1] => $this->getPermissionId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardGroupPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setGroupId($value);
				break;
			case 1:
				$this->setPermissionId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardGroupPermissionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setGroupId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPermissionId($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfGuardGroupPermissionPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfGuardGroupPermissionPeer::GROUP_ID)) $criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->group_id);
		if ($this->isColumnModified(sfGuardGroupPermissionPeer::PERMISSION_ID)) $criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->permission_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfGuardGroupPermissionPeer::DATABASE_NAME);

		$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->group_id);
		$criteria->add(sfGuardGroupPermissionPeer::PERMISSION_ID, $this->permission_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getGroupId();

		$pks[1] = $this->getPermissionId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setGroupId($keys[0]);

		$this->setPermissionId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setGroupId($this->group_id);

		$copyObj->setPermissionId($this->permission_id);


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
			self::$peer = new sfGuardGroupPermissionPeer();
		}
		return self::$peer;
	}

	
	public function setsfGuardGroup(sfGuardGroup $v = null)
	{
		if ($v === null) {
			$this->setGroupId(NULL);
		} else {
			$this->setGroupId($v->getId());
		}

		$this->asfGuardGroup = $v;

						if ($v !== null) {
			$v->addsfGuardGroupPermission($this);
		}

		return $this;
	}


	
	public function getsfGuardGroup(PropelPDO $con = null)
	{
		if ($this->asfGuardGroup === null && ($this->group_id !== null)) {
			$c = new Criteria(sfGuardGroupPeer::DATABASE_NAME);
			$c->add(sfGuardGroupPeer::ID, $this->group_id);
			$this->asfGuardGroup = sfGuardGroupPeer::doSelectOne($c, $con);
			
		}
		return $this->asfGuardGroup;
	}

	
	public function setsfGuardPermission(sfGuardPermission $v = null)
	{
		if ($v === null) {
			$this->setPermissionId(NULL);
		} else {
			$this->setPermissionId($v->getId());
		}

		$this->asfGuardPermission = $v;

						if ($v !== null) {
			$v->addsfGuardGroupPermission($this);
		}

		return $this;
	}


	
	public function getsfGuardPermission(PropelPDO $con = null)
	{
		if ($this->asfGuardPermission === null && ($this->permission_id !== null)) {
			$c = new Criteria(sfGuardPermissionPeer::DATABASE_NAME);
			$c->add(sfGuardPermissionPeer::ID, $this->permission_id);
			$this->asfGuardPermission = sfGuardPermissionPeer::doSelectOne($c, $con);
			
		}
		return $this->asfGuardPermission;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} 
			$this->asfGuardGroup = null;
			$this->asfGuardPermission = null;
	}

} 