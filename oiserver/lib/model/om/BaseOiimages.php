<?php


abstract class BaseOiimages extends BaseObject  implements Persistent {


  const PEER = 'OiimagesPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $ref;

	
	protected $name;

	
	protected $description;

	
	protected $os;

	
	protected $uuid;

	
	protected $created_at;

	
	protected $partition_size;

	
	protected $partition_type;

	
	protected $filesystem_size;

	
	protected $filesystem_type;

	
	protected $path;

	
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

	
	public function getRef()
	{
		return $this->ref;
	}

	
	public function getName()
	{
		return $this->name;
	}

	
	public function getDescription()
	{
		return $this->description;
	}

	
	public function getOs()
	{
		return $this->os;
	}

	
	public function getUuid()
	{
		return $this->uuid;
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

	
	public function getPartitionSize()
	{
		return $this->partition_size;
	}

	
	public function getPartitionType()
	{
		return $this->partition_type;
	}

	
	public function getFilesystemSize()
	{
		return $this->filesystem_size;
	}

	
	public function getFilesystemType()
	{
		return $this->filesystem_type;
	}

	
	public function getPath()
	{
		return $this->path;
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OiimagesPeer::ID;
		}

		return $this;
	} 
	
	public function setRef($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->ref !== $v) {
			$this->ref = $v;
			$this->modifiedColumns[] = OiimagesPeer::REF;
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
			$this->modifiedColumns[] = OiimagesPeer::NAME;
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
			$this->modifiedColumns[] = OiimagesPeer::DESCRIPTION;
		}

		return $this;
	} 
	
	public function setOs($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->os !== $v) {
			$this->os = $v;
			$this->modifiedColumns[] = OiimagesPeer::OS;
		}

		return $this;
	} 
	
	public function setUuid($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->uuid !== $v) {
			$this->uuid = $v;
			$this->modifiedColumns[] = OiimagesPeer::UUID;
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
				$this->modifiedColumns[] = OiimagesPeer::CREATED_AT;
			}
		} 
		return $this;
	} 
	
	public function setPartitionSize($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->partition_size !== $v) {
			$this->partition_size = $v;
			$this->modifiedColumns[] = OiimagesPeer::PARTITION_SIZE;
		}

		return $this;
	} 
	
	public function setPartitionType($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->partition_type !== $v) {
			$this->partition_type = $v;
			$this->modifiedColumns[] = OiimagesPeer::PARTITION_TYPE;
		}

		return $this;
	} 
	
	public function setFilesystemSize($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->filesystem_size !== $v) {
			$this->filesystem_size = $v;
			$this->modifiedColumns[] = OiimagesPeer::FILESYSTEM_SIZE;
		}

		return $this;
	} 
	
	public function setFilesystemType($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->filesystem_type !== $v) {
			$this->filesystem_type = $v;
			$this->modifiedColumns[] = OiimagesPeer::FILESYSTEM_TYPE;
		}

		return $this;
	} 
	
	public function setPath($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->path !== $v) {
			$this->path = $v;
			$this->modifiedColumns[] = OiimagesPeer::PATH;
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
			$this->ref = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->description = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->os = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->uuid = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->created_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->partition_size = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->partition_type = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->filesystem_size = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->filesystem_type = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
			$this->path = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 12; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Oiimages object", $e);
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
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = OiimagesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			OiimagesPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	
	public function save(PropelPDO $con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(OiimagesPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OiimagesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			OiimagesPeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = OiimagesPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OiimagesPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OiimagesPeer::doUpdate($this, $con);
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


			if (($retval = OiimagesPeer::doValidate($this, $columns)) !== true) {
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
		$pos = OiimagesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getRef();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getDescription();
				break;
			case 4:
				return $this->getOs();
				break;
			case 5:
				return $this->getUuid();
				break;
			case 6:
				return $this->getCreatedAt();
				break;
			case 7:
				return $this->getPartitionSize();
				break;
			case 8:
				return $this->getPartitionType();
				break;
			case 9:
				return $this->getFilesystemSize();
				break;
			case 10:
				return $this->getFilesystemType();
				break;
			case 11:
				return $this->getPath();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = OiimagesPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getRef(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getDescription(),
			$keys[4] => $this->getOs(),
			$keys[5] => $this->getUuid(),
			$keys[6] => $this->getCreatedAt(),
			$keys[7] => $this->getPartitionSize(),
			$keys[8] => $this->getPartitionType(),
			$keys[9] => $this->getFilesystemSize(),
			$keys[10] => $this->getFilesystemType(),
			$keys[11] => $this->getPath(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OiimagesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setRef($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setDescription($value);
				break;
			case 4:
				$this->setOs($value);
				break;
			case 5:
				$this->setUuid($value);
				break;
			case 6:
				$this->setCreatedAt($value);
				break;
			case 7:
				$this->setPartitionSize($value);
				break;
			case 8:
				$this->setPartitionType($value);
				break;
			case 9:
				$this->setFilesystemSize($value);
				break;
			case 10:
				$this->setFilesystemType($value);
				break;
			case 11:
				$this->setPath($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OiimagesPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setRef($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOs($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setUuid($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPartitionSize($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setPartitionType($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setFilesystemSize($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setFilesystemType($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setPath($arr[$keys[11]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);

		if ($this->isColumnModified(OiimagesPeer::ID)) $criteria->add(OiimagesPeer::ID, $this->id);
		if ($this->isColumnModified(OiimagesPeer::REF)) $criteria->add(OiimagesPeer::REF, $this->ref);
		if ($this->isColumnModified(OiimagesPeer::NAME)) $criteria->add(OiimagesPeer::NAME, $this->name);
		if ($this->isColumnModified(OiimagesPeer::DESCRIPTION)) $criteria->add(OiimagesPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(OiimagesPeer::OS)) $criteria->add(OiimagesPeer::OS, $this->os);
		if ($this->isColumnModified(OiimagesPeer::UUID)) $criteria->add(OiimagesPeer::UUID, $this->uuid);
		if ($this->isColumnModified(OiimagesPeer::CREATED_AT)) $criteria->add(OiimagesPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(OiimagesPeer::PARTITION_SIZE)) $criteria->add(OiimagesPeer::PARTITION_SIZE, $this->partition_size);
		if ($this->isColumnModified(OiimagesPeer::PARTITION_TYPE)) $criteria->add(OiimagesPeer::PARTITION_TYPE, $this->partition_type);
		if ($this->isColumnModified(OiimagesPeer::FILESYSTEM_SIZE)) $criteria->add(OiimagesPeer::FILESYSTEM_SIZE, $this->filesystem_size);
		if ($this->isColumnModified(OiimagesPeer::FILESYSTEM_TYPE)) $criteria->add(OiimagesPeer::FILESYSTEM_TYPE, $this->filesystem_type);
		if ($this->isColumnModified(OiimagesPeer::PATH)) $criteria->add(OiimagesPeer::PATH, $this->path);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);

		$criteria->add(OiimagesPeer::ID, $this->id);

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

		$copyObj->setRef($this->ref);

		$copyObj->setName($this->name);

		$copyObj->setDescription($this->description);

		$copyObj->setOs($this->os);

		$copyObj->setUuid($this->uuid);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setPartitionSize($this->partition_size);

		$copyObj->setPartitionType($this->partition_type);

		$copyObj->setFilesystemSize($this->filesystem_size);

		$copyObj->setFilesystemType($this->filesystem_type);

		$copyObj->setPath($this->path);


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
			self::$peer = new OiimagesPeer();
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
			$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMyTasks === null) {
			if ($this->isNew()) {
			   $this->collMyTasks = array();
			} else {

				$criteria->add(MyTaskPeer::OIIMAGES_ID, $this->id);

				MyTaskPeer::addSelectColumns($criteria);
				$this->collMyTasks = MyTaskPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MyTaskPeer::OIIMAGES_ID, $this->id);

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
			$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);
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

				$criteria->add(MyTaskPeer::OIIMAGES_ID, $this->id);

				$count = MyTaskPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(MyTaskPeer::OIIMAGES_ID, $this->id);

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
			$l->setOiimages($this);
		}
	}


	
	public function getMyTasksJoinPc($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMyTasks === null) {
			if ($this->isNew()) {
				$this->collMyTasks = array();
			} else {

				$criteria->add(MyTaskPeer::OIIMAGES_ID, $this->id);

				$this->collMyTasks = MyTaskPeer::doSelectJoinPc($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(MyTaskPeer::OIIMAGES_ID, $this->id);

			if (!isset($this->lastMyTaskCriteria) || !$this->lastMyTaskCriteria->equals($criteria)) {
				$this->collMyTasks = MyTaskPeer::doSelectJoinPc($criteria, $con, $join_behavior);
			}
		}
		$this->lastMyTaskCriteria = $criteria;

		return $this->collMyTasks;
	}


	
	public function getMyTasksJoinImageset($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collMyTasks === null) {
			if ($this->isNew()) {
				$this->collMyTasks = array();
			} else {

				$criteria->add(MyTaskPeer::OIIMAGES_ID, $this->id);

				$this->collMyTasks = MyTaskPeer::doSelectJoinImageset($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(MyTaskPeer::OIIMAGES_ID, $this->id);

			if (!isset($this->lastMyTaskCriteria) || !$this->lastMyTaskCriteria->equals($criteria)) {
				$this->collMyTasks = MyTaskPeer::doSelectJoinImageset($criteria, $con, $join_behavior);
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
			$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAsignImagesets === null) {
			if ($this->isNew()) {
			   $this->collAsignImagesets = array();
			} else {

				$criteria->add(AsignImagesetPeer::OIIMAGES_ID, $this->id);

				AsignImagesetPeer::addSelectColumns($criteria);
				$this->collAsignImagesets = AsignImagesetPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AsignImagesetPeer::OIIMAGES_ID, $this->id);

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
			$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);
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

				$criteria->add(AsignImagesetPeer::OIIMAGES_ID, $this->id);

				$count = AsignImagesetPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(AsignImagesetPeer::OIIMAGES_ID, $this->id);

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
			$l->setOiimages($this);
		}
	}


	
	public function getAsignImagesetsJoinImageset($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		if ($criteria === null) {
			$criteria = new Criteria(OiimagesPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAsignImagesets === null) {
			if ($this->isNew()) {
				$this->collAsignImagesets = array();
			} else {

				$criteria->add(AsignImagesetPeer::OIIMAGES_ID, $this->id);

				$this->collAsignImagesets = AsignImagesetPeer::doSelectJoinImageset($criteria, $con, $join_behavior);
			}
		} else {
									
			$criteria->add(AsignImagesetPeer::OIIMAGES_ID, $this->id);

			if (!isset($this->lastAsignImagesetCriteria) || !$this->lastAsignImagesetCriteria->equals($criteria)) {
				$this->collAsignImagesets = AsignImagesetPeer::doSelectJoinImageset($criteria, $con, $join_behavior);
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