<?php

/**
 * Subsys form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseSubsysForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'      => new sfWidgetFormInputHidden(),
      'device_id' => new sfWidgetFormInputHidden(),
      'revision'  => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'code'      => new sfValidatorPropelChoice(array('model' => 'Subsys', 'column' => 'code', 'required' => false)),
      'device_id' => new sfValidatorPropelChoice(array('model' => 'Device', 'column' => 'id', 'required' => false)),
      'revision'  => new sfValidatorPropelChoice(array('model' => 'Subsys', 'column' => 'revision', 'required' => false)),
      'name'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('subsys[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Subsys';
  }


}
