<?php

class PcPeer extends BasePcPeer
{
	public static function save_program_pc_list($ids,$my_task_id){		
		if(count($ids>0)){
			$con = Propel::getConnection();
			
			$where='id='.implode(' OR id=',$ids);
			$sql='UPDATE pc SET my_task_id='.$my_task_id.' WHERE '.$where;
 			$stmt = $con->prepare($sql);

        	$stmt->execute();
		}
	}
	public static function clear_program_pc_list($ids){		
		if(count($ids>0)){
			$con = Propel::getConnection();

			$where='id='.implode(' OR id=',$ids);
			$sql='UPDATE pc SET my_task_id=NULL WHERE '.$where;
 			$stmt = $con->prepare($sql);

        	$stmt->execute();
		}
	}
	public static function get_my_task_id_list($ids){
		$cfg=array();

		$con = Propel::getConnection();

		$where='id='.implode(' OR id=',$ids);
		$sql='SELECT DISTINCT(my_task_id) FROM pc WHERE '.$where;

		$result=$con->prepare($sql);
        $result->execute();
       
        while($row=$result->fetch(PDO::FETCH_OBJ)) {
			$cfg[]=$row->my_task_id;
		}
		return $cfg;
	}
	public static function has_task_pc($my_task_id){
		$c=new Criteria();
		$c->add(self::MY_TASK_ID,$my_task_id);	
		$pc_list=self::doSelect($c);
		if(count($pc_list)){
			return 1;
		}
		return 0;	
	}
	public static function clear_task($my_task_id){
		$con = Propel::getConnection();
		
		$sql='UPDATE pc SET my_task_id=NULL WHERE my_task_id='.$my_task_id;
 		$stmt = $con->prepare($sql);

        $stmt->execute();
	}
	public static function get_pc_list_by_my_task_id($my_task_id){
		$c=new Criteria();
		$c->add(self::MY_TASK_ID,$my_task_id);	
		return self::doSelect($c);		
	}
	public static function make_pc_list_html($pc_list){
		$cfg='';
		if(count($pc_list)>0){
			$my_array=array();
			foreach($pc_list as $i=>$pc){
				$my_array[]=$pc->getName().' ('.$pc->getIp().')';
			}
			$cfg=implode('<BR/>',$my_array);		
		}
		return $cfg;
	}	
	public static function prepare_partitions($pc_list){
		$result=array();

		if(count($pc_list)>0){
			foreach($pc_list as $i=>$pc){				
				$partition_list=$pc->get_partition_list();
				//echo print_r($partition_list,1);exit();
				$result[$pc->getId()]=self::prepare_partition_list($partition_list);
			}
		}
		
		return $result;
	}
	public static function prepare_partition_list($partition_list){
		$result=array();

		if(count($partition_list)){
			$kont=0;
			foreach($partition_list as $i=>$p){
				//gaur
				/*echo print_r($p,1);
				echo $i.'='.$p['fstype'].'<BR>';*/				
				if($i!='disks'){				
				//						
					if($p['fstype']!='oiSystem'){
						
						$result[$kont]=$p;
						$kont++;
					}
				}
			}
		}
	//exit();
		return $result;
	}	
}
