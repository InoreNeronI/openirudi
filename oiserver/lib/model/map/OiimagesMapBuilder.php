<?php



class OiimagesMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OiimagesMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(OiimagesPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(OiimagesPeer::TABLE_NAME);
		$tMap->setPhpName('Oiimages');
		$tMap->setClassname('Oiimages');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('REF', 'Ref', 'VARCHAR', false, 50);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', false, 50);

		$tMap->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, null);

		$tMap->addColumn('OS', 'Os', 'VARCHAR', false, 50);

		$tMap->addColumn('UUID', 'Uuid', 'VARCHAR', false, 50);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('PARTITION_SIZE', 'PartitionSize', 'INTEGER', false, 11);

		$tMap->addColumn('PARTITION_TYPE', 'PartitionType', 'TINYINT', true, 4);

		$tMap->addColumn('FILESYSTEM_SIZE', 'FilesystemSize', 'INTEGER', false, 11);

		$tMap->addColumn('FILESYSTEM_TYPE', 'FilesystemType', 'VARCHAR', true, 50);

		$tMap->addColumn('PATH', 'Path', 'VARCHAR', false, 250);

	} 
} 