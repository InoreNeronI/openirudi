<?php

/**
 * Oiimages form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseOiimagesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'ref'             => new sfWidgetFormInput(),
      'name'            => new sfWidgetFormInput(),
      'description'     => new sfWidgetFormTextarea(),
      'os'              => new sfWidgetFormInput(),
      'uuid'            => new sfWidgetFormInput(),
      'created_at'      => new sfWidgetFormDateTime(),
      'partition_size'  => new sfWidgetFormInput(),
      'partition_type'  => new sfWidgetFormInput(),
      'filesystem_size' => new sfWidgetFormInput(),
      'filesystem_type' => new sfWidgetFormInput(),
      'path'            => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'Oiimages', 'column' => 'id', 'required' => false)),
      'ref'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'description'     => new sfValidatorString(array('required' => false)),
      'os'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'uuid'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'partition_size'  => new sfValidatorInteger(array('required' => false)),
      'partition_type'  => new sfValidatorInteger(),
      'filesystem_size' => new sfValidatorInteger(array('required' => false)),
      'filesystem_type' => new sfValidatorString(array('max_length' => 50)),
      'path'            => new sfValidatorString(array('max_length' => 250, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('oiimages[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Oiimages';
  }


}
