<?php



class PathMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.PathMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(PathPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PathPeer::TABLE_NAME);
		$tMap->setPhpName('Path');
		$tMap->setClassname('Path');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('DRIVER_ID', 'DriverId', 'INTEGER', 'driver', 'ID', true, null);

		$tMap->addColumn('PATH', 'Path', 'LONGVARCHAR', false, null);

	} 
} 