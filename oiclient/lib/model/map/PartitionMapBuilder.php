<?php



class PartitionMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.PartitionMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('partition');
		$tMap->setPhpName('Partition');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('SIZE', 'Size', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('BOOTABLE', 'Bootable', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('START', 'Start', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('END', 'End', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CYLS', 'Cyls', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('BLOCKS', 'Blocks', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('DEVICE', 'Device', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 