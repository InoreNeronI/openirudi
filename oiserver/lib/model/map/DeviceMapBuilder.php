<?php



class DeviceMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.DeviceMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(DevicePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(DevicePeer::TABLE_NAME);
		$tMap->setPhpName('Device');
		$tMap->setClassname('Device');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('CODE', 'Code', 'VARCHAR', true, 4);

		$tMap->addForeignKey('VENDOR_ID', 'VendorId', 'VARCHAR', 'vendor', 'CODE', true, 4);

		$tMap->addForeignKey('TYPE_ID', 'TypeId', 'SMALLINT', 'type', 'ID', true, null);

		$tMap->addColumn('NAME', 'Name', 'LONGVARCHAR', false, null);

	} 
} 