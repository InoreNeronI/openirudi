<?php

require_once dirname(__FILE__).'/../lib/pcGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/pcGeneratorHelper.class.php';

/**
 * pc actions.
 *
 * @package    drivers
 * @subpackage pc
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class pcActions extends autoPcActions
{
  public function executeIndex(sfWebRequest $request)
  {
	//kam
	/*if (DriverPeer::is_no_query($this->getFilters()))
	{
	  $this->filters = $this->configuration->getFilterForm($this->getFilters());
	  $this->setTemplate('no_query');
    }else{
		//$this->migration_ekipoak();
		parent::executeIndex($request);
    }*/
	parent::executeIndex($request);
	$this->pc_id_js_array=$this->get_pc_id_js_array();
  }
  //kam	
  //OHARRA::::taula betezeko da	
  public function migration_ekipoak(){
	$f=fopen(sfConfig::get('sf_root_dir').'/doc/ekipoak.lst','r');
	if($f){
		$kont=0;
		while (!feof($f)) {
			$line=fgets($f);
			$my_array=array();
			$my_array=explode(';',$line);			
			if((count($my_array)==3) && isset($my_array[0]) && isset($my_array[1]) && isset($my_array[2])){
				$i=($kont % 4)+1;
				//echo $i.'<BR/>';
				$mac=$my_array[0];
				$ip=$my_array[1];
				$name=trim($my_array[2]);
				$my_pc=new Pc();
				$my_pc->setMac($mac);
    			$my_pc->setHddid('hddid'.$kont);
    			$my_pc->setName($name);
    			$my_pc->setIp($ip);
    			$my_pc->setNetmask('255.255.255.'.$kont);
    			$my_pc->setGateway('192.168.110.'.$i); 
    			$my_pc->setDns('99.77.110.'.$i); 
    			$my_pc->setPcgroupId($i+1);
    			$my_pc->setPartitions('hda'.$i);
				$my_pc->save();
				//
				$kont++;
			}
		}
		fclose($f);
	}else{
		echo 'fopen error';exit();
	}	
  }
  //kam
  protected function addSortCriteria($criteria)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

	if($sort[0]=='pcgroup_id'){
		$column=PcgroupPeer::NAME;
		$criteria->addJoin(PcPeer::PCGROUP_ID,PcgroupPeer::ID,Criteria::LEFT_JOIN);
	}else{
		// camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
    	$column = PcPeer::translateFieldName(sfInflector::camelize(strtolower($sort[0])), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
    }

	if ('asc' == $sort[1])
    {
      $criteria->addAscendingOrderByColumn($column);
    }
    else
    {
      $criteria->addDescendingOrderByColumn($column);
    }
  }
  //
  //kam	
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');

      $pc = $form->save();

		//kam
		$dns1=$form->getValue('dns1');
		$dns2=$form->getValue('dns2');
		$pc->setDns($dns1.';'.$dns2);
		$pc->save();
		//


      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $pc)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        $this->redirect('@pc_new');
      }
      else
      {
        $this->redirect('@pc_edit?id='.$pc->getId());
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.');
    }
  }
  //	
  //kam
  public function executeEdit(sfWebRequest $request)
  {
    /*$this->pc = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->pc);*/
	parent::executeEdit($request);
	$this->form->setDefault('dns1',$this->pc->getDns1());
	$this->form->setDefault('dns2',$this->pc->getDns2());
  }
  //kam
  private function get_pc_id_js_array(){
	$result=array();
	
	//if ($this->$pager->getNbResults()):

	if($this->pager->getNbResults()>0){
		foreach ($this->pager->getResults() as $i => $pc){
			$result[]=$pc->getId();
		}
	}

	return implode(',',$result);	
  }	
}
