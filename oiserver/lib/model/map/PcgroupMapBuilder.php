<?php



class PcgroupMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.PcgroupMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(PcgroupPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcgroupPeer::TABLE_NAME);
		$tMap->setPhpName('Pcgroup');
		$tMap->setClassname('Pcgroup');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 255);

	} 
} 