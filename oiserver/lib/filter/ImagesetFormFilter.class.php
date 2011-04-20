<?php

/**
 * Imageset filter form.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class ImagesetFormFilter extends BaseImagesetFormFilter
{
  public function configure()
  {
	$this->widgetSchema['name'] = new sfWidgetFormFilterInput(array('with_empty'=>false));
  }
}
