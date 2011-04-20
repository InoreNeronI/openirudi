<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * System filter form base class.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseSystemFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'driver_id' => new sfWidgetFormPropelChoice(array('model' => 'Driver', 'add_empty' => true)),
      'name'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'driver_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Driver', 'column' => 'id')),
      'name'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('system_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'System';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'driver_id' => 'ForeignKey',
      'name'      => 'Text',
    );
  }
}
