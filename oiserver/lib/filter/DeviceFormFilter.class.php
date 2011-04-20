<?php

/**
 * Device filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class DeviceFormFilter extends BaseDeviceFormFilter {
    public function configure() {
		//kam
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));
	
        /*unset($this->widgetSchema['vendor_id']);
        unset($this->validatorSchema['vendor_id']);*/

//        $this->setWidget('vendor_id', new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => true, 'key_method' => 'getPrimaryKeys')));
//        $this->setValidator('vendor_id', new sfValidatorPropelChoice(array('required' => false, 'model' => 'Vendor', 'column' => array('code', 'type_id'))));
        
		//kam
		//$this->widgetSchema['vendor_id']= new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => true, 'key_method' => 'getPrimaryKeys'));
		//kam
		$this->widgetSchema['vendor_id']   = new sfWidgetFormChoice(array(
                                                'choices'          => array(),
                                                'renderer_class'   => 'sfWidgetFormJQueryAutocompleter',
                                                'renderer_options' => array('url' => url_for('@ajax?action=vendor'),
                                                                            'config' => '{
                                                                                          width: 320,
                                                                                          max: 10,
                                                                                          highlight: false,
                                                                                          multiple: false,
                                                                                          scroll: false,
                                                                                          scrollHeight: 300
                                                                                         }',
																			//'value_callback' => 'getActividad'
                                                                            
                        ),
                    ));
		$this->validatorSchema=$this->validatorSchema['vendor_id']=new sfValidatorPass(array('required' => false));
		//kam
		$this->widgetSchema['code']= new sfWidgetFormFilterInput(array('with_empty'=>false));
		$this->widgetSchema['name']= new sfWidgetFormFilterInput(array('with_empty'=>false));
    }
}