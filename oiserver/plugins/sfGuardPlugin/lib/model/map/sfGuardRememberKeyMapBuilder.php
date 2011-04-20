<?php



class sfGuardRememberKeyMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'plugins.sfGuardPlugin.lib.model.map.sfGuardRememberKeyMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(sfGuardRememberKeyPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(sfGuardRememberKeyPeer::TABLE_NAME);
		$tMap->setPhpName('sfGuardRememberKey');
		$tMap->setClassname('sfGuardRememberKey');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'sf_guard_user', 'ID', true, null);

		$tMap->addColumn('REMEMBER_KEY', 'RememberKey', 'VARCHAR', false, 32);

		$tMap->addPrimaryKey('IP_ADDRESS', 'IpAddress', 'VARCHAR', true, 50);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null);

	} 
} 