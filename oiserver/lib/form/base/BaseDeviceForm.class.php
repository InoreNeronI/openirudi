<?php

/**
 * Device form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseDeviceForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'code'      => new sfWidgetFormInput(),
      'vendor_id' => new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => false)),
      'type_id'   => new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => false)),
      'name'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorPropelChoice(array('model' => 'Device', 'column' => 'id', 'required' => false)),
      'code'      => new sfValidatorString(array('max_length' => 4)),
      'vendor_id' => new sfValidatorPropelChoice(array('model' => 'Vendor', 'column' => 'code')),
      'type_id'   => new sfValidatorPropelChoice(array('model' => 'Type', 'column' => 'id')),
      'name'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('device[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Device';
  }


}
