<?php

require_once dirname(__FILE__).'/../lib/pcgroupGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/pcgroupGeneratorHelper.class.php';

/**
 * pcgroup actions.
 *
 * @package    drivers
 * @subpackage pcgroup
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class pcgroupActions extends autoPcgroupActions
{
  //kam
  public function executeIndex(sfWebRequest $request)
  {	
	parent::executeIndex($request);
	$this->group_id_js_array=$this->get_group_id_js_array();
  }
  //kam
  private function get_group_id_js_array(){
	$result=array();
	
	//if ($this->$pager->getNbResults()):

	if($this->pager->getNbResults()>0){
		foreach ($this->pager->getResults() as $i => $group){
			$result[]=$group->getId();
		}
	}

	return implode(',',$result);	
  }	
}
