<?php



class MyTaskMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.MyTaskMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(MyTaskPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(MyTaskPeer::TABLE_NAME);
		$tMap->setPhpName('MyTask');
		$tMap->setClassname('MyTask');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('DAY', 'Day', 'DATE', false, null);

		$tMap->addColumn('HOUR', 'Hour', 'TIME', false, null);

		$tMap->addColumn('ASSOCIATE', 'Associate', 'BOOLEAN', false, null);

		$tMap->addForeignKey('OIIMAGES_ID', 'OiimagesId', 'INTEGER', 'oiimages', 'ID', false, null);

		$tMap->addColumn('PARTITION', 'Partition', 'VARCHAR', false, 20);

		$tMap->addForeignKey('PC_ID', 'PcId', 'INTEGER', 'pc', 'ID', false, null);

		$tMap->addColumn('IS_IMAGESET', 'IsImageset', 'BOOLEAN', false, null);

		$tMap->addForeignKey('IMAGESET_ID', 'ImagesetId', 'INTEGER', 'imageset', 'ID', false, null);

		$tMap->addColumn('IS_BOOT', 'IsBoot', 'BOOLEAN', false, null);

		$tMap->addColumn('DISK', 'Disk', 'VARCHAR', false, 20);

	} 
} 