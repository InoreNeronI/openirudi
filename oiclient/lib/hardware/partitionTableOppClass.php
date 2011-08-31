<?php
class partitionTableOppClass {
    private $disk;
    private $table;

    /************************************************************************
	 * ESPECIAL FUNCTIONS
	 **********************************************************************/

    function __construct($disk) {
        $this->disk = $disk;
        $this->set_table();
    }

    function __get($propertyName) {
        try {
            if (property_exists('partitionTableOppClass', $propertyName)) {
                if (empty ($this-> $propertyName)) {
                    $this->__set($propertyName, '');
                }
                return $this-> $propertyName;

            }
            throw new Exception("ooInvalid property name \"{$propertyName}\"");

        } catch (Exception $e) {
            exceptionHandlerClass :: saveError($e->getMessage());
        }
    }

    function __set($propertyName, $value) {
        try {
            if (!property_exists('partitionTableOppClass', $propertyName)) {
                throw new Exception("Invalid property value \"{$propertyName}\"");
            }
            if (method_exists($this, 'set_' . $propertyName)) {
                call_user_func(array (
                        $this,
                        'set_' . $propertyName
                        ), $value);
            } else {
                throw new Exception("*Invalid property value \"{$propertyName}\"");
            }

        } catch (Exception $e) {
            exceptionHandlerClass :: saveError($e->getMessage());
        }
    }

    /************************************************************************
	 * SET FUNCTIONS
	 **********************************************************************/

    function set_table($table='') {
        if (!empty ($this->disk)) {

            if(empty($table)) {
                $this->table = $this->parseTable();
            }else {
                if($this->validateTable($table)) {
                    $this->table=$table;
                }else {
                    exceptionHandlerClass :: saveError("<br>WRONG TABLE INFORMATION");
                    return false;
                }
            }
        } else {
            exceptionHandlerClass :: saveError("<br>Disk not selected !!!");
        }
    }


    function partitions2table($partitions) {

        $table=array();

        foreach($partitions as $partition) {
            $table[$partition->partitionName]['start']=$partition->startSector;
            $table[$partition->partitionName]['size']=$partition->sectors;
            $table[$partition->partitionName]['id']=$partition->partitionTypeId;
            $table[$partition->partitionName]['bootable']=$partition->bootable;
        }

        if($this->validateTable($table)) {
            return $table;
        }else {
            return false;
        }

    }

    /************************************************************************
	 * OPP FUNCTIONS
	 **********************************************************************/

    function validateTable($newPartitionTable) {


        $extend_kont=0;
        $xtable=$newPartitionTable;
        foreach($newPartitionTable as $n1=>$p1) {
            if($extend_kont>1) {
                exceptionHandlerClass :: saveError("Partition extend exists !!!");
                return false;
            }
            if($p1['id']==5) {
                $extend_kont++;
            }

            //ereg("[a-z]{2}([1-9]+)",$n1,$pn1);
            $pn1=$this->ereg_pn($n1);

            foreach($xtable as $nx=> $px ) {
                //ereg("[a-z]{2}([1-9]+)",$nx,$pnx);
                $pnx=$this->ereg_pn($nx);

                if($n1==$nx) continue;
                if(empty($p1['start']) || empty($px['start'])) continue;
                if(($pn1[1]<=4 && $pnx[1]<=4) &&

                        ($p1['start']<$px['start']+$px['size']&&
                                $p1['start']+$p1['size']>$px['start'])
                ) {
                    exceptionHandlerClass :: saveError("<br>overlap partition between $n1 and $nx !!!");
                    return false;
                }

                if(($p1['id']==5 && $pnx[1]>=5) &&
                        ($p1['start']>$px['start'] ||
                                $p1['start']+$p1['size']<$px['start']+$px['size'])
                ) {
                    exceptionHandlerClass :: saveError("<br> $nx logic unit out of $n1 extends partition !!!");
                    return false;

                }
                //overlap errorea ematen du partizio primarioetan bezela baldintza bat gorago dagoena begiratu
                if(($pn1[1]>=5 && $pnx[1]>=5) &&
                        ($p1['start']<$px['start']+$px['size']&&
                                $p1['start']+$p1['size']>$px['start'])
                ) {
                    exceptionHandlerClass :: saveError("<br>overlap partition between $n1 and $nx !!!");
                    return false;

                }
            }

            unset($xtable[$n1]);
        }
        return true;
    }

    function addPartition($partitions) {

    }

    function changePartition($partition) {

    }

    function removePartition($partition) {

    }

    /************************************************************************
	 * EXEC-PARSE FUNCTIONS
	 **********************************************************************/

    function writeTable() {

    }

    function parseTable() {
        if (empty ($this->disk)) {
            exceptionHandlerClass :: saveError("<br>Disk not selected !!!");
            return;
        }
        $cmd=str_replace('$disk', $this->disk, sfConfig::get('app_command_partitionTable'));

        $l = executeClass :: execute($cmd);
        $out= implode("\n",$l['output']);
        $g1=explode('!@@@',$out);
        if($l['return'] !=0  || strpos($out,'!@@@')===false || !isset($g1[1])  ) {
            exceptionHandlerClass::saveMessage('Error detecting partition table');
            return;
        }
        $partitions=explode("\n",$g1[1]);

        if (empty ($partitions)) {
            //exceptionHandlerClass :: saveError("<br>*Not detect any partition in ".$this->disk." !!!");
            return;
        }
        $partitionsT=array();

        foreach ($partitions as $row) {
            $partition=explode(' ', $row);
            
            if(isset($partition[1]) && !empty($partition)){
                $dev=str_replace('/dev/','',$partition[0]);
                if(is_numeric($partition[1])) {
                    $partitionsT[$dev]['start']=$partition[1];
                    $partitionsT[$dev]['size']=$partition[2] - $partitionsT[$dev]['start'];
                    $partitionsT[$dev]['id']=$partition[4];
                }else {

                    $partitionsT[$dev]['start']=$partition[2];
                    $partitionsT[$dev]['size']=$partition[3] - $partitionsT[$dev]['start'];
                    $partitionsT[$dev]['id']=$partition[5];
                    $partitionsT[$dev]['bootable']='*';
                }
            }
        }
        return $partitionsT;
    }
    /***************************************FUNTZIOAK**********************************************/
    function ereg_pn($in) {
        $cfg[0]=substr($in,1);
        $cfg[1]=substr($in,3);
        return $cfg;
    }
    function partSingleToTable($partition) {
        $cfg=array();
        $cfg['start']=$partition->startSector;
        $cfg['size']=$partition->sectors;
        $cfg['id']=$partition->partitionTypeId;
        $cfg['bootable']=$partition->bootable;
        return $cfg;
    }
}?>
