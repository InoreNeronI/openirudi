<?php



class PackMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.PackMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(PackPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PackPeer::TABLE_NAME);
		$tMap->setPhpName('Pack');
		$tMap->setClassname('Pack');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addForeignKey('PATH_ID', 'PathId', 'INTEGER', 'path', 'ID', true, null);

		$tMap->addColumn('NAME', 'Name', 'LONGVARCHAR', false, null);

		$tMap->addColumn('VERSION', 'Version', 'VARCHAR', false, 10);

		$tMap->addColumn('RELEASE_DATE', 'ReleaseDate', 'TIMESTAMP', false, null);

	} 
} 