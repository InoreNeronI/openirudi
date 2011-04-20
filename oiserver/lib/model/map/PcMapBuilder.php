<?php



class PcMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'lib.model.map.PcMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(PcPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(PcPeer::TABLE_NAME);
		$tMap->setPhpName('Pc');
		$tMap->setClassname('Pc');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('MAC', 'Mac', 'VARCHAR', false, 255);

		$tMap->addColumn('HDDID', 'Hddid', 'VARCHAR', false, 255);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', true, 255);

		$tMap->addColumn('IP', 'Ip', 'VARCHAR', false, 20);

		$tMap->addColumn('NETMASK', 'Netmask', 'VARCHAR', false, 20);

		$tMap->addColumn('GATEWAY', 'Gateway', 'VARCHAR', false, 20);

		$tMap->addColumn('DNS', 'Dns', 'VARCHAR', false, 255);

		$tMap->addForeignKey('PCGROUP_ID', 'PcgroupId', 'INTEGER', 'pcgroup', 'ID', false, null);

		$tMap->addColumn('PARTITIONS', 'Partitions', 'LONGVARCHAR', false, null);

	} 
} 