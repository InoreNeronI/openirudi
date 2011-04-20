<?php


abstract class BasePack extends BaseObject  implements Persistent {


  const PEER = 'PackPeer';

	
	protected static $peer;

	
	protected $id;

	
	protected $path_id;

	
	protected $name;

	
	protected $version;

	
	protected $release_date;

	
	protected $aPath;

	
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

	
	public function getPathId()
	{
		return $this->path_id;
	}

	
	public function getName()
	{
		return $this->name;
	}

	
	public function getVersion()
	{
		return $this->version;
	}

	
	public function getReleaseDate($format = 'Y/m/d H:i:s')
	{
		if ($this->release_date === null) {
			return null;
		}


		if ($this->release_date === '0000-00-00 00:00:00') {
									return null;
		} else {
			try {
				$dt = new DateTime($this->release_date);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->release_date, true), $x);
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
			$this->modifiedColumns[] = PackPeer::ID;
		}

		return $this;
	} 
	
	public function setPathId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->path_id !== $v) {
			$this->path_id = $v;
			$this->modifiedColumns[] = PackPeer::PATH_ID;
		}

		if ($this->aPath !== null && $this->aPath->getId() !== $v) {
			$this->aPath = null;
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
			$this->modifiedColumns[] = PackPeer::NAME;
		}

		return $this;
	} 
	
	public function setVersion($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->version !== $v) {
			$this->version = $v;
			$this->modifiedColumns[] = PackPeer::VERSION;
		}

		return $this;
	} 
	
	public function setReleaseDate($v)
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

		if ( $this->release_date !== null || $dt !== null ) {
			
			$currNorm = ($this->release_date !== null && $tmpDt = new DateTime($this->release_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) 					)
			{
				$this->release_date = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PackPeer::RELEASE_DATE;
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
			$this->path_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->version = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->release_date = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Pack object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aPath !== null && $this->path_id !== $this->aPath->getId()) {
			$this->aPath = null;
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
			$con = Propel::getConnection(PackPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = PackPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aPath = null;
		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PackPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			PackPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(PackPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			PackPeer::addInstanceToPool($this);
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

												
			if ($this->aPath !== null) {
				if ($this->aPath->isModified() || $this->aPath->isNew()) {
					$affectedRows += $this->aPath->save($con);
				}
				$this->setPath($this->aPath);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = PackPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PackPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += PackPeer::doUpdate($this, $con);
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


												
			if ($this->aPath !== null) {
				if (!$this->aPath->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPath->getValidationFailures());
				}
			}


			if (($retval = PackPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getPathId();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getVersion();
				break;
			case 4:
				return $this->getReleaseDate();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = PackPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getPathId(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getVersion(),
			$keys[4] => $this->getReleaseDate(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setPathId($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setVersion($value);
				break;
			case 4:
				$this->setReleaseDate($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = PackPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPathId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setVersion($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setReleaseDate($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(PackPeer::DATABASE_NAME);

		if ($this->isColumnModified(PackPeer::ID)) $criteria->add(PackPeer::ID, $this->id);
		if ($this->isColumnModified(PackPeer::PATH_ID)) $criteria->add(PackPeer::PATH_ID, $this->path_id);
		if ($this->isColumnModified(PackPeer::NAME)) $criteria->add(PackPeer::NAME, $this->name);
		if ($this->isColumnModified(PackPeer::VERSION)) $criteria->add(PackPeer::VERSION, $this->version);
		if ($this->isColumnModified(PackPeer::RELEASE_DATE)) $criteria->add(PackPeer::RELEASE_DATE, $this->release_date);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(PackPeer::DATABASE_NAME);

		$criteria->add(PackPeer::ID, $this->id);

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

		$copyObj->setPathId($this->path_id);

		$copyObj->setName($this->name);

		$copyObj->setVersion($this->version);

		$copyObj->setReleaseDate($this->release_date);


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
			self::$peer = new PackPeer();
		}
		return self::$peer;
	}

	
	public function setPath(Path $v = null)
	{
		if ($v === null) {
			$this->setPathId(NULL);
		} else {
			$this->setPathId($v->getId());
		}

		$this->aPath = $v;

						if ($v !== null) {
			$v->addPack($this);
		}

		return $this;
	}


	
	public function getPath(PropelPDO $con = null)
	{
		if ($this->aPath === null && ($this->path_id !== null)) {
			$c = new Criteria(PathPeer::DATABASE_NAME);
			$c->add(PathPeer::ID, $this->path_id);
			$this->aPath = PathPeer::doSelectOne($c, $con);
			
		}
		return $this->aPath;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} 
			$this->aPath = null;
	}

} 