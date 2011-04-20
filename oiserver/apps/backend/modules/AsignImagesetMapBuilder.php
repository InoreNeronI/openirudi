<?php



class AsignImagesetMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.AsignImagesetMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(AsignImagesetPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(AsignImagesetPeer::TABLE_NAME);
		$tMap->setPhpName('AsignImageset');
		$tMap->setClassname('AsignImageset');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 255);

		$tMap->addForeignKey('IMAGESET_ID', 'ImagesetId', 'INTEGER', 'imageset', 'ID', false, null);

		$tMap->addForeignKey('OIIMAGES_ID', 'OiimagesId', 'INTEGER', 'oiimages', 'ID', false, null);

		$tMap->addColumn('SIZE', 'Size', 'INTEGER', false, 11);

		$tMap->addColumn('POSITION', 'Position', 'INTEGER', false, 11);

		$tMap->addColumn('COLOR', 'Color', 'VARCHAR', false, 10);

	} 
} 