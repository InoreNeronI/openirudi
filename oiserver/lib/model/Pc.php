<?php

class Pc extends BasePc
{
	//kam
	public function __toString(){
		return $this->name;
	}
	//kam
	public function getDns1(){
		if(!empty($this->dns)){
			$my_array=explode(';',$this->dns);
			return $my_array[0];
		}		
		return '';
	}
	//kam
	public function getDns2(){
		if(!empty($this->dns)){
			$my_array=explode(';',$this->dns);
			if(count($my_array>1)){
				return $my_array[1];
			}
		}		
		return '';
	}
	public function getOiimage(){
		/*if($this->my_task_id){
			$oiimage=MyTaskPeer::get_oiimage($this->my_task_id);
			if(!empty($oiimage)){
				return $oiimage->getName();
			}
		}*/
		return MyTaskPeer::get_oiimage_list_by_pc_id($this->id);						
	}
	public function getDate(){
		sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url', 'I18N'));

		/*if($this->my_task_id){
			$my_task=MyTaskPeer::retrieveByPk($this->my_task_id);
			if(!empty($my_task)){	
				if($my_task->getAssociate()){
					return __('associate',array(),'messages');
				}else{
					$cfg='';
					if($my_task->getDay()){
						$cfg.=$my_task->getDay();
					}
					if($my_task->getHour()){
						if(!empty($cfg)){
							$cfg.=' ';
						}
						$my_array=explode(':',$my_task->getHour());
						$my_array=array_slice($my_array,0,count($my_array)-1);
						$my_hour=implode(':',$my_array);
						$cfg.=$my_hour;				
					}
					return $cfg;
				}
			}
		}*/
		$cfg=MyTaskPeer::get_date($this->my_task_id);		

		return $cfg;
	}
	public function get_partition_list(){
		$result=array();
		if(!empty($this->partitions)){
			//return unserialize($this->partitions);						
			$serial_array=unserialize($this->partitions);
			if(count($serial_array)>0){
				$kont=0;
				foreach($serial_array as $i=>$s){
					if(count($s)>0){
						foreach($s as $k=>$p){
							$result[$kont]=$p;
							$result[$kont]['serial']=$i;
							$kont++;
						}	
					}
				}
			}
		}
		return $result;
	}
	public function delete(PropelPDO $con = null)
	{
		$pc_id_array=array();
		$pc_id_array[]=$this->id;
		MyTaskPeer::delete_my_task_by_pc_id_array($pc_id_array);
		parent::delete($con);
	}
	//kam
	public function get_my_ident(){
		if($this->ip){
			return $this->ip;
		}
		return $this->mac;
	}


	//gemini 2011-02-15
	public function getImagesetTabular(){
		sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url', 'I18N'));
		//
		$criteria=new Criteria();
		$criteria->add(MyTaskPeer::PC_ID,$this->id);				
		$list=MyTaskPeer::doSelect($criteria);
		if(count($list)>0){
			foreach($list as $i=>$row)
				$date=' '.$row->getDay().' '.$row->getHour();
				$associate=$row->getAssociate();
				if($associate){
					$date=' '.__('associate',array(),'messages');
				}
				return $row->getImageset().$date;
		}		
		return '';					
	}
}
