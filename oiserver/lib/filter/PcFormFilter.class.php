<?php

/**
 * Pc filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class PcFormFilter extends BasePcFormFilter
{
  public function configure()
  {
	  //kam
	  $this->widgetSchema['mac']        = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['hddid']      = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['name']       = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['ip']         = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['netmask']    = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['gateway']    = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['dns']        = new sfWidgetFormFilterInput(array('with_empty'=>false));      
      $this->widgetSchema['partitions']= new sfWidgetFormFilterInput(array('with_empty'=>false));
  	  //
  }
}
