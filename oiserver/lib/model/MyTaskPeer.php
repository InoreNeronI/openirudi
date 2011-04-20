<?php

class MyTaskPeer extends BaseMyTaskPeer
{
	public static function make_hour($my_array){
		$h=(string) $my_array['hour'];
		if(strlen($h)<2){
			$h='0'.$h;
		}
		$m=(string) $my_array['minute'];
		if(strlen($m)<2){
			$m='0'.$m;
		}
		return $h.':'.$m.':00';
	}
	public static function make_day($day){
		$cfg=$day;

		if(!empty($cfg)){
			$culture=sfContext::getInstance()->getUser()->getCulture();
			if($culture=='es'){
				$my_array=explode('/',$day);
				$cfg=implode('/',array_reverse($my_array));
			}
		}

		return $cfg;
	}
	public static function get_oiimage($my_task_id){
		$c=new Criteria();
		$c->add(self::ID,$my_task_id);
		$my_task_list=MyTaskPeer::doSelectJoinOiimages($c);
		if(count($my_task_list)>0){
			return $my_task_list[0]->getOiimages();
		}
		return '';
	}
	public static function delete_task_not_has_pc($my_task_id_list){
		$delete_array=self::get_delete_array($my_task_id_list);
		if(count($delete_array)>0){
			$con = Propel::getConnection();

			$where='id='.implode(' OR id=',$delete_array);

			$sql='DELETE FROM my_task WHERE '.$where;
 			$stmt = $con->prepare($sql);

        	$stmt->execute();
		}		
	}
	private static function get_delete_array($my_task_id_list){
		$cfg=array();
		if(count($my_task_id_list)>0){
			foreach($my_task_id_list as $i=>$my_task_id){
				if(!empty($my_task_id)){
					$has_pc=PcPeer::has_task_pc($my_task_id);
					if(!$has_pc){
						$cfg[]=$my_task_id;
					}
				}
			}	
		}
		return $cfg;
	}
	public static function delete_my_task_partition($oiimages_id_array){
		/*$pc_id_array=self::get_pc_id_array_partition($oiimages_id_array);
		if(count($pc_id_array)>0){	
			self::delete_my_task_by_pc_id_array($pc_id_array);
		}*/
		if(count($oiimages_id_array)>0){
			foreach($oiimages_id_array as $key=>$oiimages_id){
				$key_array=explode('-',$key);
				$pc_id=$key_array[0];
				$partition=$key_array[1];
				if(!empty($oiimages_id)){
					self::delete_my_task_pc_and_partition($pc_id,$partition);
				}
			}
		}
	}
	private static function get_pc_id_array_partition($oiimages_id_array){
		$result=array();
		if(count($oiimages_id_array)>0){
			foreach($oiimages_id_array as $key=>$oiimages_id){
				$key_array=explode('-',$key);
				$pc_id=$key_array[0];
				$partition=$key_array[1];
				if(!in_array($pc_id,$result)){
					$result[]=$pc_id;
				}	
			}
		}
		return $result;
	}
	//gaur static
	public static function delete_my_task_by_pc_id_array($pc_id_array){
		if(count($pc_id_array)>0){	
			$con = Propel::getConnection();

			$where='pc_id='.implode(' OR pc_id=',$pc_id_array);

			$sql='DELETE FROM my_task WHERE '.$where;
 			$stmt = $con->prepare($sql);

        	$stmt->execute();
		}
	}
	public static function get_oiimage_list_by_pc_id($pc_id){
		$result=array();
		//
		$c=new Criteria();
		//$c->addJoin(self::OIIMAGES_ID,OiimagesPeer::ID,Criteria::LEFT_JOIN);
		$c->add(self::PC_ID,$pc_id);
		$my_task_list=self::doSelect($c);
	
		if(count($my_task_list)>0){
			foreach($my_task_list as $i=>$my_task){
				//gemini 2011-02-15
				$is_imageset=$my_task->getIsImageset();					
				if(!$is_imageset){
				//					
					$result[$i]['partition']=$my_task->getPartition();	
					//$result[$i]['oiimages']=$my_task->getOiimages()->getName();
					$my_oiimages=$my_task->getOiimages();
					$result[$i]['oiimages']='';
					if(!empty($my_oiimages)){
						$result[$i]['oiimages']=$my_oiimages->getName();
					}				
					$result[$i]['date']=self::get_date($my_task->getId());		
				}
			}
		}

		return $result;
	}
	public static function get_date($my_task_id){		
		$cfg='';
		if($my_task_id){
			$my_task=MyTaskPeer::retrieveByPk($my_task_id);
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
		}
		return $cfg;		
	}
	private static function delete_my_task_pc_and_partition($pc_id,$partition){
		$con = Propel::getConnection();

		$sql='DELETE FROM my_task WHERE pc_id='.$pc_id.' AND partition="'.$partition.'"';
 		
		$stmt = $con->prepare($sql);

        $stmt->execute();
	}
    public static function form_partition_list(){
		$result=array();
		//
		$my_request=sfContext::getInstance()->getRequest();
		$id=$my_request->getParameter('id');
		
		if(!empty($id)){
			$my_task=MyTaskPeer::retrieveByPk($id);
			if(!empty($my_task)){
				$pc=$my_task->getPc();
				if(!empty($pc)){
					$result=self::form_partition_list_by_pc($pc);
				}
			}
		}

		return $result;
	}
	public static function form_partition_list_by_pc($pc){
		$result=array();
		//
		if(!empty($pc)){
					//gemini 2011-02-15
					$result['']='';
					//
					$pc_list=array();
					$pc_list[0]=$pc;
					$partition_list=PcPeer::prepare_partitions($pc_list);
					if(count($partition_list)>0){
						if(isset($partition_list[$pc->getId()])){
							$my_list=$partition_list[$pc->getId()];
							if(count($my_list)>0){
								foreach($my_list as $i=>$p){
									$my_name=$p['partitionName'];
									$result[$my_name]=$my_name;
								}
							}
						}
					}
		}		
		return $result;
	}
	public static function doCountCustom(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(MyTaskPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			MyTaskPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(MyTaskPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		//kam
        $criteria=self::add_custom_criteria($criteria);
        //		

				$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}
	public static function doSelectCustom(Criteria $criteria, PropelPDO $con = null)
	{
		//kam
		$criteria=self::add_custom_criteria($criteria);
		//

		return MyTaskPeer::populateObjects(MyTaskPeer::doSelectStmt($criteria, $con));
	}
	private static function add_custom_criteria($criteria){
		$criteria=clone $criteria;

		$my_task_hour_filter=sfContext::getInstance()->getUser()->getAttribute('my_task_hour_filter');	
	  	if(isset($my_task_hour_filter['from'])){
			$from_hour=self::make_hour($my_task_hour_filter['from']);
			$to_hour='';
			if(isset($my_task_hour_filter['to'])){
				$to_hour=self::make_hour($my_task_hour_filter['to']);
			}
			if(!empty($from_hour)){
				if(empty($to_hour)){
					$criteria->add(self::HOUR,$from_hour,Criteria::GREATER_EQUAL);
				}else{
					$and1=$criteria->getNewCriterion(self::HOUR,$from_hour,Criteria::GREATER_EQUAL);
					$and2=$criteria->getNewCriterion(self::HOUR,$to_hour,Criteria::LESS_EQUAL);
					$and1->addAnd($and2);
					$criteria->add($and1);
				}
			}
		}
		

		return $criteria;
    }
	//gaur
	public static function form_disk_list(){
		$result=array();
		$list=self::form_partition_list();
		$result=self::get_disk_list_by_partition_list($list);
		
		return $result;
	}
	//gaur
	public static function get_disk_list_by_partition_list($list){
		$result['']='';
		if(count($list)>0){
			foreach($list as $label=>$value){
				if(!empty($value)){
					$s=substr($value,0,strlen($value)-1);
					$result[$s]=$s;
				}
			}
		}
		return $result;
	}		
}
