<?php

/**
 * MyTask form.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MyTaskForm extends BaseMyTaskForm
{
  public function configure()
  {
		//kam
		$culture=sfContext::getInstance()->getUser()->getCulture();

		if(empty($culture)){
			$culture='eu';
		}
		//
		
		//kam
		$this->widgetSchema['day']=new sfWidgetFormI18nDate(array('culture'=>$culture)); 
		//

		$this->widgetSchema['partition']   = new sfWidgetFormChoice(array('choices' => MyTaskPeer::form_partition_list()));
  		$this->setDefault('partition','sda6');
		
		//gaur
		$this->widgetSchema['disk']   = new sfWidgetFormChoice(array('choices' => MyTaskPeer::form_disk_list()));  		
		//$this->set_disk_value();
		$this->validatorSchema['disk']   = new sfValidatorPass(array('required' => false));
		//		
		
  }
  //gaur
  private function set_disk_value(){
  	$request=sfContext::getInstance()->getRequest();
	$action=$request->getParameter('action');
	if($action=='edit'){
		$id=$request->getParameter('id');
		$my_task=MyTaskPeer::retrieveByPk($id);
		$disk=$my_task->getDisk();
		//echo $disk;
		//$this->setDefault('disk',1);		
	}
  }
}
