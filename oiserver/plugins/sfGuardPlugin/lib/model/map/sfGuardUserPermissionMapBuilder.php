<?php



class sfGuardUserPermissionMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'plugins.sfGuardPlugin.lib.model.map.sfGuardUserPermissionMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(sfGuardUserPermissionPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(sfGuardUserPermissionPeer::TABLE_NAME);
		$tMap->setPhpName('sfGuardUserPermission');
		$tMap->setClassname('sfGuardUserPermission');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'sf_guard_user', 'ID', true, null);

		$tMap->addForeignPrimaryKey('PERMISSION_ID', 'PermissionId', 'INTEGER' , 'sf_guard_permission', 'ID', true, null);

	} 
} 