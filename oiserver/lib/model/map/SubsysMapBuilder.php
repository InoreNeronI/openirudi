<?php



class SubsysMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SubsysMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(SubsysPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(SubsysPeer::TABLE_NAME);
		$tMap->setPhpName('Subsys');
		$tMap->setClassname('Subsys');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('CODE', 'Code', 'VARCHAR', true, 8);

		$tMap->addForeignPrimaryKey('DEVICE_ID', 'DeviceId', 'INTEGER' , 'device', 'ID', true, null);

		$tMap->addPrimaryKey('REVISION', 'Revision', 'VARCHAR', true, 2);

		$tMap->addColumn('NAME', 'Name', 'LONGVARCHAR', false, null);

	} 
} 