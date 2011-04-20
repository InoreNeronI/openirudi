<?php

/**
 * System form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseSystemForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'driver_id' => new sfWidgetFormPropelChoice(array('model' => 'Driver', 'add_empty' => false)),
      'name'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorPropelChoice(array('model' => 'System', 'column' => 'id', 'required' => false)),
      'driver_id' => new sfValidatorPropelChoice(array('model' => 'Driver', 'column' => 'id')),
      'name'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('system[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'System';
  }


}
