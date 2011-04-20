<?php



class sfGuardUserMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'plugins.sfGuardPlugin.lib.model.map.sfGuardUserMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(sfGuardUserPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(sfGuardUserPeer::TABLE_NAME);
		$tMap->setPhpName('sfGuardUser');
		$tMap->setClassname('sfGuardUser');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('USERNAME', 'Username', 'VARCHAR', true, 128);

		$tMap->addColumn('ALGORITHM', 'Algorithm', 'VARCHAR', true, 128);

		$tMap->addColumn('SALT', 'Salt', 'VARCHAR', true, 128);

		$tMap->addColumn('PASSWORD', 'Password', 'VARCHAR', true, 128);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

		$tMap->addColumn('LAST_LOGIN', 'LastLogin', 'TIMESTAMP', false, null);

		$tMap->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', true, null);

		$tMap->addColumn('IS_SUPER_ADMIN', 'IsSuperAdmin', 'BOOLEAN', true, null);

	} 
} 