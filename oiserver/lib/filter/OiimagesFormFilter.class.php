<?php

/**
 * Oiimages filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class OiimagesFormFilter extends BaseOiimagesFormFilter
{
  public function configure()
  {
	  //kam
      $this->widgetSchema['ref'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['name'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['description'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
      //$this->widgetSchema['so'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['os'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
	  //kam
	  //$this->widgetSchema['created_at']= new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false));
      $this->widgetSchema['created_at']   = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')), 'to_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')),'template'  => '%from_date%&nbsp;-&nbsp;%to_date%', 'with_empty' => false));
      //	
	  $this->widgetSchema['partition_size'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
	  $this->widgetSchema['partition_type'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['filesystem_size'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
	  $this->widgetSchema['filesystem_type'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['path'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
      //      
  }
}
