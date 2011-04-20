<?php



class DriverMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.DriverMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(DriverPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(DriverPeer::TABLE_NAME);
		$tMap->setPhpName('Driver');
		$tMap->setClassname('Driver');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('TYPE_ID', 'TypeId', 'SMALLINT', 'type', 'ID', true, null);

		$tMap->addForeignKey('VENDOR_ID', 'VendorId', 'VARCHAR', 'vendor', 'CODE', true, 4);

		$tMap->addForeignKey('DEVICE_ID', 'DeviceId', 'VARCHAR', 'device', 'CODE', true, 4);

		$tMap->addColumn('CLASS_TYPE', 'ClassType', 'VARCHAR', false, 100);

		$tMap->addColumn('NAME', 'Name', 'LONGVARCHAR', false, null);

		$tMap->addColumn('DATE', 'Date', 'DATE', false, null);

		$tMap->addColumn('STRING', 'String', 'VARCHAR', true, 255);

		$tMap->addColumn('URL', 'Url', 'VARCHAR', false, 255);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} 
} 