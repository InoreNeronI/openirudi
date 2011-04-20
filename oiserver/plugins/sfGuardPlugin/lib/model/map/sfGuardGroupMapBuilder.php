<?php



class sfGuardGroupMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'plugins.sfGuardPlugin.lib.model.map.sfGuardGroupMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(sfGuardGroupPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(sfGuardGroupPeer::TABLE_NAME);
		$tMap->setPhpName('sfGuardGroup');
		$tMap->setClassname('sfGuardGroup');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 255);

		$tMap->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, null);

	} 
} 