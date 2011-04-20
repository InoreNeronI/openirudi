<?php



class ImagesetMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ImagesetMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(ImagesetPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ImagesetPeer::TABLE_NAME);
		$tMap->setPhpName('Imageset');
		$tMap->setClassname('Imageset');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 255);

	} 
} 