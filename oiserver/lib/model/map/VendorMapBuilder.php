<?php



class VendorMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.VendorMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(VendorPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(VendorPeer::TABLE_NAME);
		$tMap->setPhpName('Vendor');
		$tMap->setClassname('Vendor');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('CODE', 'Code', 'VARCHAR', true, 4);

		$tMap->addForeignPrimaryKey('TYPE_ID', 'TypeId', 'SMALLINT' , 'type', 'ID', true, null);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', false, 255);

	} 
} 