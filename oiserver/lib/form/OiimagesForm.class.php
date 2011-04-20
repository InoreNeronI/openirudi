<?php

/**
 * Oiimages form.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class OiimagesForm extends BaseOiimagesForm
{
  public function configure()
  {
      $this->widgetSchema['ref']=new sfWidgetFormInputHidden();
      $this->widgetSchema['os']=new sfWidgetFormInputHidden();
      $this->widgetSchema['uuid']=new sfWidgetFormInputHidden();
      $this->widgetSchema['created_at']=new sfWidgetFormInputHidden();
      $this->widgetSchema['partition_size']=new sfWidgetFormInputHidden();
      $this->widgetSchema['partition_type']=new sfWidgetFormInputHidden();
      $this->widgetSchema['filesystem_size']=new sfWidgetFormInputHidden();
      $this->widgetSchema['filesystem_type']=new sfWidgetFormInputHidden();
      $this->widgetSchema['path']=new sfWidgetFormInputHidden();
      
  }
}
