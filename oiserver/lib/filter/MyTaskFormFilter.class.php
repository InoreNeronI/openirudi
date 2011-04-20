<?php

/**
 * MyTask filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class MyTaskFormFilter extends BaseMyTaskFormFilter
{
  public function configure()
  {
	//kam
	$this->widgetSchema['partition']   = new sfWidgetFormFilterInput(array('with_empty'=>false));
	$this->widgetSchema['day']   = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')), 'to_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')),'template'  => '%from_date%&nbsp;-&nbsp;%to_date%', 'with_empty' => false));    
    $bat=new sfWidgetFormTime(array('format' => '%hour% : %minute%'));
	$bat->setDefault(array('hour'=>12,'minute'=>12,'second'=>12));
	$this->widgetSchema['hour']   = new sfWidgetFormFilterDate(array('from_date' => $bat, 'to_date' => new sfWidgetFormTime(array('format' => '%hour% : %minute%')),'template'  => '%from_date%&nbsp;-&nbsp;%to_date%', 'with_empty' => false));   	
	//    
  }
}
