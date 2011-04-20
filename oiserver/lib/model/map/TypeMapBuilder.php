<?php



class TypeMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TypeMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(TypePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(TypePeer::TABLE_NAME);
		$tMap->setPhpName('Type');
		$tMap->setClassname('Type');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'SMALLINT', true, null);

		$tMap->addColumn('TYPE', 'Type', 'VARCHAR', true, 10);

	} 
} 