<?php

/**
 * Driver form.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class DriverForm extends BaseDriverForm {
    public function configure() {
        //kam
		/*$this->setWidgets(array(
          'id'         => new sfWidgetFormInputHidden(),
          'type_id'    => new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => false)),
          'vendor_id'  => new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => false, 'key_method' => 'getPrimaryKeys')),
          'device_id'  => new sfWidgetFormPropelChoice(array('model' => 'Device', 'add_empty' => false, 'key_method' => 'getCode')),
          'class_type' => new sfWidgetFormInput(),
          'name'       => new sfWidgetFormTextarea(),
          'date'       => new sfWidgetFormDate(),
          'string'     => new sfWidgetFormInput(),
          'url'        => new sfWidgetFormInput(),
          'created_at' => new sfWidgetFormDateTime(),
        ));*/
		//kam
		unset($this['created_at']);
		//kam
		$this->widgetSchema['id']         = new sfWidgetFormInputHidden();
        $this->widgetSchema['type_id']    = new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => false));
        $this->widgetSchema['vendor_id']  = new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => false, 'key_method' => 'getPrimaryKeys'));
        $this->widgetSchema['device_id']  = new sfWidgetFormPropelChoice(array('model' => 'Device', 'add_empty' => false, 'key_method' => 'getCode'));
       	$this->widgetSchema['class_type'] = new sfWidgetFormInput();
        $this->widgetSchema['name']       = new sfWidgetFormTextarea();
        $this->widgetSchema['date']       = new sfWidgetFormI18nDate(array('culture'=>sfContext::getInstance()->getUser()->getCulture()));
        $this->widgetSchema['string']     = new sfWidgetFormInput();
        $this->widgetSchema['url']        = new sfWidgetFormInput();
        //$this->widgetSchema['created_at'] = new sfWidgetFormDateTime();
		//kam
		$this->validatorSchema['vendor_id'] = new sfValidatorChoice(array('choices'=>VendorPeer::get_choices_primary_compose()));
		//
    }
}
