<?php

/**
 * Pcgroup filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class PcgroupFormFilter extends BasePcgroupFormFilter
{
  public function configure()
  {
	$this->widgetSchema['name'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
  }
}
