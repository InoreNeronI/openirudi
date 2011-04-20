<?php



class TransUnitMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TransUnitMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(TransUnitPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(TransUnitPeer::TABLE_NAME);
		$tMap->setPhpName('TransUnit');
		$tMap->setClassname('TransUnit');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('MSG_ID', 'MsgId', 'INTEGER', true, 11);

		$tMap->addForeignKey('CAT_ID', 'CatId', 'INTEGER', 'catalogue', 'CAT_ID', true, 11);

		$tMap->addColumn('ID', 'Id', 'VARCHAR', false, 255);

		$tMap->addColumn('SOURCE', 'Source', 'LONGVARCHAR', true, null);

		$tMap->addColumn('TARGET', 'Target', 'LONGVARCHAR', false, null);

		$tMap->addColumn('COMMENTS', 'Comments', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DATE_ADDED', 'DateAdded', 'TIMESTAMP', false, null);

		$tMap->addColumn('DATE_MODIFIED', 'DateModified', 'TIMESTAMP', false, null);

		$tMap->addColumn('AUTHOR', 'Author', 'VARCHAR', false, 255);

		$tMap->addColumn('TRANSLATED', 'Translated', 'BOOLEAN', false, null);

	} 
} 