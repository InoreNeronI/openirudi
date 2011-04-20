<?php

/**
 * System filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class SystemFormFilter extends BaseSystemFormFilter
{
  public function configure()
  {
      //kam	
	  
      sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));
	  
      unset($this['driver_id']);
	  
		$this->widgetSchema['driver_name']   = new sfWidgetFormChoice(array(
                                                'choices'          => array(),
                                                'renderer_class'   => 'sfWidgetFormJQueryAutocompleter',
                                                'renderer_options' => array('url' => url_for('@ajax?action=driver_name'),
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
	  $this->widgetSchema['name']= new sfWidgetFormFilterInput(array('with_empty'=>false));	
 	  //
	  $this->validatorSchema['driver_name']=new sfValidatorPass(array('required' => false));		   
 }
}
