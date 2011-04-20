<?php

require_once dirname(__FILE__).'/../lib/imagesetGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/imagesetGeneratorHelper.class.php';

/**
 * imageset actions.
 *
 * @package    drivers
 * @subpackage imageset
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class imagesetActions extends autoImagesetActions
{
  public function executeIndex(sfWebRequest $request)
  {
	/*
	//kam
	if (DriverPeer::is_no_query($this->getFilters()))
	{
	  $this->filters = $this->configuration->getFilterForm($this->getFilters());
	  $this->setTemplate('no_query');
    }else{		
		parent::executeIndex($request);
    }*/
	parent::executeIndex($request);	
  }
  protected function processForm(sfWebRequest $request, sfForm $form)
  {

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');

      $imageset = $form->save();

	  //gemini
	  AsignImagesetPeer::save_asign_imageset($imageset->getId());
	  //

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $imageset)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        $this->redirect('@imageset_new');
      }
      else
      {
        $this->redirect('@imageset_edit?id='.$imageset->getId());
      }
    }
    else
    {
      //gemini
	  $this->load_no_validate_vars($request);	
	  //
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.');
    }
  }
  public function executeNew(sfWebRequest $request)
  {
    $this->my_load_vars();
	$this->pp=AsignImagesetPeer::get_pp_array('',$this->size);
    parent::executeNew($request);
  }
  public function executeEdit(sfWebRequest $request)
  {
    $this->my_load_vars();
	$this->pp=AsignImagesetPeer::get_pp_array($request->getParameter('id'),$this->size);
    parent::executeEdit($request);
  }
  private function my_load_vars(){
    $this->mm=OiimagesPeer::get_mm_array();
	$this->size=100;	
  }
  private function load_no_validate_vars($request){
		$this->my_load_vars();
		$this->pp=array();
		//		
		$partition_names=$request->getParameter('partition_names');
		$type=$request->getParameter('type');
		$partition_sizes=$request->getParameter('partition_sizes');
		$partition_colors=$request->getParameter('partition_colors');
		//
		$partition_names=array_values($partition_names);
		$type=array_values($type);
		$partition_sizes=array_values($partition_sizes);
		$partition_colors=array_values($partition_colors);
		//
		$kont=0;		
		if(count($partition_names)>0){
			foreach($partition_names as $i=>$name){
				if(isset($type[$kont]) && isset($partition_sizes[$kont]) && isset($partition_colors[$kont])){
					$row=array();					
					$row['id']=$kont+1;
					$row['name']=$name;
					$row['size']=(int) $partition_sizes[$kont];
					$row['type']=$type[$kont];
					$row['color']=$partition_colors[$kont];
					$row['loked']=0;
					$this->pp[]=$row;							
				}
				$kont++;
			}
		}
		if(count($this->pp)==0){
			$this->pp=AsignImagesetPeer::get_pp_array('',$this->size);
		}
  }
  //gemini
  public function executeShow(sfWebRequest $request)
  {    
    $this->my_load_vars();
	$this->pp=AsignImagesetPeer::get_pp_array($request->getParameter('id'),$this->size);
    parent::executeShow($request);
  }
}
