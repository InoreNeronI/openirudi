<?php

/**
 * Driver filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class DriverFormFilter extends BaseDriverFormFilter {
    public function configure() {
		//kam
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Url'));	
		//kam
        /*
         $this->setWidgets(array(
          'type_id'    => new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => true)),
          'vendor_id'  => new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => true, 'key_method' => 'getPrimaryKeys')),
          'device_id'  => new sfWidgetFormPropelChoice(array('model' => 'Device', 'add_empty' => true, 'key_method' => 'getCode')),
          'class_type' => new sfWidgetFormFilterInput(),
          'name'       => new sfWidgetFormFilterInput(),
          'date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
          'string'     => new sfWidgetFormFilterInput(),
          'url'        => new sfWidgetFormFilterInput(),
        ));*/
        //kam
        $this->widgetSchema['type_id']    = new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => true));
        //$this->widgetSchema['vendor_id']  = new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => true, 'key_method' => 'getPrimaryKeys','peer_method'=>'get_vendor_id_list','method'=>'getCode'));
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
		//
		//$this->widgetSchema['device_id']  = new sfWidgetFormPropelChoice(array('model' => 'Device', 'add_empty' => true, 'key_method' => 'getCode'));
        //kam
		/*$this->widgetSchema['device_id']   = new sfWidgetFormChoice(array(
                                                'choices'          => array(),
                                                'renderer_class'   => 'sfWidgetFormJQueryAutocompleter',
                                                'renderer_options' => array('url' => url_for('@ajax?action=device'),
                                                                            'config' => '{
                                                                                          width: 320,
                                                                                          max: 10,
                                                                                          highlight: false,
                                                                                          multiple: false,
                                                                                          scroll: false,
                                                                                          scrollHeight: 300
                                                                                         }',
																			'value_callback' => 'getDevice'
                                                                            
                        ),
                    ));*/
		//

		$this->widgetSchema['class_type'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
        $this->widgetSchema['name']       = new sfWidgetFormFilterInput(array('with_empty'=>false));
        //kam
		// $this->widgetSchema['date']       = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false));
        $this->widgetSchema['date']   = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')), 'to_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')),'template'  => '%from_date%&nbsp;-&nbsp;%to_date%', 'with_empty' => false));
    	//
		$this->widgetSchema['string']     = new sfWidgetFormFilterInput(array('with_empty'=>false));
        $this->widgetSchema['url']        = new sfWidgetFormFilterInput(array('with_empty'=>false));
        //

        //kam
        unset($this['created_at']);
        $this->validatorSchema['vendor_id']=new sfValidatorPass(array('required' => false));
		$this->validatorSchema['device_id']=new sfValidatorPass(array('required' => false));
        //
        unset($this->validatorSchema['created_at']);
    }
}
