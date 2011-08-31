<?php
class diskOppClass {
    private $diskName;
    private $model;
    private $serialNumber;
    private $firmwareRevision;
    private $partitionTable;
    private $hasExtendPartition;
    private $extendedPartition;
    private $primaryPartitionsNumber;
    private $logicPartitionsNumber;
    private $partitions;
    private $maxSectors;
    private $geometry;
    private $sectorBytes;
    private $cylSectors;
    private $diskSignature;


    private $humanSize;

    private $partitionsInSectors;

    private $freeHolePrimaryPartitionSectors;
    private $freeHoleLogicPartitionSectors;

    private $freePrimarySectorsTotal;
    private $freeLogicSectorsTotal;

    private $maxNewPrimaryPartitionSectors;
    private $maxNewLogicPartitionSectors;
    private $nextPrimaryPartition;

    private $OICache;
    private $hasOICache;


 /************************************************************************
 * ESPECIAL FUNCTIONS
 **********************************************************************/

    function __construct($diskName) {
        $this->diskName=$diskName;
//exceptionHandlerClass::saveMessage("-1--");
        $this->set_geometry();
        $this->set_maxSectors();

        $this->set_partitionTable();
        //$this->set_partitions();

        //$this->unsetPartitions();
        //$this->defineEditablePartitions();
//exceptionHandlerClass::saveMessage("-2--".implode(",",$this->geometry));

    }

    function __get($propertyName) {
        try {
            if(property_exists('diskOppClass', $propertyName)) {
                if(!isset($this->$propertyName)  ) {
                    $this->__set($propertyName, '');
                }
                return $this->$propertyName;

            }
            throw new Exception("Invalid property name \"{$propertyName}\"");

        }catch(Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }

    function __set($propertyName, $value) {
        try {
            if(!property_exists('diskOppClass', $propertyName)) {
                throw new Exception("Invalid property value \"{$propertyName}\" in diskOppClass ");
            }
            if(method_exists($this,'set_'.$propertyName)) {
                call_user_func(array($this,'set_'.$propertyName),$value);
            }else {
                throw new Exception("*Invalid property value \"{$propertyName}\" in diskOppClass ");
            }

        }catch(Exception $e) {
            exceptionHandlerClass::saveError($e->getMessage());
        }
    }


    /*
     * Diskoaren partizio taularen objetua
    */
    function set_partitionTable() {
        $this->partitionTable=new partitionTableOppClass ($this->diskName);
        if(!empty($this->partitionTable->table)) {
            exceptionHandlerClass::saveMessage('Partition table is empty');
        }
        $this->set_partitions();
    }

    /*
     * Diskoaren geometria eta diskoko sektore totalak.
     * TODO: LBA-CHS??? diskoa behar baino sektore gehiago atera daitezke eta erroreak gertatu. !!!!
    */

    function set_geometry() {
        $l = executeClass :: execute(str_replace('$disk', $this->diskName, sfConfig::get('app_command_diskGeometry')));
        $out= implode("\n",$l['output']);
        
        $g1=explode('!@@@',$out);
        if($l['return'] !=0  || strpos($out,'!@@@')===false || strpos($g1[1],';')===false  ) {
            exceptionHandlerClass::saveMessage('-1-Error detecting disk geometry');
            return;
        }

        $g=explode(';',$g1[1]);
        $this->geometry['C']=$g[0];
        $this->geometry['H']=$g[1];
        $this->geometry['S']=$g[2];

    }

    function set_serialNumber(){
        $l = executeClass::execute(str_replace('$disk', $this->diskName, sfConfig::get('app_command_diskInfo')));
        $out= trim(implode("\n",$l['output']));
        $g1=explode('!@@@',$out);

        if($l['return'] !=0  || strpos($out,'!@@@')===false || strpos($g1[1],';')===false  ) {
            exceptionHandlerClass::saveMessage('-1-Error detecting disk serial');
            return;
        }

        //echo -e "!@@@${MODEL};${FW};${SERIAL};${SIZE}!@@@"
        $diskInfo=explode(';', $g1[1] );
        $this->serialNumber=trim("{$diskInfo[2]}");
        $this->firmwareRevision=trim("{$diskInfo[1]}");
        $this->model=trim("{$diskInfo[0]}");

    }

    function set_model() {
        $this->__get('serialNumber');
    }

    function set_firmwareRevision() {
        $this->__get('serialNumber');
    }

    function set_cylSectors() {
        $this->__get('geometry');
        $this->cylSectors=$this->geometry['H']*$this->geometry['S'];
    }

    function set_sectorBytes() {
        $l = executeClass :: StrExecute(str_replace('$disk', $this->diskName, sfConfig::get('app_command_sectorBytes')));
        if(strpos($l, ';') !== false && strpos($l, 'B') !== false ){
            $l=str_replace('B', '', $l);
            $l1=split(';',$l);
            if(is_numeric($l1[0])){
                $this->sectorBytes=$l1[0];
            }else{
                 $this->sectorBytes=512;
            }
            
        }else{
            $this->sectorBytes=512;
        }

    }

    function set_maxSectors() {
        $size = executeClass :: ArrExecute(str_replace('$disk', $this->diskName, sfConfig::get('app_command_diskSize')));
        if(empty($size) || strpos($size[0],'s') ===false ) {
            exceptionHandlerClass::saveMessage('Error detecting disk size');
            return;
        }
        $this->maxSectors=str_replace('s','',$size[0]);
    }

    function set_humanSize() {
        $this->humanSize=unitsClass::sizeUnit($this->maxSectors*sfConfig::get('app_const_bytessector'));
    }

    function set_diskSignature(){
        $cmd=str_replace('$disk', $this->diskName, sfConfig::get('app_command_diskSignature'));
        $l = executeClass :: StrExecute($cmd);
        if(strpos($l,"@@") === false || strpos($l,"ERROR") !== false ){
            exceptionHandlerClass::saveMessage('Error detecting disk signature');
            return;
        }

        $s=explode('@@',$l);
        $this->diskSignature=$s[1];
    }


    /*
     * Partizio extendidoa badaukan edo ez diskoak, baldin badauka izena gorde
    */
    function set_hasExtendPartition() {
        //$this->__get('partitions');
        $this->hasExtendPartition=false;
        if(is_array($this->partitions) && !empty ($this->partitions) ) {
            foreach( array_keys($this->partitions) as $partitionName ) {
                if($this->partitions[$partitionName]->partitionTypeId==5 || $this->partitions[$partitionName]->partitionTypeId=='f' ) {
                    $this->hasExtendPartition=true;
                    $this->extendedPartition=$partitionName;
                    return;
                }
            }
        }
    }

    /*
     * Partizio extendidoaren izena
    */

    function set_extendedPartition() {
        $this->hasExtendPartition();
    }


    /*
     * Partizio bakoitzaren objetuak
    */

    function set_partitions($partitions='') {
        $this->__get('geometry');
        $this->__get('sectorBytes');
        $this->__get('cylSectors');

        if(empty($partitions)) {
            if(empty($this->partitionTable)) {
                $this->set_partitionTable();
            }
            if(is_array($this->partitionTable->table)) {
                $this->hasExtendPartition=false;

                $this->partitions=array();
                foreach($this->partitionTable->table as $partitionName => $partition ) {
                    if($partition['size'] > 0 ) {
                        $partition['partitionName']=$partitionName;
                        $this->partitions[$partition['partitionName']]=new partitionOppClass ($partition,$this->sectorBytes,$this->cylSectors);
                    }
                }
                $this->set_hasExtendPartition();
            }

        }else {
            $this->partitions=$partitions;
        }

//exceptionHandlerClass::saveMessage("PARTITIONS:: ".implode(";",print_r(array_keys($this->partitions),1)));
        $this->sectorsMap();
    }

    /*
     * Openirudiko partizioa baldin bada izena gorde
    */
    function set_OICache() {
        $this->hasOICache=false;
        foreach ($this->partitions as $partitionName => $partition ) {
            if($partition->fileSystem->label== sfConfig::get('app_oi_cachelabel') ) {
                $this->OICache[]=$partitionName;
                $this->hasOICache=true;
                break;
            }
        }
        return;
    }

    /*
     * Openirudiko partizioa baldin bada
    */
    function set_hasOICache() {
        $this->set_OICache();
    }

    /*
     * Okupatuta dauden partizoien zerrenda sektoretan. Partizio primario eta logikoetan bereizten dira.
    */

    function set_partitionsInSectors() {
        //$this->__get('partitions');
        
        $fp=array();
        $fl=array();
        $this->partitionsInSectors=array('primary'=>array(),'logic'=>array());
        if(!empty($this->partitions)) {
            foreach($this->partitions as $partition ) {
                if( $partition->sectors==0 )continue;
                if($partition->partitionNumber<=4 ) {
                    $fp[$partition->startSector]=$partition->sectors;
                }else {
                    $fl[$partition->startSector]=$partition->sectors;
                }
            }

            ksort($fp,SORT_NUMERIC);
            ksort($fl,SORT_NUMERIC);

            $this->partitionsInSectors['primary']=$fp;
            $this->partitionsInSectors['logic']=$fl;
        }
 
    }

    function set_primaryPartitionsNumber(){
        $this->__get('partitionsInSectors');
        if(isset($this->partitionsInSectors['primary'])){
            $this->primaryPartitionsNumber=count($this->partitionsInSectors['primary']);
        }else{
            $this->primaryPartitionsNumber=0;
        }
    }

    function set_logicPartitionsNumber(){
        $this->__get('partitionsInSectors');
        if(isset($this->partitionsInSectors['logic'])){
            $this->logicPartitionsNumber=count($this->partitionsInSectors['logic']);
        }else{
            $this->logicPartitionsNumber=0;
        }
    }



    /*
     * Libre dauden sektoreen kalkuloa (deprecated)
    */

    function sectorsMap() {
        $this->set_partitionsInSectors();
        //return;
        $this->set_freeHolePrimaryPartitionSectors();
        //return;
        $this->set_freeHoleLogicPartitionSectors();

        //return;
        $this->set_freePrimarySectorsTotal();
        $this->set_freeLogicSectorsTotal();
        //return;
        
        $this->set_maxNewPrimaryPartitionSectors();
        $this->set_maxNewLogicPartitionSectors();

    }


    /*
     * Partizio primarioetan dauden sektore libreen array-a
    */

    function set_freeHolePrimaryPartitionSectors() {
        $this->__get('partitionsInSectors');
        $this->freeHolePrimaryPartitionSectors=array();

        //holes sectors into primary partitions
        $position=$this->geometry['S'];
        foreach($this->partitionsInSectors['primary'] as $start=>$size ) {
            if( $start > $position ) {
                $holeSize=$start-$position;
                $holeStart=$position+1;
                $this->freeHolePrimaryPartitionSectors[$holeStart]=$holeSize;

            }
            $this->freePrimarySectorsTotal += $start-$position;
            $position=$start+$size;
        }
        if( $this->maxSectors > $position ) {
            $holeSize=$this->maxSectors-$position;
            $holeStart=$position+1;
            $this->freeHolePrimaryPartitionSectors[$holeStart]=$holeSize;
        }
    }

    /*
     * Partiziologikoetan dauden sektore libreen array-a
    */

    function set_freeHoleLogicPartitionSectors() {

        $this->__get('partitionsInSectors');
        $this->__get('hasExtendPartition');

        $this->freeHoleLogicPartitionSectors=array();

        //free sectors into logic partitions
        if($this->hasExtendPartition) {
            $free = array();
            //holes sectors into primary partitions
            $position= $this->partitions[$this->extendedPartition]->startSector+63;
            //$position= $this->partitions[$this->extendedPartition]->startSector;
            $extEnd= $this->partitions[$this->extendedPartition]->startSector + $this->partitions[$this->extendedPartition]->sectors;

            foreach($this->partitionsInSectors['logic'] as $start=>$size ) {
                if( $start > $position ) {
                    $holeSize=$start-$position;
                    $holeStart=$position+2;
                    $this->freeHoleLogicPartitionSectors[$holeStart]=$holeSize;
                }
                $position=$start+$size;
            }
            if( $extEnd > $position ) {
                $holeSize=$extEnd-$position;
                $holeStart=$position+2;
                $this->freeHoleLogicPartitionSectors[$holeStart]=$holeSize;
            }
        }

    }

    /*
     * Partizio primarioetan Libre dauden sektore guztien kopurua
    */

    function set_freePrimarySectorsTotal() {

        $this->__get('freeHolePrimaryPartitionSectors');
        $this->freePrimarySectorsTotal=0;

        if( count($this->partitionsInSectors['primary']) >= 4 ){
            $this->freePrimarySectorsTotal=0;
            return;
        }

        if(is_array($this->freeHolePrimaryPartitionSectors)) {
            foreach($this->freeHolePrimaryPartitionSectors as $holeSize) {
                $this->freePrimarySectorsTotal += $holeSize;
            }
        }

    }

    /*
     * Partizio logikoetan Libre dauden sektoren guztien kopurua
    */

    function set_freeLogicSectorsTotal() {
        $this->__get('freeHoleLogicPartitionSectors');
        $this->freeLogicSectorsTotal=0;

        if(is_array($this->freeHoleLogicPartitionSectors)) {
            foreach($this->freeHoleLogicPartitionSectors as $holeSize) {
                $this->freeLogicSectorsTotal += $holeSize;
            }
        }
    }


    /*
     * Egin daitekeen partizio primario handienaren tamaina kalkulatzen da eta maxNewPrimaryPartitionSectors aldagaian gorde
    */
    function set_maxNewPrimaryPartitionSectors() {

        $this->__get('freeHolePrimaryPartitionSectors');

        $this->maxNewPrimaryPartitionSectors = 0;

        if (count(array_keys($this->partitionsInSectors['primary'])) == 4) {
            $this->maxNewPrimaryPartitionSectors = 0;
            return;
        }

        foreach($this->freeHolePrimaryPartitionSectors as $starts => $holeSize) {
            if ($holeSize > $this->maxNewPrimaryPartitionSectors) {
                $this->maxNewPrimaryPartitionSectors = $holeSize;
            }
        }

    }

    /*
     * Egin daitekeen partizio logiko handienaren tamaina kalkulatzen da eta maxNewLogicPartitionSectors aldagaian gorde
    */
    function set_maxNewLogicPartitionSectors() {
        $this->__get('freeHoleLogicPartitionSectors');
        $this->maxNewLogicPartitionSectors=0;

        if(is_array($this->freeHoleLogicPartitionSectors))
            foreach ($this->freeHoleLogicPartitionSectors as $hole) {
                if($this->maxNewLogicPartitionSectors<$hole) $this->maxNewLogicPartitionSectors=$hole;
            }

    }


    /*
     * Partizio berri bat sortzeko hutsune bat ahurkitu eta hutsunearen lehen sektorea zein den esan
    */
    function newPrimaryPartitionStartSector( $sizeSectors ) {
        foreach($this->freeHolePrimaryPartitionSectors as $holeStart => $holeSize ) {
            if($sizeSectors <= $holeSize) {
                return $holeStart;
            }
        }
        return null;

    }

    function newLogicPartitionStartSector( $sizeSectors ) {

        foreach($this->freeHoleLogicPartitionSectors as $holeStart => $holeSize ) {
            if($sizeSectors <= $holeSize) {
                return $holeStart;
            }
        }
        return null;

    }

    function addPartitionSize($pSize,$type,$fs){
        $this->__get('maxSectors');

        if(strpos($pSize,'%')){
            $sectors=floor($this->maxSectors * $pSize /100);
        }else{
            $sectors=floor($pSize);
        }
        if ( ($type=='primary' || $type=='extended') && $sectors >= $this->maxNewPrimaryPartitionSectors){
            $sectors=$this->maxNewPrimaryPartitionSectors-1;
        }elseif($type=='logical' && $sectors >= $this->maxNewLogicPartitionSectors){
            $sectors=$this->maxNewLogicPartitionSectors-1;
        }
        $bytes=unitsClass::diskSectorSize($sectors, 'B');
  
        $candidate['size']=$bytes['size'];
        $candidate['type']=$type;
        $candidate['fs']=$fs;
        return $this->addPartition($candidate);
    }


    function addPartition($candidate) {
        $this->__get('cylSectors');

        $candidate['sectors']=unitsClass::size2sector($candidate['size'], $this->sectorBytes);

        if( ($candidate['type']=='primary' || $candidate['type']=='extended' ) && $candidate['sectors'] < $this->maxNewPrimaryPartitionSectors){
             $candidate['start_sector']=$this->newPrimaryPartitionStartSector($candidate['sectors']);
        }elseif($candidate['type']=='logical' && $candidate['sectors'] < $this->maxNewLogicPartitionSectors){
            $candidate['start_sector']=$this->newLogicPartitionStartSector($candidate['sectors']);
        }

        if(empty($candidate['sectors']) || !isset($candidate['start_sector']) || is_null($candidate['start_sector']) ){
            exceptionHandlerClass::saveError('Wrong partition size');
            return false;
        }


        $fs_opts=explode(',',sfConfig::get('app_oipartition_fsImageCreateType'));
        if($candidate['type']=='primary' && !in_array($candidate['fs'],$fs_opts )){
            exceptionHandlerClass::saveError('partition has not valid format');
            return false;
        }elseif($candidate['type']=='extended'){
            $candidate['fs']='';
        }

        $endSector1=$candidate['start_sector']+$candidate['sectors'];
        $cyls=ceil( $endSector1 / $this->cylSectors);
        $candidate['endSector']=$cyls*$this->cylSectors-1;
        if(empty ($candidate['endSector'])){
            exceptionHandlerClass::saveError('Wrong partition size');
            return false;
        }

        $cmd=str_replace('$diskName', $this->diskName, sfConfig::get('app_oipartition_createPartition'));
        $cmd=str_replace('$part-type', $candidate['type'], $cmd);
        $cmd=str_replace('$fs-type', $candidate['fs'], $cmd);
        $cmd=str_replace('$start_sector', $candidate['start_sector'], $cmd);
        $cmd=str_replace('$end_sector', $candidate['endSector'], $cmd);

        $res=executeClass::execute($cmd);
        if($res['return']==0) {
            $row=preg_grep('/!@@@/',$res['output']);
            preg_match('/!@@@([0-9]+)*/',implode('',$row),$match);
            $p=trim($match[1]);
            exceptionHandlerClass::saveMessage("new partition has been created ($p) (".$candidate['fs'].")");
            return $p;
        }else {
            exceptionHandlerClass::saveError(implode("\n",$res['output']));
            exceptionHandlerClass::saveError("New partition not created");
            return null;
        }

    }

    function savePartition($candidate) {

        /* funtzio hau errbisatu behar da */

        sfLoader::LoadHelpers(array('I18N'));

        if($this->validateExtend($candidate)==0) {
            exceptionHandlerClass::saveError(__('Partition extend exist!!!!'));
            return false;
        }

        $old_partition=$candidate['partitionName'];
        if(isset($this->partitions[$candidate['partitionName']])) {
            $old_partition=clone($this->partitions[$candidate['partitionName']]);
        }

        if(isset($candidate['new_logic']) && $candidate['new_logic']==1) {
            $candidate['start']=0;
            if(!isset($candidate['size'])) {
                $candidate['size']=$candidate['sizeB'];
            }
            $this->partitions[$candidate['partitionName']]=new partitionOppClass ($candidate, $this->sectorBytes, $this->cylSectors );
            $this->checkStartSector($candidate,$old_partition);
        }

        $oldsize=$this->partitions[$candidate['partitionName']]->humanSize;
        $oldSectors=$this->partitions[$candidate['partitionName']]->sectors;
        $newSectors=$oldSectors;

        if($candidate['sizeB']!=$oldsize['size'] || $candidate['unit'] != $oldsize['unit']) {

            //set_humanSize funztioa exekutatzen da asignazioan eta sectors eta humansize atributuak kalkulatzen dira
            $this->partitions[$candidate['partitionName']]->humanSize=array('size'=>$candidate['sizeB'],'unit'=>$candidate['unit']);
            $newSectors=$this->partitions[$candidate['partitionName']]->sectors;

            if(!$table=$this->partitionTable->partitions2table($this->partitions)) {
                //unitate logiko berria sortzen ari gara ez bada betetzen ez utzi
                if(isset($candidate['new_logic']) && $candidate['new_logic']==1) {
                    $this->removePartition($candidate['partitionName']);
                } else {
                    $this->partitions[$candidate['partitionName']]->humanSize=$oldsize;
                    $this->partitions[$candidate['partitionName']]->sectors=$old_partition->sectors;
                }
                exceptionHandlerClass::saveError(__('%1% partition has wrong size'));
                return false;
            }

            $size=0;
            foreach($this->partitions as $partition ) {
                if($partition->partitionNumber > 4 || $partition->sectors == 0) {
                    continue;
                }
                if($size==0)    $size += $partition->startSector;
                $size += $partition->sectors;
            }

            if($size>$this->maxSectors) {

                $this->partitions[$candidate['partitionName']]->humanSize=$oldsize;
                $this->partitions[$candidate['partitionName']]->sectors=$old_partition->sectors;
                $maxSize = unitsClass::sizeUnit($this->maxSectors*sfConfig::get('app_const_bytessector'));


                if($this->isResetPartition($old_partition)) {
                    $this->removePartition($candidate['partitionName']);
                }


                if(isset($candidate['new_extend']) && $candidate['new_extend']==1) {
                    $this->removePartition($candidate['partitionName']);
                }

                exceptionHandlerClass::saveError(__('%1% partition is too large. Max. allowed size: %2%%3%', array('%1%' => $candidate['partitionName'], '%2%' => $maxSize['size'], '%3%' => $maxSize['unit'])));
                return false;
            }

            if(!is_null($this->partitions[$candidate['partitionName']]->fileSystem) && ! $this->partitions[$candidate['partitionName']]->fileSystem->resizable ){

                exceptionHandlerClass::saveError("This partition has not resizable fileystem");
                return false;

            }
            $this->partitionTable->table=$table;

            $cmd=str_replace('$partName',$this->partitions[$candidate['partitionName']]->partitionName,sfConfig::get('app_oipartition_resizePartition'));
            $cmd=str_replace('$end',$this->partitions[$candidate['partitionName']]->endSector,$cmd);

            $res=executeClass::execute($cmd);
            if($res['return']==0){
                exceptionHandlerClass::saveMessage(__('%1% partition size has been changed', array('%1%' => $candidate['partitionName'])));
            }else{
                exceptionHandlerClass::saveMessage(__('%1% Error, partition size has not been changed', array('%1%' => $candidate['partitionName'])));
                exceptionHandlerClass::saveMessage(implode("\n",$res['output']));
            }
        }

        /*if($candidate['id']!=$this->partitions[$candidate['partitionName']]->partitionTypeId){
			$this->partitions[$candidate['partitionName']]->partitionTypeId=$candidate['id'];
			$table=$this->partitionTable->partitions2table($this->partitions);
			$this->partitionTable->table=$table;
			exceptionHandlerClass::saveMessage(__('<strong>%1%</strong> partition ID has been changed', array('%1%' => $candidate['partitionName'])));
		}*/

        //bestela undefined index echo bat ematen du edo warning
        if(isset($candidate['boot'])) {
            if($candidate['boot']!=$this->partitions[$candidate['partitionName']]->bootable) {
                $table1=$this->partitionTable->partitions2table($this->partitions);

                $this->partitions[$candidate['partitionName']]->bootable=$candidate['boot'];

                $table2=$this->partitionTable->partitions2table($this->partitions);

                if($this->partitions[$candidate['partitionName']]->bootable) {
                    foreach($this->partitions as $pN => $part2) {
                        if($part2->bootable && $pN != $candidate['partitionName']) {
                            $this->partitions[$pN]->bootable=0;
                        }
                    }
                }
                $table=$this->partitionTable->partitions2table($this->partitions);
                $this->partitionTable->table=$table;
                exceptionHandlerClass::saveMessage(__('<strong>%1%</strong> partition boot has been changed', array('%1%' => $candidate['partitionName'])));
            }
        }

//echo bat sortzen du pantailan, baino agian beharrezkoa da
//exceptionHandlerClass::saveMessage("taula".print_r($this->partitionTable));

        $this->checkStartSector($candidate,$old_partition);
        $this->sectorsMap();
        $this->set_hasExtendPartition();
        $this->defineEditablePartitions();

        return true;
    }

    function removePartition($partitionName) {

        //resizePartition:   'nohup sudo /var/www/openirudi/bin/partedCmd.sh resizeNtfsPartition /dev/$diskName $number $end'
         $cmd=str_replace('$partName',$partitionName, sfConfig::get('app_oipartition_removePartition'));
         $res=executeClass :: execute($cmd);
         if($res['return'] !=0 ){
             exceptionHandlerClass::saveError(implode('<br>',$res['output']));
             exceptionHandlerClass::saveError("Error removeing partitition");
             return false;
         }



//        unset($this->partitions[$candidate]);
//        $table=$this->partitionTable->partitions2table($this->partitions);
//        $this->partitionTable->table=$table;
//        $this->sectorsMap();
//        $this->set_hasExtendPartition();
//        $this->defineEditablePartitions();

        return true;
    }


    /*********************************FUNTZIO BERRIAK********************************************/
    function isPrimaryPartition($candidate) {
        $lag=(int) substr($candidate,3);
        if($lag>4) {
            return 0;
        }
        return 1;
    }

    function resetPartition($candidate) {
        $lag=array('start' => 0,'size' => 0 ,'id' => 0, 'partitionName' =>$candidate);
        $this->partitions[$candidate]->removeFileSystem();
        $this->partitions[$candidate]->initiatePartition($lag);
    }

    function removeChildPartitions() {
        $lag=array_keys($this->partitions);
        foreach($lag as $key) {
            if($this->isPrimaryPartition($key)==0) {
                unset($this->partitions[$key]);
            }
        }
    }

    function checkStartSector($candidate,$old_partition) {
        $bai=0;
        //primarioa den baldintza, agian aurrerago kendu egin behar da
        if($this->isPrimaryPartition($candidate['partitionName'])) {
            //modu bat da konprobatzeko berria dela
            if(isset($candidate['new_extend']) && $candidate['new_extend']==1) {
                //new extend ataletik gatoz
                $bai=1;
            }else {
                if($this->isResetPartition($old_partition)==1) {
                    $bai=1;
                }
            }
        }else {
            if(isset($candidate['new_logic']) && $candidate['new_logic']==1) {
                $bai=1;
            }
        }
        if($bai==1) {
            $this->calculateStartSector($candidate['partitionName']);
        }

    }

    function calculateStartSector($name) {
        $i=(int) substr($name,3);

        if($i==1) {
            $kop=$this->geometry['S'];
        }else {
            if($i<5) {
                if($i>1) {
                    $i=$i-1;
                    $s=(string) $i;
                    $prev=$this->partitionTable->disk.$s;
                    $kop=$this->partitions[$prev]->startSector+$this->partitions[$prev]->sectors;
                }
            }else {
                if($this->hasExtendPartition) {
                    //normalean ona iristeko bete egin behar da hau

                    $prev=$this->whoIsPrev($name);

                    if($this->isPrimaryPartition($prev)) {
                        $kop=$this->partitions[$prev]->startSector+$this->geometry['S'];
                    }else {
                        $kop=$this->partitions[$prev]->startSector+$this->partitions[$prev]->sectors;
                    }
                }
            }
        }
        if(isset($this->partitions[$name])) {
            $this->partitions[$name]->set_startSector($kop);
        }
        $table=$this->partitionTable->partitions2table($this->partitions);
        $this->partitionTable->table=$table;
    }

    function calculateNextPartition() {
        $lag=array_keys($this->partitions);
        $last=array_pop($lag);
        $partitionNumber=$this->partitions[$last]->partitionNumber+1;

        if($partitionNumber<=4) {
            //hau seguruna ez da inoiz gertatuko
            $partitionNumber=5;
        }

        $cfg=$this->diskName.(string) $partitionNumber;

        return $cfg;
    }

    function whoIsPrev($name) {
        //unitate logikoetan azkenekoaren izena itzuli, bera berria bada azkenekoa, extend partizioaren izena itzuli
        $bai=0;
        foreach($this->partitions as $partition) {
            if($partition->partitionNumber>=5 && $partition->partitionName!=$name) {
                $prev=$partition->partitionName;
                $bai=1;
            }
        }

        if($bai==1) {
            $cfg=$prev;
        }else {
            $cfg=$this->whoIsExtend();
        }

        return $cfg;
    }

    function whoIsExtend() {

        foreach($this->partitions as $partition) {
            if($partition->partitionTypeId==5) {
                return $partition->partitionName;
            }
        }

        return "";
    }

    function isResetPartition($old) {
        //agian baldintza gehiago jar daitezke... edo gutxiago...
        if($old->bootable==0 && $old->startSector==0 && $old->sectors==0 && $old->blocks==0 && $old->humanSize['size']==0 && $old->humanSize['unit']=='B' && $old->partitionTypeId==0 && empty($old->fileSystem)) {
            return 1;
        }

        return 0;
    }

    function validateExtend($candidate) {
        if($candidate['id']==5) {
            $extend_name=$this->whoIsExtend();
            if(!empty($extend_name)) {
                if($extend_name!=$candidate['partitionName']) {
                    return 0;
                }
            }
        }
        return 1;
    }

    function unsetPartitions() {
        $this->__get('partitions');
        $lag=$this->partitions;
        foreach($lag as $row) {
            if($this->isResetPartition($row)) {
                unset($this->partitions[$row->partitionName]);
            }
        }
        $table=$this->partitionTable->partitions2table($this->partitions);
        $this->partitionTable->table=$table;
    }

    function defineEditablePartitions() {
                
            
        
    }
}
?>
