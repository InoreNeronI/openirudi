<?php

/**
 * my_task_group actions.
 *
 * @package    drivers
 * @subpackage my_task_group
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class my_task_groupActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }
  public function executeProgram(sfWebRequest $request){
	//simulatzeko
	//$this->sortu_serializatua();
	//
	$ids=array();
	if($request->getParameter('ids')){
		$ids=$request->getParameter('ids');
		$this->getUser()->setAttribute('program_group_ids',$ids);
		$this->getUser()->setAttribute('program_group_is_associate',false);
		$this->getUser()->setAttribute('program_group_is_clear',false);
		$this->getUser()->setAttribute('clone_group_is_now',false);	
	}else{
		if($request->isMethod('get')){
			$ids=$this->getUser()->getAttribute('program_group_ids');
		}
	}
	if(count($ids)>0){
		$this->pcgroup=PcgroupPeer::retrieveByPk($ids[0]);
		$this->pc_list=PcgroupPeer::get_pc_list($ids[0]);
		$this->partition_list=PcPeer::prepare_partitions($this->pc_list);
		//echo print_r($this->pc_list,1);exit();		
		$this->group_partition_list=PcGroupPeer::prepare_partitions($this->partition_list);
		//echo print_r($this->group_partition_list,1);exit();
		$this->oiimages_list=OiimagesPeer::get_oiimages_list();
		$this->oiimages_assoc=OiimagesPeer::get_oiimages_assoc($this->oiimages_list);
		//gemini 2011-02-15
		$this->imageset_assoc=ImagesetPeer::get_imageset_assoc();
		//
		$num_pc=count($this->pc_list);
		if($num_pc>0){
			//gaur		
			//if($num_pc>0){		
				//$this->disk_assoc=MyTaskPeer::get_disk_list_by_partition_list(MyTaskPeer::form_partition_list_by_pc($this->pc_list[0]));	
				$my_disk_assoc=array();
				foreach($this->pc_list as $i=>$row){
					$my_disk_assoc[$row->getId()]=MyTaskPeer::get_disk_list_by_partition_list(MyTaskPeer::form_partition_list_by_pc($row));	
				}
				$this->disk_assoc=PcGroupPeer::prepare_disk_assoc($my_disk_assoc);
				//echo print_r($this->disk_assoc,1);exit();
			/*}else{
				$this->disk_assoc['']='';
			}*/
			
			
			//
			if($request->getParameter('associate_submit')){
				$this->getUser()->setAttribute('program_group_is_associate',true);				
			}
			//
			if($request->getParameter('clear_program_associate')){
				$this->getUser()->setAttribute('program_group_is_clear',true);	
			}
			//
			if($request->getParameter('clone_now')){
				$this->getUser()->setAttribute('clone_group_is_now',true);				
			}
			//
			if($this->getUser()->getAttribute('program_group_is_associate')){	
				$this->setTemplate('associate');
			}
			//
			if($this->getUser()->getAttribute('clone_group_is_now')){
				$this->setTemplate('now');
			}
			if($this->getUser()->getAttribute('program_group_is_clear')){	
				$this->setTemplate('clear');
			}
		}else{
			$this->setTemplate('no_pc_in_the_group');
		}	
	}else{
		$this->setTemplate('no_select_group');
	}	
  }
  public function executeProgram_save(sfWebRequest $request){
	$this->exec_program_save($request,false);
  }
  private function exec_program_save($request,$is_now=false){
	$oiimages_id_array=$request->getParameter('oiimages_id');
	
	$this->get_imageset_info($request,$is_imageset,$imageset_id,$is_boot,$imageset_pcgroup_id,$disk);	
	
	if(OiimagesPeer::is_empty_oiimage($oiimages_id_array)){	
		$this->setTemplate('no_select_oiimage');	
	}else if(!empty($is_imageset) && empty($imageset_id)){	
		$this->setTemplate('no_select_imageset');
	}else{
		//echo $imageset_pcgroup_id;exit();
		MyTaskPeer::delete_my_task_by_pcgroup_id($imageset_pcgroup_id);
		if(!empty($is_imageset)){			
			$pc_id_array=MyTaskPeer::get_pc_id_array_by_group_id($imageset_pcgroup_id);
			if(count($pc_id_array)>0){				
				foreach($pc_id_array as $i=>$pc_id){
					//echo 'pc_id='.$pc_id.'<br>';
								
					$my_task=new MyTask();
					if($is_now){
						$my_task->setDay(date('Y-m-d'));
						$my_task->setHour(date('H:i').':00');
					}else{
						$my_task->setDay(MyTaskPeer::make_day($request->getParameter('day')));
						$my_task->setHour(MyTaskPeer::make_hour($request->getParameter('hour')));
					}
					$my_task->setAssociate(0);
					$my_task->setPartition('');
					$my_task->setPcId($pc_id);
					$my_task->setIsImageset($is_imageset);
					$my_task->setImagesetId($imageset_id);
					$my_task->setIsBoot($is_boot);
					$my_task->setDisk($disk);
					$my_task->save();
				}
			}				
		}else{
			//echo print_r($oiimages_id_array,1);exit();
			MyTaskPeer::delete_my_task_group_partition($oiimages_id_array);
			
			if(count($oiimages_id_array)>0){
				foreach($oiimages_id_array as $key=>$oiimages_id){
					$key_array=explode('-',$key);
					$pcgroup_id=$key_array[0];
					$partition=$key_array[1];
					//echo $pcgroup_id.'->'.$partition;exit();
					
					//
					if(!empty($oiimages_id)){
						$pc_id_array=MyTaskPeer::get_pc_id_array_by_group_id($pcgroup_id);
						if(count($pc_id_array)>0){
							foreach($pc_id_array as $i=>$pc_id){
								//echo 'pc_id='.$pc_id.'<br>';
								$my_task=new MyTask();
								if($is_now){
									$my_task->setDay(date('Y-m-d'));
									$my_task->setHour(date('H:i').':00');
								}else{
									$my_task->setDay(MyTaskPeer::make_day($request->getParameter('day')));
									$my_task->setHour(MyTaskPeer::make_hour($request->getParameter('hour')));
								}
								$my_task->setAssociate(0);
								$my_task->setOiimagesId($oiimages_id);
								$my_task->setPartition($partition);
								$my_task->setPcId($pc_id);
								$my_task->setIsImageset(0);
								$my_task->setIsBoot($is_boot);
								$my_task->setDisk($disk);
								$my_task->save();
							}							
						}	
					}
				}
			}
		}		
	}
	if($is_now){
		$app_const_root_dir=sfConfig::get('app_const_root_dir');
		$app_const_root_dir=strtolower($app_const_root_dir);
		
                $aa=file_get_contents('http://'.$_SERVER['SERVER_ADDR'].'/oiserver/web/func/wakeUp.php');
                if($aa===false){
                    echo "ERROR in url ".'http://'.$_SERVER['SERVER_ADDR'].'/oiserver/web/func/wakeUp.php';
                }
		
	}
  }
  private function get_imageset_info($request,&$is_imageset,&$imageset_id,&$is_boot,&$imageset_pcgroup_id,&$disk){
  	$is_imageset=0;	
	if($request->getParameter('is_imageset')){
		$is_imageset=$request->getParameter('is_imageset');
	}	
	$imageset_id=$request->getParameter('imageset_id');
	$is_boot=0;
	if($request->getParameter('is_boot')){
		$is_boot=$request->getParameter('is_boot');
	}
	$imageset_pcgroup_id=$request->getParameter('imageset_pcgroup_id');
	//
	$disk='';
	if($request->getParameter('disk')){
		$disk=$request->getParameter('disk');
	}
	//
  }
  public function executeAssociate_save(sfWebRequest $request){
	$oiimages_id_array=$request->getParameter('oiimages_id');
	
	$this->get_imageset_info($request,$is_imageset,$imageset_id,$is_boot,$imageset_pcgroup_id,$disk);	

	
	if(OiimagesPeer::is_empty_oiimage($oiimages_id_array)){	
		$this->setTemplate('no_select_oiimage');
	}else if(!empty($is_imageset) && empty($imageset_id)){	
		$this->setTemplate('no_select_imageset');
	}else{			
		MyTaskPeer::delete_my_task_by_pcgroup_id($imageset_pcgroup_id);
		if(!empty($is_imageset)){
			$pc_id_array=MyTaskPeer::get_pc_id_array_by_group_id($imageset_pcgroup_id);
			if(count($pc_id_array)>0){				
				foreach($pc_id_array as $i=>$pc_id){
					//echo 'pc_id='.$pc_id.'<br>';
								
					$my_task=new MyTask();			
					$my_task->setAssociate(1);
					$my_task->setPartition('');
					$my_task->setPcId($pc_id);
					$my_task->setIsImageset($is_imageset);
					$my_task->setImagesetId($imageset_id);
					$my_task->setIsBoot($is_boot);
					$my_task->setDisk($disk);
					//
					$my_task->save();
				}			
			}			
		}else{
			MyTaskPeer::delete_my_task_group_partition($oiimages_id_array);
			//
			if(count($oiimages_id_array)>0){
				foreach($oiimages_id_array as $key=>$oiimages_id){
					$key_array=explode('-',$key);				
					$pcgroup_id=$key_array[0];
					$partition=$key_array[1];
					//
					if(!empty($oiimages_id)){
						$pc_id_array=MyTaskPeer::get_pc_id_array_by_group_id($pcgroup_id);
						if(count($pc_id_array)>0){
							foreach($pc_id_array as $i=>$pc_id){
								//echo 'pc_id='.$pc_id.'<br>';	
								$my_task=new MyTask();
								$my_task->setAssociate(1);
								$my_task->setOiimagesId($oiimages_id);
								$my_task->setPartition($partition);
								$my_task->setPcId($pc_id);
								$my_task->setIsImageset(0);
								$my_task->setIsBoot($is_boot);
								$my_task->setDisk($disk);						
								//
								$my_task->save();
							}
						}		
					}
				}				
			}
		}	
	}
  }
  public function executeNow_save(sfWebRequest $request){
	$this->exec_program_save($request,true);
  }
  public function executeClear_confirm(sfWebRequest $request){
	$ids=$request->getParameter('ids');
	if(count($ids)>0){
		$pcgroup_id=$ids[0];
		MyTaskPeer::delete_my_task_by_pcgroup_id($pcgroup_id);
	}
  } 	 
}
