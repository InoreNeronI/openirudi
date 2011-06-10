<?php

require_once dirname(__FILE__).'/../lib/my_taskGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/my_taskGeneratorHelper.class.php';

/**
 * my_task actions.
 *
 * @package    drivers
 * @subpackage my_task
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class my_taskActions extends autoMy_taskActions
{
  protected function addSortCriteria($criteria)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

	//kam
	if($sort[0]=='oiimages_id'){
		$column=OiimagesPeer::NAME;
		$criteria->addJoin(MyTaskPeer::OIIMAGES_ID,OiimagesPeer::ID,Criteria::LEFT_JOIN);			
	}else{
		// camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
		$column = MyTaskPeer::translateFieldName(sfInflector::camelize(strtolower($sort[0])), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
	}
	//	

	if ('asc' == $sort[1])
    {
      $criteria->addAscendingOrderByColumn($column);
    }
    else
    {
      $criteria->addDescendingOrderByColumn($column);
    }
  }
  public function executeIndex(sfWebRequest $request)
  {
	//kam
	/*if (DriverPeer::is_no_query($this->getFilters()))
	{
	  $this->filters = $this->configuration->getFilterForm($this->getFilters());
	  $this->setTemplate('no_query');
    }else{		
		parent::executeIndex($request);
    }*/
	parent::executeIndex($request);
  }
  public function executeProgram(sfWebRequest $request){
	//simulatzeko
	//$this->sortu_serializatua();
	//
	$ids=array();
	if($request->getParameter('ids')){
		$ids=$request->getParameter('ids');
		$this->getUser()->setAttribute('program_ids',$ids);
		$this->getUser()->setAttribute('program_is_associate',false);
		$this->getUser()->setAttribute('program_is_clear',false);
		$this->getUser()->setAttribute('clone_is_now',false);		
	}else{
		if($request->isMethod('get')){
			$ids=$this->getUser()->getAttribute('program_ids');
		}
	}
	if(count($ids)>0){
		$this->pc_list=PcPeer::retrieveByPKs($ids);		
		$this->partition_list=PcPeer::prepare_partitions($this->pc_list);
		$this->oiimages_list=OiimagesPeer::get_oiimages_list();
		$this->oiimages_assoc=OiimagesPeer::get_oiimages_assoc($this->oiimages_list);
		//gemini 2011-02-15
		$this->imageset_assoc=ImagesetPeer::get_imageset_assoc();
		//
		//gaur		
		if(count($this->pc_list)>0){		
			$this->disk_assoc=MyTaskPeer::get_disk_list_by_partition_list(MyTaskPeer::form_partition_list_by_pc($this->pc_list[0]));	
		}else{
			$this->disk_assoc['']='';
		}
		//
		if($request->getParameter('associate_submit')){
			$this->getUser()->setAttribute('program_is_associate',true);				
		}
		//
		if($request->getParameter('clear_program_associate')){
			$this->getUser()->setAttribute('program_is_clear',true);	
		}
		//
		if($request->getParameter('clone_now')){
			$this->getUser()->setAttribute('clone_is_now',true);				
		}
		//
		if($this->getUser()->getAttribute('program_is_associate')){	
			$this->setTemplate('associate');
		}
		//
		if($this->getUser()->getAttribute('clone_is_now')){
			$this->setTemplate('now');
		}
		if($this->getUser()->getAttribute('program_is_clear')){	
			$this->setTemplate('clear');
		}
	}else{
		$this->setTemplate('no_select_pc');
	}	
	
  }
  public function executeProgram_save(sfWebRequest $request){
	$this->exec_program_save($request,false);
  }
  public function executeAssociate_save(sfWebRequest $request){
	//$ids=$request->getParameter('ids');
	$oiimages_id_array=$request->getParameter('oiimages_id');
	/*if(empty($oiimages_id_array)){
		$this->setTemplate('no_select_oiimage');
	}*/

	//gaur
	$this->get_imageset_info($request,$is_imageset,$imageset_id,$is_boot,$imageset_pc_id,$disk);	
	//


	if(OiimagesPeer::is_empty_oiimage($oiimages_id_array)){	
		$this->setTemplate('no_select_oiimage');
	//gemini 2011-02-15
	}else if(!empty($is_imageset) && empty($imageset_id)){	
		$this->setTemplate('no_select_imageset');
	//
	}else{	
		/*$my_task_id_list=PcPeer::get_my_task_id_list($ids);
		//
		$oiimages_id=array_keys($oiimages_id_array);
		//
		$my_task=new MyTask();
		//$my_task->setDay(MyTaskPeer::make_day($request->getParameter('day')));
		//$my_task->setHour(MyTaskPeer::make_hour($request->getParameter('hour')));
		$my_task->setAssociate(1);
		$my_task->setOiimagesId($oiimages_id[0]);
		$my_task->save();
		//
		PcPeer::save_program_pc_list($ids,$my_task->getId());
		MyTaskPeer::delete_task_not_has_pc($my_task_id_list);*/
	
		//gemini 2011-02-15
		MyTaskPeer::delete_my_task_by_pc_id_array(array(0=>$imageset_pc_id));
		if(!empty($is_imageset)){
			$my_task=new MyTask();			
			$my_task->setAssociate(1);
			//$my_task->setOiimagesId(0);
			$my_task->setPartition('');
			$my_task->setPcId($imageset_pc_id);
			$my_task->setIsImageset($is_imageset);
			$my_task->setImagesetId($imageset_id);
			$my_task->setIsBoot($is_boot);
			//gaur
			$my_task->setDisk($disk);
			//
			$my_task->save();		
		}else{
		//
			MyTaskPeer::delete_my_task_partition($oiimages_id_array);
			//
			if(count($oiimages_id_array)>0){
				foreach($oiimages_id_array as $key=>$oiimages_id){
					$key_array=explode('-',$key);				
					$pc_id=$key_array[0];
					$partition=$key_array[1];
					//
					if(!empty($oiimages_id)){	
						$my_task=new MyTask();
						//$my_task->setDay(MyTaskPeer::make_day($request->getParameter('day')));
						//$my_task->setHour(MyTaskPeer::make_hour($request->getParameter('hour')));
						$my_task->setAssociate(1);
						$my_task->setOiimagesId($oiimages_id);
						$my_task->setPartition($partition);
						$my_task->setPcId($pc_id);
						//gemini 2011-02-15
						$my_task->setIsImageset(0);
						//$my_task->setImagesetId($imageset_id);
						$my_task->setIsBoot($is_boot);
						//gaur
						$my_task->setDisk($disk);						
						//
						$my_task->save();
					}
				}
			}
		}	
	}
  }
  public function executeClear_confirm(sfWebRequest $request){
	$ids=$request->getParameter('ids');
	
	/*$my_task_id_list=PcPeer::get_my_task_id_list($ids);
	PcPeer::clear_program_pc_list($ids);
	MyTaskPeer::delete_task_not_has_pc($my_task_id_list);*/
	
	MyTaskPeer::delete_my_task_by_pc_id_array($ids);
  }
  public function executeShow(sfWebRequest $request)
  {	    
    parent::executeShow($request);
	//kam
	/*$pc_list=PcPeer::get_pc_list_by_my_task_id($this->my_task->getId());
	$this->pc_list_html=PcPeer::make_pc_list_html($pc_list);*/	
	//
  }
  private function sortu_serializatua(){
		$my_array=array();
		$k=0;		
		for($k=0;$k<2;$k++){
			$num=4;
			for($i=1;$i<=$num;$i++){		
				$row=array();
				if($k==0){
					$row['partitionName'] = 'hda'.$i;
				}else{
					$row['partitionName'] = 'sda'.$i;
				}
				$row['startSector'] = 20980890;
				$row['sectors'] = 6291456;
				$row['size'] = ($i+5).'GB';
				$row['partitionTypeId'] = 83;
				$row['partitionTypeName'] = 'Linux';
				if($i<2){
					$row['fstype'] = 'oiSystem';
				}else{
					$row['fstype'] = 'edozein';
				}
				$my_array['serial'.$k][$i-1]=$row;
			}
		}
		//echo print_r($my_array,1);
		echo serialize($my_array);		
exit();
  }
  protected function getPager()
  {
    $pager = $this->configuration->getPager('MyTask');
    $pager->setCriteria($this->buildCriteria());
    $pager->setPage($this->getPage());
    //kam
	//$pager->setPeerMethod($this->configuration->getPeerMethod());
    $pager->setPeerMethod('doSelectCustom');
    //kam
    //$pager->setPeerCountMethod($this->configuration->getPeerCountMethod());
	$pager->setPeerCountMethod('doCountCustom');
    $pager->init();

    return $pager;
  }
  public function executeFilter(sfWebRequest $request)
  {
    if ($request->hasParameter('_reset'))
    {
      $this->setFilters(array());

	 //kam
	 $this->getUser()->getAttributeHolder()->remove('my_task_hour_filter');
	 //		

      $this->redirect('@my_task');
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());
	
    $this->filters->bind($request->getParameter($this->filters->getName()));
	
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());

	  //kam		
	  $this->getUser()->setAttribute('my_task_hour_filter',$request->getParameter('my_task_filters[hour]'));	
	  //	

      $this->redirect('@my_task');
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    $this->setTemplate('index');
  }
  private function exec_program_save($request,$is_now=false){
	//$ids=$request->getParameter('ids');
	$oiimages_id_array=$request->getParameter('oiimages_id');

	//gaur
	$this->get_imageset_info($request,$is_imageset,$imageset_id,$is_boot,$imageset_pc_id,$disk);	
	//

	//if(empty($oiimages_id_array)){
	if(OiimagesPeer::is_empty_oiimage($oiimages_id_array)){	
		$this->setTemplate('no_select_oiimage');
	//gemini 2011-02-15	
	}else if(!empty($is_imageset) && empty($imageset_id)){	
		$this->setTemplate('no_select_imageset');
	}else{
		/*
		$my_task_id_list=PcPeer::get_my_task_id_list($ids);
		//
		$oiimages_id=array_keys($oiimages_id_array);
		//
		$my_task=new MyTask();
		$my_task->setDay(MyTaskPeer::make_day($request->getParameter('day')));
		$my_task->setHour(MyTaskPeer::make_hour($request->getParameter('hour')));
		$my_task->setAssociate(0);
		$my_task->setOiimagesId($oiimages_id[0]);
		$my_task->save();
		//
		PcPeer::save_program_pc_list($ids,$my_task->getId());
		MyTaskPeer::delete_task_not_has_pc($my_task_id_list);*/

		//gemini 2011-02-15
		MyTaskPeer::delete_my_task_by_pc_id_array(array(0=>$imageset_pc_id));
		if(!empty($is_imageset)){
			$my_task=new MyTask();
			if($is_now){
				$my_task->setDay(date('Y-m-d'));
				$my_task->setHour(date('H:i').':00');
			}else{
				$my_task->setDay(MyTaskPeer::make_day($request->getParameter('day')));
				$my_task->setHour(MyTaskPeer::make_hour($request->getParameter('hour')));
			}
			$my_task->setAssociate(0);
			//$my_task->setOiimagesId(0);
			$my_task->setPartition('');
			$my_task->setPcId($imageset_pc_id);
			$my_task->setIsImageset($is_imageset);
			$my_task->setImagesetId($imageset_id);
			$my_task->setIsBoot($is_boot);
			//gaur
			$my_task->setDisk($disk);
			//
			$my_task->save();		
		}else{
		//
			MyTaskPeer::delete_my_task_partition($oiimages_id_array);
	
			//
			if(count($oiimages_id_array)>0){
				foreach($oiimages_id_array as $key=>$oiimages_id){
					$key_array=explode('-',$key);				
					$pc_id=$key_array[0];
					$partition=$key_array[1];
					//
					if(!empty($oiimages_id)){	
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
						//gemini 2011-02-15
						$my_task->setIsImageset(0);
						//$my_task->setImagesetId($imageset_id);
						$my_task->setIsBoot($is_boot);
						//
						//gaur
						$my_task->setDisk($disk);
						//
						$my_task->save();
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
  public function executeNow_save(sfWebRequest $request){
	$this->exec_program_save($request,true);
  }	
  //gaur
  private function get_imageset_info($request,&$is_imageset,&$imageset_id,&$is_boot,&$imageset_pc_id,&$disk){
  	$is_imageset=0;	
	if($request->getParameter('is_imageset')){
		$is_imageset=$request->getParameter('is_imageset');
	}	
	$imageset_id=$request->getParameter('imageset_id');
	$is_boot=0;
	if($request->getParameter('is_boot')){
		$is_boot=$request->getParameter('is_boot');
	}
	$imageset_pc_id=$request->getParameter('imageset_pc_id');
	//gaur
	$disk='';
	if($request->getParameter('disk')){
		$disk=$request->getParameter('disk');
	}
	//
  }   
}
