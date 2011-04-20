<?php



class SystemMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SystemMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(SystemPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(SystemPeer::TABLE_NAME);
		$tMap->setPhpName('System');
		$tMap->setClassname('System');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('DRIVER_ID', 'DriverId', 'INTEGER', 'driver', 'ID', true, null);

		$tMap->addColumn('NAME', 'Name', 'LONGVARCHAR', false, null);

	} 
} 