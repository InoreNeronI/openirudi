<?php


abstract class BasePc extends BaseObject  implements Persistent {


  const PEER = 'PcPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $mac;

	
	protected $hddid;

	
	protected $name;

	
	protected $ip;

	
	protected $netmask;

	
	protected $gateway;

	
	protected $dns;

	
	protected $pcgroup_id;

	
	protected $partitions;

	
	protected $aPcgroup;

	
	protected $collMyTasks;

	
	private $lastMyTaskCriteria = null;

	
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

	
	public function getMac()
	{
		return $this->mac;
	}

	
	public function getHddid()
	{
		return $this->hddid;
	}

	
	public function getName()
	{
		return $this->name;
	}

	
	public function getIp()
	{
		return $this->ip;
	}

	
	public function getNetmask()
	{
		return $this->netmask;
	}

	
	public function getGateway()
	{
		return $this->gateway;
	}

	
	public function getDns()
	{
		return $this->dns;
	}

	
	public function getPcgroupId()
	{
		return $this->pcgroup_id;
	}

	
	public function getPartitions()
	{
		return $this->partitions;
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PcPeer::ID;
		}

		return $this;
	} 
	
	public function setMac($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->mac !== $v) {
			$this->mac = $v;
			$this->modifiedColumns[] = PcPeer::MAC;
		}

		return $this;
	} 
	
	public function setHddid($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->hddid !== $v) {
			$this->hddid = $v;
			$this->modifiedColumns[] = PcPeer::HDDID;
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
			$this->modifiedColumns[] = PcPeer::NAME;
		}

		return $this;
	} 
	
	public function setIp($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->ip !== $v) {
			$this->ip = $v;
			$this->modifiedColumns[] = PcPeer::IP;
		}

		return $this;
	} 
	
	public function setNetmask($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->netmask !== $v) {
			$this->netmask = $v;
			$this->modifiedColumns[] = PcPeer::NETMASK;
		}

		return $this;
	} 
	
	public function setGateway($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->gateway !== $v) {
			$this->gateway = $v;
			$this->modifiedColumns[] = PcPeer::GATEWAY;
		}

		return $this;
	} 
	
	public function setDns($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->dns !== $v) {
			$this->dns = $v;
			$this->modifiedColumns[] = PcPeer::DNS;
		}

		return $this;
	} 
	
	public function setPcgroupId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->pcgroup_id !== $v) {
			$this->pcgroup_id = $v;
			$this->modifiedColumns[] = PcPeer::PCGROUP_ID;
		}

		if ($this->aPcgroup !== null && $this->aPcgroup->getId() !== $v) {
			$this->aPcgroup = null;
		}

		return $this;
	} 
	
	public function setPartitions($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->partitions !== $v) {
			$this->partitions = $v;
			$this->modifiedColumns[] = PcPeer::PARTITIONS;
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
			$this->mac = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->hddid = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->ip = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->netmask = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->gateway = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->dns = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->pcgroup_id = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->partitions = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Pc object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aPcgroup !== null && $this->pcgroup_id !== $this->aPcgroup->getId()) {
			$this->aPcgroup = null;
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
			$con = Propel::getConnection(PcPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = PcPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aPcgroup = null;
			$this->collMyTasks = null;
			$this->lastMyTaskCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PcPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			PcPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(PcPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			PcPeer::addInstanceToPool($this);
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

												
			if ($this->aPcgroup !== null) {
				if ($this->aPcgroup->isModified() || $this->aPcgroup->isNew()) {
					$affectedRows += $this->aPcgroup->save($con);
				}
				$this->setPcgroup($this->aPcgroup);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = PcPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PcPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += PcPeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collMyTasks !== null) {
				foreach ($this->collMyTasks as $referrerFK) {
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


												
			if ($this->aPcgroup !== null) {
				if (!$this->aPcgroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPcgroup->getValidationFailures());
				}
			}


			if (($retval = PcPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collMyTasks !== null) {
					foreach ($this->collMyTasks as $referrerFK) {
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
		$pos = PcPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getMac();
				break;
			case 2:
				return $this->getHddid();
				break;
			case 3:
				return $this->getName();
				break;
			case 4:
				return $this->getIp();
				break;
			case 5:
				return $this->getNetmask();
				break;
			case 6:
				return $this->getGateway();
				break;
			case 7:
				return $this->getDns();
				break;
			case 8:
				return $this->getPcgroupId();
				break;
			case 9:
				return $this->getPartitions();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = PcPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getMac(),
			$keys[2] => $this->getHddid(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getIp(),
			$keys[5] => $this->getNetmask(),
			$keys[6] => $this->getGateway(),
			$keys[7] => $this->getDns(),
			$keys[8] => $this->getPcgroupId(),
			$keys[9] => $this->getPartitions(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PcPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setMac($value);
				break;
			case 2:
				$this->setHddid($value);
				break;
			case 3:
				$this->setName($value);
				break;
			case 4:
				$this->setIp($value);
				break;
			case 5:
				$this->setNetmask($value);
				break;
			case 6:
				$this->setGateway($value);
				break;
			case 7:
				$this->setDns($value);
				break;
			case 8:
				$this->setPcgroupId($value);
				break;
			case 9:
				$this->setPartitions($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = PcPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setMac($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setHddid($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setIp($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setNetmask($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setGateway($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDns($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setPcgroupId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setPartitions($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(PcPeer::DATABASE_NAME);

		if ($this->isColumnModified(PcPeer::ID)) $criteria->add(PcPeer::ID, $this->id);
		if ($this->isColumnModified(PcPeer::MAC)) $criteria->add(PcPeer::MAC, $this->mac);
		if ($this->isColumnModified(PcPeer::HDDID)) $criteria->add(PcPeer::HDDID, $this->hddid);
		if ($this->isColumnModified(PcPeer::NAME)) $criteria->add(PcPeer::NAME, $this->name);
		if ($this->isColumnModified(PcPeer::IP)) $criteria->add(PcPeer::IP, $this->ip);
		if ($this->isColumnModified(PcPeer::NETMASK)) $criteria->add(PcPeer::NETMASK, $this->netmask);
		if ($this->isColumnModified(PcPeer::GATEWAY)) $criteria->add(PcPeer::GATEWAY, $this->gateway);
		if ($this->isColumnModified(PcPeer::DNS)) $criteria->add(PcPeer::DNS, $this->dns);
		if ($this->isColumnModified(PcPeer::PCGROUP_ID)) $criteria->add(PcPeer::PCGROUP_ID, $this->pcgroup_id);
		if ($this->isColumnModified(PcPeer::PARTITIONS)) $criteria->add(PcPeer::PARTITIONS, $this->partitions);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(PcPeer::DATABASE_NAME);

		$criteria->add(PcPeer::ID, $this->id);

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

		$copyObj->setMac($this->mac);

		$copyObj->setHddid($this->hddid);

		$copyObj->setName($this->name);

		$copyObj->setIp($this->ip);

		$copyObj->setNetmask($this->netmask);

		$copyObj->setGateway($this->gateway);

		$copyObj->setDns($this->dns);

		$copyObj->setPcgroupId($this->pcgroup_id);

		$copyObj->setPartitions($this->partitions);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getMyTasks() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addMyTask($relObj->copy($deepCopy));
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
			self::$peer = new PcPeer();
		}
		return self::$peer;
	}

	
	public function setPcgroup(Pcgroup $v = null)
	{
		if ($v === null) {
			$this->setPcgroupId(NULL);
		} else {
			$this->setPcgroupId($v->getId());
		}

		$this->aPcgroup = $v;

						if ($v !== null) {
			$v->addPc($this);
		}

		return $this;
	}


	
	public function getPcgroup(PropelPDO $con = null)
	{
		if ($this->aPcgroup === null && ($this->pcgroup_id !== null)) {
			$c = new Criteria(PcgroupPeer::DATABASE_NAME);
			$c->add(PcgroupPeer::ID, $this->pcgroup_id);
			$this->aPcgroup = PcgroupPeer::doSelectOne($c, $con);
			
		}
		return $this->aPcgroup;
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
			$criteria = new Criteria(PcPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMyTasks === null) {
			if ($this->isNew()) {
			   $this->collMyTasks = array();
			} else {

				$criteria->add(MyTaskPeer::PC_ID, $this->id);

				MyTaskPeer::addSelectColumns($criteria);
				$this->collMyTasks = MyTaskPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MyTaskPeer::PC_ID, $this->id);

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
			$criteria = new Criteria(PcPeer::DATABASE_NAME);
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

				$criteria->add(MyTaskPeer::PC_ID, $this->id);

				$count = MyTaskPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MyTaskPeer::PC_ID, $this->id);

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
			$l->setPc($this);
		}
	}


	
	public function getMyTasksJoinOiimages($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMyTasks === null) {
			if ($this->isNew()) {
				$this->collMyTasks = array();
			} else {

				$criteria->add(MyTaskPeer::PC_ID, $this->id);

				$this->collMyTasks = MyTaskPeer::doSelectJoinOiimages($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(MyTaskPeer::PC_ID, $this->id);

			if (!isset($this->lastMyTaskCriteria) || !$this->lastMyTaskCriteria->equals($criteria)) {
				$this->collMyTasks = MyTaskPeer::doSelectJoinOiimages($criteria, $con, $join_behavior);
			}
		}
		$this->lastMyTaskCriteria = $criteria;

		return $this->collMyTasks;
	}


	
	public function getMyTasksJoinImageset($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(PcPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMyTasks === null) {
			if ($this->isNew()) {
				$this->collMyTasks = array();
			} else {

				$criteria->add(MyTaskPeer::PC_ID, $this->id);

				$this->collMyTasks = MyTaskPeer::doSelectJoinImageset($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(MyTaskPeer::PC_ID, $this->id);

			if (!isset($this->lastMyTaskCriteria) || !$this->lastMyTaskCriteria->equals($criteria)) {
				$this->collMyTasks = MyTaskPeer::doSelectJoinImageset($criteria, $con, $join_behavior);
			}
		}
		$this->lastMyTaskCriteria = $criteria;

		return $this->collMyTasks;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collMyTasks) {
				foreach ((array) $this->collMyTasks as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collMyTasks = null;
			$this->aPcgroup = null;
	}

} 