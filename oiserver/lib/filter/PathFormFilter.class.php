<?php

/**
 * Path filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class PathFormFilter extends BasePathFormFilter
{
  public function configure()
  {
	  //kam
      sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));
	  //

      //kam
	  //bestela errorea ematen du
      unset($this['driver_id']);
	  //

	  //kam
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
	  $this->widgetSchema['path']= new sfWidgetFormFilterInput(array('with_empty'=>false));		
  	  /*$this->widgetSchema['type_id']    = new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => true));
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
                    ));*/
	  //
	  //kam
	  $this->validatorSchema['driver_name']=new sfValidatorPass(array('required' => false));
      /*$this->validatorSchema['type_id']=new sfValidatorPass(array('required' => false));
	  $this->validatorSchema['vendor_id']=new sfValidatorPass(array('required' => false));*/
  }
}
