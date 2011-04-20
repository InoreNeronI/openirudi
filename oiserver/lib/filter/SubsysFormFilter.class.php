<?php

/**
 * Subsys filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class SubsysFormFilter extends BaseSubsysFormFilter {

    public function configure() {
		 //kam
		 sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));
		 //

//       $this->setWidget('vendor', new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => true, 'key_method' => 'getPrimaryKeys')));
//       $this->setValidator('vendor', new sfValidatorPropelChoice(array('required' => false, 'model' => 'Vendor', 'column' => array('code', 'type_id'))));
//       $this->setWidget('type', new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => true, 'key_method' => 'getDevicesByTypeId')));
//       $this->setValidator('type', new sfValidatorPropelChoice(array('required' => false, 'model' => 'Type', 'column' => 'id')));
		 //kam
		 $this->widgetSchema['code']= new sfWidgetFormFilterInput(array('with_empty'=>false));
		 $this->widgetSchema['revision']= new sfWidgetFormFilterInput(array('with_empty'=>false));
		 //kam
		 $this->widgetSchema['device_id']= new sfWidgetFormFilterInput(array('with_empty'=>false)); 
		/*$this->widgetSchema['device_id']   = new sfWidgetFormChoice(array(
                                                'choices'          => array(),
                                                'renderer_class'   => 'sfWidgetFormJQueryAutocompleter',
                                                'renderer_options' => array('url' => url_for('@ajax?action=device_id'),
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
                    ));*/			
		 $this->widgetSchema['name']= new sfWidgetFormFilterInput(array('with_empty'=>false));
		 //kam
		 $this->validatorSchema['code']=new sfValidatorPass(array('required' => false));
		 $this->validatorSchema['revision']=new sfValidatorPass(array('required' => false));
		 $this->validatorSchema['device_id']=new sfValidatorPass(array('required' => false));				 	
    }

}