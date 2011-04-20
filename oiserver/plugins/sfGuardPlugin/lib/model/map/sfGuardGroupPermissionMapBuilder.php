<?php



class sfGuardGroupPermissionMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'plugins.sfGuardPlugin.lib.model.map.sfGuardGroupPermissionMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(sfGuardGroupPermissionPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(sfGuardGroupPermissionPeer::TABLE_NAME);
		$tMap->setPhpName('sfGuardGroupPermission');
		$tMap->setClassname('sfGuardGroupPermission');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('GROUP_ID', 'GroupId', 'INTEGER' , 'sf_guard_group', 'ID', true, null);

		$tMap->addForeignPrimaryKey('PERMISSION_ID', 'PermissionId', 'INTEGER' , 'sf_guard_permission', 'ID', true, null);

	} 
} 