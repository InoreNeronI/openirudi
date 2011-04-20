<?php



class sfGuardUserGroupMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'plugins.sfGuardPlugin.lib.model.map.sfGuardUserGroupMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(sfGuardUserGroupPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(sfGuardUserGroupPeer::TABLE_NAME);
		$tMap->setPhpName('sfGuardUserGroup');
		$tMap->setClassname('sfGuardUserGroup');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('USER_ID', 'UserId', 'INTEGER' , 'sf_guard_user', 'ID', true, null);

		$tMap->addForeignPrimaryKey('GROUP_ID', 'GroupId', 'INTEGER' , 'sf_guard_group', 'ID', true, null);

	} 
} 