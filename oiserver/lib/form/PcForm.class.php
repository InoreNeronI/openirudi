<?php

/**
 * Pc form.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class PcForm extends BasePcForm
{
  public function configure()
  {
		//kam
		unset($this['dns']);
		unset($this['partitions']);
		$this->widgetSchema['dns1']=new sfWidgetFormInput();
		$this->widgetSchema['dns2']=new sfWidgetFormInput();
		//
		//kam
		$this->validatorSchema['dns1']=new sfValidatorPass(array('required' => false));
		$this->validatorSchema['dns2']=new sfValidatorPass(array('required' => false));
		//
  }
}
