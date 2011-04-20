<?php


abstract class BaseTransUnit extends BaseObject  implements Persistent {


  const PEER = 'TransUnitPeer';

	
	protected static $peer;

	
	protected $msg_id;

	
	protected $cat_id;

	
	protected $id;

	
	protected $source;

	
	protected $target;

	
	protected $comments;

	
	protected $date_added;

	
	protected $date_modified;

	
	protected $author;

	
	protected $translated;

	
	protected $aCatalogue;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	
	public function applyDefaultValues()
	{
		$this->cat_id = 1;
		$this->author = '';
		$this->translated = false;
	}

	
	public function getMsgId()
	{
		return $this->msg_id;
	}

	
	public function getCatId()
	{
		return $this->cat_id;
	}

	
	public function getId()
	{
		return $this->id;
	}

	
	public function getSource()
	{
		return $this->source;
	}

	
	public function getTarget()
	{
		return $this->target;
	}

	
	public function getComments()
	{
		return $this->comments;
	}

	
	public function getDateAdded($format = 'Y/m/d H:i:s')
	{
		if ($this->date_added === null) {
			return null;
		}


		if ($this->date_added === '0000-00-00 00:00:00') {
									return null;
		} else {
			try {
				$dt = new DateTime($this->date_added);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date_added, true), $x);
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

	
	public function getTranslated()
	{
		return $this->translated;
	}

	
	public function setMsgId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->msg_id !== $v) {
			$this->msg_id = $v;
			$this->modifiedColumns[] = TransUnitPeer::MSG_ID;
		}

		return $this;
	} 
	
	public function setCatId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->cat_id !== $v || $v === 1) {
			$this->cat_id = $v;
			$this->modifiedColumns[] = TransUnitPeer::CAT_ID;
		}

		if ($this->aCatalogue !== null && $this->aCatalogue->getCatId() !== $v) {
			$this->aCatalogue = null;
		}

		return $this;
	} 
	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = TransUnitPeer::ID;
		}

		return $this;
	} 
	
	public function setSource($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->source !== $v) {
			$this->source = $v;
			$this->modifiedColumns[] = TransUnitPeer::SOURCE;
		}

		return $this;
	} 
	
	public function setTarget($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->target !== $v) {
			$this->target = $v;
			$this->modifiedColumns[] = TransUnitPeer::TARGET;
		}

		return $this;
	} 
	
	public function setComments($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->comments !== $v) {
			$this->comments = $v;
			$this->modifiedColumns[] = TransUnitPeer::COMMENTS;
		}

		return $this;
	} 
	
	public function setDateAdded($v)
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

		if ( $this->date_added !== null || $dt !== null ) {
			
			$currNorm = ($this->date_added !== null && $tmpDt = new DateTime($this->date_added)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) 					)
			{
				$this->date_added = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = TransUnitPeer::DATE_ADDED;
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
				$this->modifiedColumns[] = TransUnitPeer::DATE_MODIFIED;
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
			$this->modifiedColumns[] = TransUnitPeer::AUTHOR;
		}

		return $this;
	} 
	
	public function setTranslated($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->translated !== $v || $v === false) {
			$this->translated = $v;
			$this->modifiedColumns[] = TransUnitPeer::TRANSLATED;
		}

		return $this;
	} 
	
	public function hasOnlyDefaultValues()
	{
						if (array_diff($this->modifiedColumns, array(TransUnitPeer::CAT_ID,TransUnitPeer::AUTHOR,TransUnitPeer::TRANSLATED))) {
				return false;
			}

			if ($this->cat_id !== 1) {
				return false;
			}

			if ($this->author !== '') {
				return false;
			}

			if ($this->translated !== false) {
				return false;
			}

				return true;
	} 
	
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->msg_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->cat_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->id = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->source = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->target = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->comments = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->date_added = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->date_modified = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->author = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
			$this->translated = ($row[$startcol + 9] !== null) ? (boolean) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating TransUnit object", $e);
		}
	}

	
	public function ensureConsistency()
	{

		if ($this->aCatalogue !== null && $this->cat_id !== $this->aCatalogue->getCatId()) {
			$this->aCatalogue = null;
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
			$con = Propel::getConnection(TransUnitPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = TransUnitPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
			$this->aCatalogue = null;
		} 	}

	
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TransUnitPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			TransUnitPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(TransUnitPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$affectedRows = $this->doSave($con);
			$con->commit();
			TransUnitPeer::addInstanceToPool($this);
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

												
			if ($this->aCatalogue !== null) {
				if ($this->aCatalogue->isModified() || $this->aCatalogue->isNew()) {
					$affectedRows += $this->aCatalogue->save($con);
				}
				$this->setCatalogue($this->aCatalogue);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = TransUnitPeer::MSG_ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TransUnitPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setMsgId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TransUnitPeer::doUpdate($this, $con);
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


												
			if ($this->aCatalogue !== null) {
				if (!$this->aCatalogue->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aCatalogue->getValidationFailures());
				}
			}


			if (($retval = TransUnitPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TransUnitPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getMsgId();
				break;
			case 1:
				return $this->getCatId();
				break;
			case 2:
				return $this->getId();
				break;
			case 3:
				return $this->getSource();
				break;
			case 4:
				return $this->getTarget();
				break;
			case 5:
				return $this->getComments();
				break;
			case 6:
				return $this->getDateAdded();
				break;
			case 7:
				return $this->getDateModified();
				break;
			case 8:
				return $this->getAuthor();
				break;
			case 9:
				return $this->getTranslated();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = TransUnitPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getMsgId(),
			$keys[1] => $this->getCatId(),
			$keys[2] => $this->getId(),
			$keys[3] => $this->getSource(),
			$keys[4] => $this->getTarget(),
			$keys[5] => $this->getComments(),
			$keys[6] => $this->getDateAdded(),
			$keys[7] => $this->getDateModified(),
			$keys[8] => $this->getAuthor(),
			$keys[9] => $this->getTranslated(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TransUnitPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setMsgId($value);
				break;
			case 1:
				$this->setCatId($value);
				break;
			case 2:
				$this->setId($value);
				break;
			case 3:
				$this->setSource($value);
				break;
			case 4:
				$this->setTarget($value);
				break;
			case 5:
				$this->setComments($value);
				break;
			case 6:
				$this->setDateAdded($value);
				break;
			case 7:
				$this->setDateModified($value);
				break;
			case 8:
				$this->setAuthor($value);
				break;
			case 9:
				$this->setTranslated($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TransUnitPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setMsgId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCatId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSource($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTarget($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setComments($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDateAdded($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setDateModified($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setAuthor($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setTranslated($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TransUnitPeer::DATABASE_NAME);

		if ($this->isColumnModified(TransUnitPeer::MSG_ID)) $criteria->add(TransUnitPeer::MSG_ID, $this->msg_id);
		if ($this->isColumnModified(TransUnitPeer::CAT_ID)) $criteria->add(TransUnitPeer::CAT_ID, $this->cat_id);
		if ($this->isColumnModified(TransUnitPeer::ID)) $criteria->add(TransUnitPeer::ID, $this->id);
		if ($this->isColumnModified(TransUnitPeer::SOURCE)) $criteria->add(TransUnitPeer::SOURCE, $this->source);
		if ($this->isColumnModified(TransUnitPeer::TARGET)) $criteria->add(TransUnitPeer::TARGET, $this->target);
		if ($this->isColumnModified(TransUnitPeer::COMMENTS)) $criteria->add(TransUnitPeer::COMMENTS, $this->comments);
		if ($this->isColumnModified(TransUnitPeer::DATE_ADDED)) $criteria->add(TransUnitPeer::DATE_ADDED, $this->date_added);
		if ($this->isColumnModified(TransUnitPeer::DATE_MODIFIED)) $criteria->add(TransUnitPeer::DATE_MODIFIED, $this->date_modified);
		if ($this->isColumnModified(TransUnitPeer::AUTHOR)) $criteria->add(TransUnitPeer::AUTHOR, $this->author);
		if ($this->isColumnModified(TransUnitPeer::TRANSLATED)) $criteria->add(TransUnitPeer::TRANSLATED, $this->translated);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TransUnitPeer::DATABASE_NAME);

		$criteria->add(TransUnitPeer::MSG_ID, $this->msg_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getMsgId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setMsgId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCatId($this->cat_id);

		$copyObj->setId($this->id);

		$copyObj->setSource($this->source);

		$copyObj->setTarget($this->target);

		$copyObj->setComments($this->comments);

		$copyObj->setDateAdded($this->date_added);

		$copyObj->setDateModified($this->date_modified);

		$copyObj->setAuthor($this->author);

		$copyObj->setTranslated($this->translated);


		$copyObj->setNew(true);

		$copyObj->setMsgId(NULL); 
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
			self::$peer = new TransUnitPeer();
		}
		return self::$peer;
	}

	
	public function setCatalogue(Catalogue $v = null)
	{
		if ($v === null) {
			$this->setCatId(1);
		} else {
			$this->setCatId($v->getCatId());
		}

		$this->aCatalogue = $v;

						if ($v !== null) {
			$v->addTransUnit($this);
		}

		return $this;
	}


	
	public function getCatalogue(PropelPDO $con = null)
	{
		if ($this->aCatalogue === null && ($this->cat_id !== null)) {
			$c = new Criteria(CataloguePeer::DATABASE_NAME);
			$c->add(CataloguePeer::CAT_ID, $this->cat_id);
			$this->aCatalogue = CataloguePeer::doSelectOne($c, $con);
			
		}
		return $this->aCatalogue;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} 
			$this->aCatalogue = null;
	}

} 