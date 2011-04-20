<?php

/**
 * sfGuardUser filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfGuardUserFormFilter.class.php 12896 2008-11-10 19:02:34Z fabien $
 */
class sfGuardUserFormFilter extends BasesfGuardUserFormFilter
{
  public function configure()
  {
    unset($this['algorithm'], $this['salt'], $this['password']);

	//kam
	$this->widgetSchema['username']                      = new sfWidgetFormFilterInput(array('with_empty'=>false));
    //$this->widgetSchema['created_at']                    = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false));
    $this->widgetSchema['created_at']   = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')), 'to_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')),'template'  => '%from_date%&nbsp;-&nbsp;%to_date%', 'with_empty' => false));      	  
    //$this->widgetSchema['last_login']                    = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false));   
	$this->widgetSchema['last_login']   = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')), 'to_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')),'template'  => '%from_date%&nbsp;-&nbsp;%to_date%', 'with_empty' => false));      	
	//

    $this->widgetSchema['sf_guard_user_group_list']->setLabel('Groups');
    $this->widgetSchema['sf_guard_user_permission_list']->setLabel('Permissions');
  }
}
