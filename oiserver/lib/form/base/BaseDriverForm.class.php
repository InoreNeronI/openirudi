<?php

/**
 * Driver form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseDriverForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'type_id'    => new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => false)),
      'vendor_id'  => new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => false)),
      'device_id'  => new sfWidgetFormPropelChoice(array('model' => 'Device', 'add_empty' => false, 'key_method' => 'getCode')),
      'class_type' => new sfWidgetFormInput(),
      'name'       => new sfWidgetFormTextarea(),
      'date'       => new sfWidgetFormDate(),
      'string'     => new sfWidgetFormInput(),
      'url'        => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Driver', 'column' => 'id', 'required' => false)),
      'type_id'    => new sfValidatorPropelChoice(array('model' => 'Type', 'column' => 'id')),
      'vendor_id'  => new sfValidatorPropelChoice(array('model' => 'Vendor', 'column' => 'code')),
      'device_id'  => new sfValidatorPropelChoice(array('model' => 'Device', 'column' => 'code')),
      'class_type' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'name'       => new sfValidatorString(array('required' => false)),
      'date'       => new sfValidatorDate(array('required' => false)),
      'string'     => new sfValidatorString(array('max_length' => 255)),
      'url'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Driver', 'column' => array('string')))
    );

    $this->widgetSchema->setNameFormat('driver[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Driver';
  }


}
