<?php

/**
 * Vendor filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class VendorFormFilter extends BaseVendorFormFilter {

    public function configure() {
       //kam
	   $this->widgetSchema['name']= new sfWidgetFormFilterInput(array('with_empty'=>false));
	   $this->widgetSchema['code']= new sfWidgetFormFilterInput(array('with_empty'=>false));
	   //	
	   $this->setWidget('type_id', new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => true, 'key_method' => 'getVendorsByTypeId')));
       $this->setValidator('type_id', new sfValidatorPropelChoice(array('required' => false, 'model' => 'Type', 'column' => 'id')));
       //
       $this->validatorSchema['code']=new sfValidatorPass(array('required' => false));	
	}

}