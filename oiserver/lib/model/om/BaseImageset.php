<?php


abstract class BaseImageset extends BaseObject  implements Persistent {


  const PEER = 'ImagesetPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $name;

	
	protected $collMyTasks;

	
	private $lastMyTaskCriteria = null;

	
	protected $collAsignImagesets;

	
	private $lastAsignImagesetCriteria = null;

	
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

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ImagesetPeer::ID;
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
			$this->modifiedColumns[] = ImagesetPeer::NAME;
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
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Imageset object", $e);
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
			$con = Propel::getConnection(ImagesetPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = ImagesetPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->collMyTasks = null;
			$this->lastMyTaskCriteria = null;

			$this->collAsignImagesets = null;
			$this->lastAsignImagesetCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ImagesetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			ImagesetPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ImagesetPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			ImagesetPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = ImagesetPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ImagesetPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ImagesetPeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collMyTasks !== null) {
				foreach ($this->collMyTasks as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAsignImagesets !== null) {
				foreach ($this->collAsignImagesets as $referrerFK) {
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


			if (($retval = ImagesetPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMyTasks !== null) {
					foreach ($this->collMyTasks as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAsignImagesets !== null) {
					foreach ($this->collAsignImagesets as $referrerFK) {
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
		$pos = ImagesetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = ImagesetPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ImagesetPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ImagesetPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ImagesetPeer::DATABASE_NAME);

		if ($this->isColumnModified(ImagesetPeer::ID)) $criteria->add(ImagesetPeer::ID, $this->id);
		if ($this->isColumnModified(ImagesetPeer::NAME)) $criteria->add(ImagesetPeer::NAME, $this->name);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ImagesetPeer::DATABASE_NAME);

		$criteria->add(ImagesetPeer::ID, $this->id);

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


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getMyTasks() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addMyTask($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getAsignImagesets() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addAsignImageset($relObj->copy($deepCopy));
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
			self::$peer = new ImagesetPeer();
		}
		return self::$peer;
	}

	
	public function clearMyTasks()
	{
		$this->collMyTasks = null; 	}

	
	public function initMyTasks()
	{
		$this->collMyTasks = array();
	}

	
	public function getMyTasks($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ImagesetPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMyTasks === null) {
			if ($this->isNew()) {
			   $this->collMyTasks = array();
			} else {

				$criteria->add(MyTaskPeer::IMAGESET_ID, $this->id);

				MyTaskPeer::addSelectColumns($criteria);
				$this->collMyTasks = MyTaskPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MyTaskPeer::IMAGESET_ID, $this->id);

				MyTaskPeer::addSelectColumns($criteria);
				if (!isset($this->lastMyTaskCriteria) || !$this->lastMyTaskCriteria->equals($criteria)) {
					$this->collMyTasks = MyTaskPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastMyTaskCriteria = $criteria;
		return $this->collMyTasks;
	}

	
	public function countMyTasks(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ImagesetPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collMyTasks === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(MyTaskPeer::IMAGESET_ID, $this->id);

				$count = MyTaskPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MyTaskPeer::IMAGESET_ID, $this->id);

				if (!isset($this->lastMyTaskCriteria) || !$this->lastMyTaskCriteria->equals($criteria)) {
					$count = MyTaskPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collMyTasks);
				}
			} else {
				$count = count($this->collMyTasks);
			}
		}
		$this->lastMyTaskCriteria = $criteria;
		return $count;
	}

	
	public function addMyTask(MyTask $l)
	{
		if ($this->collMyTasks === null) {
			$this->initMyTasks();
		}
		if (!in_array($l, $this->collMyTasks, true)) { 			array_push($this->collMyTasks, $l);
			$l->setImageset($this);
		}
	}


	
	public function getMyTasksJoinOiimages($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ImagesetPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMyTasks === null) {
			if ($this->isNew()) {
				$this->collMyTasks = array();
			} else {

				$criteria->add(MyTaskPeer::IMAGESET_ID, $this->id);

				$this->collMyTasks = MyTaskPeer::doSelectJoinOiimages($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(MyTaskPeer::IMAGESET_ID, $this->id);

			if (!isset($this->lastMyTaskCriteria) || !$this->lastMyTaskCriteria->equals($criteria)) {
				$this->collMyTasks = MyTaskPeer::doSelectJoinOiimages($criteria, $con, $join_behavior);
			}
		}
		$this->lastMyTaskCriteria = $criteria;

		return $this->collMyTasks;
	}


	
	public function getMyTasksJoinPc($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ImagesetPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMyTasks === null) {
			if ($this->isNew()) {
				$this->collMyTasks = array();
			} else {

				$criteria->add(MyTaskPeer::IMAGESET_ID, $this->id);

				$this->collMyTasks = MyTaskPeer::doSelectJoinPc($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(MyTaskPeer::IMAGESET_ID, $this->id);

			if (!isset($this->lastMyTaskCriteria) || !$this->lastMyTaskCriteria->equals($criteria)) {
				$this->collMyTasks = MyTaskPeer::doSelectJoinPc($criteria, $con, $join_behavior);
			}
		}
		$this->lastMyTaskCriteria = $criteria;

		return $this->collMyTasks;
	}

	
	public function clearAsignImagesets()
	{
		$this->collAsignImagesets = null; 	}

	
	public function initAsignImagesets()
	{
		$this->collAsignImagesets = array();
	}

	
	public function getAsignImagesets($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ImagesetPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAsignImagesets === null) {
			if ($this->isNew()) {
			   $this->collAsignImagesets = array();
			} else {

				$criteria->add(AsignImagesetPeer::IMAGESET_ID, $this->id);

				AsignImagesetPeer::addSelectColumns($criteria);
				$this->collAsignImagesets = AsignImagesetPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AsignImagesetPeer::IMAGESET_ID, $this->id);

				AsignImagesetPeer::addSelectColumns($criteria);
				if (!isset($this->lastAsignImagesetCriteria) || !$this->lastAsignImagesetCriteria->equals($criteria)) {
					$this->collAsignImagesets = AsignImagesetPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAsignImagesetCriteria = $criteria;
		return $this->collAsignImagesets;
	}

	
	public function countAsignImagesets(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ImagesetPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collAsignImagesets === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(AsignImagesetPeer::IMAGESET_ID, $this->id);

				$count = AsignImagesetPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AsignImagesetPeer::IMAGESET_ID, $this->id);

				if (!isset($this->lastAsignImagesetCriteria) || !$this->lastAsignImagesetCriteria->equals($criteria)) {
					$count = AsignImagesetPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collAsignImagesets);
				}
			} else {
				$count = count($this->collAsignImagesets);
			}
		}
		$this->lastAsignImagesetCriteria = $criteria;
		return $count;
	}

	
	public function addAsignImageset(AsignImageset $l)
	{
		if ($this->collAsignImagesets === null) {
			$this->initAsignImagesets();
		}
		if (!in_array($l, $this->collAsignImagesets, true)) { 			array_push($this->collAsignImagesets, $l);
			$l->setImageset($this);
		}
	}


	
	public function getAsignImagesetsJoinOiimages($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(ImagesetPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAsignImagesets === null) {
			if ($this->isNew()) {
				$this->collAsignImagesets = array();
			} else {

				$criteria->add(AsignImagesetPeer::IMAGESET_ID, $this->id);

				$this->collAsignImagesets = AsignImagesetPeer::doSelectJoinOiimages($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(AsignImagesetPeer::IMAGESET_ID, $this->id);

			if (!isset($this->lastAsignImagesetCriteria) || !$this->lastAsignImagesetCriteria->equals($criteria)) {
				$this->collAsignImagesets = AsignImagesetPeer::doSelectJoinOiimages($criteria, $con, $join_behavior);
			}
		}
		$this->lastAsignImagesetCriteria = $criteria;

		return $this->collAsignImagesets;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collMyTasks) {
				foreach ((array) $this->collMyTasks as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collAsignImagesets) {
				foreach ((array) $this->collAsignImagesets as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collMyTasks = null;
		$this->collAsignImagesets = null;
	}

} 