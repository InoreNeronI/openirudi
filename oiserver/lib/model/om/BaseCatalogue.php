<?php


abstract class BaseCatalogue extends BaseObject  implements Persistent {


  const PEER = 'CataloguePeer';

	
	protected static $peer;

	
	protected $cat_id;

	
	protected $name;

	
	protected $source_lang;

	
	protected $target_lang;

	
	protected $date_created;

	
	protected $date_modified;

	
	protected $author;

	
	protected $collTransUnits;

	
	private $lastTransUnitCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	
	public function applyDefaultValues()
	{
		$this->name = '';
		$this->source_lang = '';
		$this->target_lang = '';
		$this->author = '';
	}

	
	public function getCatId()
	{
		return $this->cat_id;
	}

	
	public function getName()
	{
		return $this->name;
	}

	
	public function getSourceLang()
	{
		return $this->source_lang;
	}

	
	public function getTargetLang()
	{
		return $this->target_lang;
	}

	
	public function getDateCreated($format = 'Y/m/d H:i:s')
	{
		if ($this->date_created === null) {
			return null;
		}


		if ($this->date_created === '0000-00-00 00:00:00') {
									return null;
		} else {
			try {
				$dt = new DateTime($this->date_created);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date_created, true), $x);
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

	
	public function getDateModified($format = 'Y/m/d H:i:s')
	{
		if ($this->date_modified === null) {
			return null;
		}


		if ($this->date_modified === '0000-00-00 00:00:00') {
									return null;
		} else {
			try {
				$dt = new DateTime($this->date_modified);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date_modified, true), $x);
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

	
	public function getAuthor()
	{
		return $this->author;
	}

	
	public function setCatId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->cat_id !== $v) {
			$this->cat_id = $v;
			$this->modifiedColumns[] = CataloguePeer::CAT_ID;
		}

		return $this;
	} 
	
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v || $v === '') {
			$this->name = $v;
			$this->modifiedColumns[] = CataloguePeer::NAME;
		}

		return $this;
	} 
	
	public function setSourceLang($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->source_lang !== $v || $v === '') {
			$this->source_lang = $v;
			$this->modifiedColumns[] = CataloguePeer::SOURCE_LANG;
		}

		return $this;
	} 
	
	public function setTargetLang($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->target_lang !== $v || $v === '') {
			$this->target_lang = $v;
			$this->modifiedColumns[] = CataloguePeer::TARGET_LANG;
		}

		return $this;
	} 
	
	public function setDateCreated($v)
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

		if ( $this->date_created !== null || $dt !== null ) {
			
			$currNorm = ($this->date_created !== null && $tmpDt = new DateTime($this->date_created)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) 					)
			{
				$this->date_created = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = CataloguePeer::DATE_CREATED;
			}
		} 
		return $this;
	} 
	
	public function setDateModified($v)
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

		if ( $this->date_modified !== null || $dt !== null ) {
			
			$currNorm = ($this->date_modified !== null && $tmpDt = new DateTime($this->date_modified)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) 					)
			{
				$this->date_modified = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = CataloguePeer::DATE_MODIFIED;
			}
		} 
		return $this;
	} 
	
	public function setAuthor($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->author !== $v || $v === '') {
			$this->author = $v;
			$this->modifiedColumns[] = CataloguePeer::AUTHOR;
		}

		return $this;
	} 
	
	public function hasOnlyDefaultValues()
	{
						if (array_diff($this->modifiedColumns, array(CataloguePeer::NAME,CataloguePeer::SOURCE_LANG,CataloguePeer::TARGET_LANG,CataloguePeer::AUTHOR))) {
				return false;
			}

			if ($this->name !== '') {
				return false;
			}

			if ($this->source_lang !== '') {
				return false;
			}

			if ($this->target_lang !== '') {
				return false;
			}

			if ($this->author !== '') {
				return false;
			}

				return true;
	} 
	
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->cat_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->source_lang = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->target_lang = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->date_created = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->date_modified = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->author = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 7; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Catalogue object", $e);
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
			$con = Propel::getConnection(CataloguePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = CataloguePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->collTransUnits = null;
			$this->lastTransUnitCriteria = null;

		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CataloguePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			CataloguePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(CataloguePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			CataloguePeer::addInstanceToPool($this);
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
				$this->modifiedColumns[] = CataloguePeer::CAT_ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = CataloguePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setCatId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += CataloguePeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			if ($this->collTransUnits !== null) {
				foreach ($this->collTransUnits as $referrerFK) {
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


			if (($retval = CataloguePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collTransUnits !== null) {
					foreach ($this->collTransUnits as $referrerFK) {
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
		$pos = CataloguePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getCatId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getSourceLang();
				break;
			case 3:
				return $this->getTargetLang();
				break;
			case 4:
				return $this->getDateCreated();
				break;
			case 5:
				return $this->getDateModified();
				break;
			case 6:
				return $this->getAuthor();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = CataloguePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCatId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getSourceLang(),
			$keys[3] => $this->getTargetLang(),
			$keys[4] => $this->getDateCreated(),
			$keys[5] => $this->getDateModified(),
			$keys[6] => $this->getAuthor(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CataloguePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setCatId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setSourceLang($value);
				break;
			case 3:
				$this->setTargetLang($value);
				break;
			case 4:
				$this->setDateCreated($value);
				break;
			case 5:
				$this->setDateModified($value);
				break;
			case 6:
				$this->setAuthor($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CataloguePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCatId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSourceLang($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTargetLang($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDateCreated($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setDateModified($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAuthor($arr[$keys[6]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(CataloguePeer::DATABASE_NAME);

		if ($this->isColumnModified(CataloguePeer::CAT_ID)) $criteria->add(CataloguePeer::CAT_ID, $this->cat_id);
		if ($this->isColumnModified(CataloguePeer::NAME)) $criteria->add(CataloguePeer::NAME, $this->name);
		if ($this->isColumnModified(CataloguePeer::SOURCE_LANG)) $criteria->add(CataloguePeer::SOURCE_LANG, $this->source_lang);
		if ($this->isColumnModified(CataloguePeer::TARGET_LANG)) $criteria->add(CataloguePeer::TARGET_LANG, $this->target_lang);
		if ($this->isColumnModified(CataloguePeer::DATE_CREATED)) $criteria->add(CataloguePeer::DATE_CREATED, $this->date_created);
		if ($this->isColumnModified(CataloguePeer::DATE_MODIFIED)) $criteria->add(CataloguePeer::DATE_MODIFIED, $this->date_modified);
		if ($this->isColumnModified(CataloguePeer::AUTHOR)) $criteria->add(CataloguePeer::AUTHOR, $this->author);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(CataloguePeer::DATABASE_NAME);

		$criteria->add(CataloguePeer::CAT_ID, $this->cat_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getCatId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setCatId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setSourceLang($this->source_lang);

		$copyObj->setTargetLang($this->target_lang);

		$copyObj->setDateCreated($this->date_created);

		$copyObj->setDateModified($this->date_modified);

		$copyObj->setAuthor($this->author);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach ($this->getTransUnits() as $relObj) {
				if ($relObj !== $this) {  					$copyObj->addTransUnit($relObj->copy($deepCopy));
				}
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setCatId(NULL); 
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
			self::$peer = new CataloguePeer();
		}
		return self::$peer;
	}

	
	public function clearTransUnits()
	{
		$this->collTransUnits = null; 	}

	
	public function initTransUnits()
	{
		$this->collTransUnits = array();
	}

	
	public function getTransUnits($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(CataloguePeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTransUnits === null) {
			if ($this->isNew()) {
			   $this->collTransUnits = array();
			} else {

				$criteria->add(TransUnitPeer::CAT_ID, $this->cat_id);

				TransUnitPeer::addSelectColumns($criteria);
				$this->collTransUnits = TransUnitPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TransUnitPeer::CAT_ID, $this->cat_id);

				TransUnitPeer::addSelectColumns($criteria);
				if (!isset($this->lastTransUnitCriteria) || !$this->lastTransUnitCriteria->equals($criteria)) {
					$this->collTransUnits = TransUnitPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTransUnitCriteria = $criteria;
		return $this->collTransUnits;
	}

	
	public function countTransUnits(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(CataloguePeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collTransUnits === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(TransUnitPeer::CAT_ID, $this->cat_id);

				$count = TransUnitPeer::doCount($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TransUnitPeer::CAT_ID, $this->cat_id);

				if (!isset($this->lastTransUnitCriteria) || !$this->lastTransUnitCriteria->equals($criteria)) {
					$count = TransUnitPeer::doCount($criteria, $con);
				} else {
					$count = count($this->collTransUnits);
				}
			} else {
				$count = count($this->collTransUnits);
			}
		}
		$this->lastTransUnitCriteria = $criteria;
		return $count;
	}

	
	public function addTransUnit(TransUnit $l)
	{
		if ($this->collTransUnits === null) {
			$this->initTransUnits();
		}
		if (!in_array($l, $this->collTransUnits, true)) { 			array_push($this->collTransUnits, $l);
			$l->setCatalogue($this);
		}
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collTransUnits) {
				foreach ((array) $this->collTransUnits as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} 
		$this->collTransUnits = null;
	}

} 