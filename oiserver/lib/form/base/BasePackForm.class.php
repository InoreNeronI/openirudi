<?php

/**
 * Pack form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BasePackForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'path_id'      => new sfWidgetFormPropelChoice(array('model' => 'Path', 'add_empty' => false)),
      'name'         => new sfWidgetFormTextarea(),
      'version'      => new sfWidgetFormInput(),
      'release_date' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'Pack', 'column' => 'id', 'required' => false)),
      'path_id'      => new sfValidatorPropelChoice(array('model' => 'Path', 'column' => 'id')),
      'name'         => new sfValidatorString(array('required' => false)),
      'version'      => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'release_date' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pack[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pack';
  }


}
