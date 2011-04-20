<?php



class CatalogueMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.CatalogueMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(CataloguePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(CataloguePeer::TABLE_NAME);
		$tMap->setPhpName('Catalogue');
		$tMap->setClassname('Catalogue');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('CAT_ID', 'CatId', 'INTEGER', true, 11);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 100);

		$tMap->addColumn('SOURCE_LANG', 'SourceLang', 'VARCHAR', false, 100);

		$tMap->addColumn('TARGET_LANG', 'TargetLang', 'VARCHAR', false, 100);

		$tMap->addColumn('DATE_CREATED', 'DateCreated', 'TIMESTAMP', false, null);

		$tMap->addColumn('DATE_MODIFIED', 'DateModified', 'TIMESTAMP', false, null);

		$tMap->addColumn('AUTHOR', 'Author', 'VARCHAR', false, 255);

	} 
} 