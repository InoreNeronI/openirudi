<?php


abstract class BasesfGuardGroup extends BaseObject  implements Persistent {


  const PEER = 'sfGuardGroupPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $name;

	
	protected $description;

	
	protected $collsfGuardGroupPermissions;

	
	private $lastsfGuardGroupPermissionCriteria = null;

	
	protected $collsfGuardUserGroups;

	
	private $lastsfGuardUserGroupCriteria = null;

	
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

	
	public function getDescription()
	{
		return $this->description;
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfGuardGroupPeer::ID;
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
			$this->modifiedColumns[] = sfGuardGroupPeer::NAME;
		}

		return $this;
	} 
	
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = sfGuardGroupPeer::DESCRIPTION;
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
			$this->description = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfGuardGroup object", $e);
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
			$con = Propel::getConnection(sfGuardGroupPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = sfGuardGroupPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->collsfGuardGroupPermissions = null;
			$this->lastsfGuardGroupPermissionCriteria = null;

			$this->collsfGuardUserGroups = null;
			$this->lastsfGuardUserGroupCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfGuardGroupPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			sfGuardGroupPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(sfGuardGroupPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			sfGuardGroupPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = sfGuardGroupPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfGuardGroupPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfGuardGroupPeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collsfGuardGroupPermissions !== null) {
				foreach ($this->collsfGuardGroupPermissions as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfGuardUserGroups !== null) {
				foreach ($this->collsfGuardUserGroups as $referrerFK) {
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


			if (($retval = sfGuardGroupPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collsfGuardGroupPermissions !== null) {
					foreach ($this->collsfGuardGroupPermissions as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfGuardUserGroups !== null) {
					foreach ($this->collsfGuardUserGroups as $referrerFK) {
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
		$pos = sfGuardGroupPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getDescription();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = sfGuardGroupPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getDescription(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfGuardGroupPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setDescription($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfGuardGroupPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfGuardGroupPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfGuardGroupPeer::ID)) $criteria->add(sfGuardGroupPeer::ID, $this->id);
		if ($this->isColumnModified(sfGuardGroupPeer::NAME)) $criteria->add(sfGuardGroupPeer::NAME, $this->name);
		if ($this->isColumnModified(sfGuardGroupPeer::DESCRIPTION)) $criteria->add(sfGuardGroupPeer::DESCRIPTION, $this->description);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfGuardGroupPeer::DATABASE_NAME);

		$criteria->add(sfGuardGroupPeer::ID, $this->id);

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

		$copyObj->setDescription($this->description);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getsfGuardGroupPermissions() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addsfGuardGroupPermission($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getsfGuardUserGroups() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addsfGuardUserGroup($relObj->copy($deepCopy));
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
			self::$peer = new sfGuardGroupPeer();
		}
		return self::$peer;
	}

	
	public function clearsfGuardGroupPermissions()
	{
		$this->collsfGuardGroupPermissions = null; 	}

	
	public function initsfGuardGroupPermissions()
	{
		$this->collsfGuardGroupPermissions = array();
	}

	
	public function getsfGuardGroupPermissions($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(sfGuardGroupPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardGroupPermissions === null) {
			if ($this->isNew()) {
			   $this->collsfGuardGroupPermissions = array();
			} else {

				$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->id);

				sfGuardGroupPermissionPeer::addSelectColumns($criteria);
				$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->id);

				sfGuardGroupPermissionPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardGroupPermissionCriteria) || !$this->lastsfGuardGroupPermissionCriteria->equals($criteria)) {
					$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardGroupPermissionCriteria = $criteria;
		return $this->collsfGuardGroupPermissions;
	}

	
	public function countsfGuardGroupPermissions(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(sfGuardGroupPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collsfGuardGroupPermissions === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->id);

				$count = sfGuardGroupPermissionPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->id);

				if (!isset($this->lastsfGuardGroupPermissionCriteria) || !$this->lastsfGuardGroupPermissionCriteria->equals($criteria)) {
					$count = sfGuardGroupPermissionPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collsfGuardGroupPermissions);
				}
			} else {
				$count = count($this->collsfGuardGroupPermissions);
			}
		}
		$this->lastsfGuardGroupPermissionCriteria = $criteria;
		return $count;
	}

	
	public function addsfGuardGroupPermission(sfGuardGroupPermission $l)
	{
		if ($this->collsfGuardGroupPermissions === null) {
			$this->initsfGuardGroupPermissions();
		}
		if (!in_array($l, $this->collsfGuardGroupPermissions, true)) { 			array_push($this->collsfGuardGroupPermissions, $l);
			$l->setsfGuardGroup($this);
		}
	}


	
	public function getsfGuardGroupPermissionsJoinsfGuardPermission($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(sfGuardGroupPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardGroupPermissions === null) {
			if ($this->isNew()) {
				$this->collsfGuardGroupPermissions = array();
			} else {

				$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->id);

				$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelectJoinsfGuardPermission($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(sfGuardGroupPermissionPeer::GROUP_ID, $this->id);

			if (!isset($this->lastsfGuardGroupPermissionCriteria) || !$this->lastsfGuardGroupPermissionCriteria->equals($criteria)) {
				$this->collsfGuardGroupPermissions = sfGuardGroupPermissionPeer::doSelectJoinsfGuardPermission($criteria, $con, $join_behavior);
			}
		}
		$this->lastsfGuardGroupPermissionCriteria = $criteria;

		return $this->collsfGuardGroupPermissions;
	}

	
	public function clearsfGuardUserGroups()
	{
		$this->collsfGuardUserGroups = null; 	}

	
	public function initsfGuardUserGroups()
	{
		$this->collsfGuardUserGroups = array();
	}

	
	public function getsfGuardUserGroups($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(sfGuardGroupPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserGroups === null) {
			if ($this->isNew()) {
			   $this->collsfGuardUserGroups = array();
			} else {

				$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->id);

				sfGuardUserGroupPeer::addSelectColumns($criteria);
				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->id);

				sfGuardUserGroupPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfGuardUserGroupCriteria) || !$this->lastsfGuardUserGroupCriteria->equals($criteria)) {
					$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfGuardUserGroupCriteria = $criteria;
		return $this->collsfGuardUserGroups;
	}

	
	public function countsfGuardUserGroups(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(sfGuardGroupPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collsfGuardUserGroups === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->id);

				$count = sfGuardUserGroupPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->id);

				if (!isset($this->lastsfGuardUserGroupCriteria) || !$this->lastsfGuardUserGroupCriteria->equals($criteria)) {
					$count = sfGuardUserGroupPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collsfGuardUserGroups);
				}
			} else {
				$count = count($this->collsfGuardUserGroups);
			}
		}
		$this->lastsfGuardUserGroupCriteria = $criteria;
		return $count;
	}

	
	public function addsfGuardUserGroup(sfGuardUserGroup $l)
	{
		if ($this->collsfGuardUserGroups === null) {
			$this->initsfGuardUserGroups();
		}
		if (!in_array($l, $this->collsfGuardUserGroups, true)) { 			array_push($this->collsfGuardUserGroups, $l);
			$l->setsfGuardGroup($this);
		}
	}


	
	public function getsfGuardUserGroupsJoinsfGuardUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(sfGuardGroupPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfGuardUserGroups === null) {
			if ($this->isNew()) {
				$this->collsfGuardUserGroups = array();
			} else {

				$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->id);

				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelectJoinsfGuardUser($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(sfGuardUserGroupPeer::GROUP_ID, $this->id);

			if (!isset($this->lastsfGuardUserGroupCriteria) || !$this->lastsfGuardUserGroupCriteria->equals($criteria)) {
				$this->collsfGuardUserGroups = sfGuardUserGroupPeer::doSelectJoinsfGuardUser($criteria, $con, $join_behavior);
			}
		}
		$this->lastsfGuardUserGroupCriteria = $criteria;

		return $this->collsfGuardUserGroups;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collsfGuardGroupPermissions) {
				foreach ((array) $this->collsfGuardGroupPermissions as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collsfGuardUserGroups) {
				foreach ((array) $this->collsfGuardUserGroups as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collsfGuardGroupPermissions = null;
		$this->collsfGuardUserGroups = null;
	}

} 