<?php



class ComputerMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ComputerMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('computer');
		$tMap->setPhpName('Computer');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('MAC', 'Mac', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('GROUPS', 'Groups', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('HW', 'Hw', 'string', CreoleTypes::LONGVARCHAR, false, null);

	} 
} 