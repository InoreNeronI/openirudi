<?php

class PcgroupPeer extends BasePcgroupPeer
{
	//kam
	public static function get_pc_list($group_id){
		$result=array();
		if(!empty($group_id)){
			$criteria=new Criteria();
			$criteria->add(PcPeer::PCGROUP_ID,$group_id);
			$result=PcPeer::doSelect($criteria);
		}
		return $result;
	}
	//kam
	public static function prepare_partitions($partition_list){
		$my_list=array();
		if(count($partition_list)){
			
			foreach($partition_list as $pc_id=>$my_array){
				if(!empty($my_array)){
					foreach($my_array as $i=>$row){
						//echo $row['partitionName'].'<BR>';
						if(self::in_partition_list($row['partitionName'],$partition_list)){
							if(!in_array($row['partitionName'],$my_list)){
								$my_list[]=$row['partitionName'];
							}								
						}
					}
				}
			}
		}
		//simulatzeko
		/*if(empty($my_list)){
			$my_list[0]='sda1';
		}*/	
		//
		return $my_list;
	}
	//kam
	private static function in_partition_list($partitionName,$partition_list){
		if(count($partition_list)){
			$my_list=array();
			foreach($partition_list as $pc_id=>$my_array){
				if(!empty($my_array)){
					$bai=0;
					foreach($my_array as $i=>$row){
						if($row['partitionName']==$partitionName){
							$bai=1;
						}
					}
					if(!$bai){
						return 0;
					}
				}else{
					return 0;
				}
			}
			return 1;
		}
		return 0;
	}
	public static function prepare_disk_assoc($my_disk_assoc){
		$disk_assoc['']='';
		if(!empty($my_disk_assoc)){
			foreach($my_disk_assoc as $pc_id=>$my_array){
				if(!empty($my_array)){
					foreach($my_array as $i=>$disk){
						//echo $row['partitionName'].'<BR>';
						if(!empty($disk)){	
							if(self::in_my_disk_assoc($disk,$my_disk_assoc)){
								$disk_assoc[$disk]=$disk;												
							}
						}	
					}					
				}
			}
		}
		//simulatzeko
		//$disk_assoc['sda']='sda';
		//
		return $disk_assoc;
	}
	private static function in_my_disk_assoc($disk_name,$my_disk_assoc){
		if(!empty($my_disk_assoc)){
			foreach($my_disk_assoc as $pc_id=>$my_array){
				if(!empty($my_array)){
					$bai=0;
					foreach($my_array as $i=>$disk){
						if(!empty($disk)){
							if($disk==$disk_name){
								$bai=1;
							}
						}	
					}
					if(!$bai){
						return 0;
					}
				}else{
					return 0;
				}
			}
			return 1;
		}
		return 0;
	}
}
