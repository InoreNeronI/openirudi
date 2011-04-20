<?php

/**
 * MyTask form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseMyTaskForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'day'         => new sfWidgetFormDate(),
      'hour'        => new sfWidgetFormTime(),
      'associate'   => new sfWidgetFormInputCheckbox(),
      'oiimages_id' => new sfWidgetFormPropelChoice(array('model' => 'Oiimages', 'add_empty' => true)),
      'partition'   => new sfWidgetFormInput(),
      'pc_id'       => new sfWidgetFormPropelChoice(array('model' => 'Pc', 'add_empty' => true)),
      'is_imageset' => new sfWidgetFormInputCheckbox(),
      'imageset_id' => new sfWidgetFormPropelChoice(array('model' => 'Imageset', 'add_empty' => true)),
      'is_boot'     => new sfWidgetFormInputCheckbox(),
      'disk'        => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'MyTask', 'column' => 'id', 'required' => false)),
      'day'         => new sfValidatorDate(array('required' => false)),
      'hour'        => new sfValidatorTime(array('required' => false)),
      'associate'   => new sfValidatorBoolean(array('required' => false)),
      'oiimages_id' => new sfValidatorPropelChoice(array('model' => 'Oiimages', 'column' => 'id', 'required' => false)),
      'partition'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'pc_id'       => new sfValidatorPropelChoice(array('model' => 'Pc', 'column' => 'id', 'required' => false)),
      'is_imageset' => new sfValidatorBoolean(array('required' => false)),
      'imageset_id' => new sfValidatorPropelChoice(array('model' => 'Imageset', 'column' => 'id', 'required' => false)),
      'is_boot'     => new sfValidatorBoolean(array('required' => false)),
      'disk'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('my_task[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MyTask';
  }


}
