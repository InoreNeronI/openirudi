<?php

/**
 * AsignImageset form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseAsignImagesetForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'name'        => new sfWidgetFormInput(),
      'imageset_id' => new sfWidgetFormPropelChoice(array('model' => 'Imageset', 'add_empty' => true)),
      'oiimages_id' => new sfWidgetFormPropelChoice(array('model' => 'Oiimages', 'add_empty' => true)),
      'size'        => new sfWidgetFormInput(),
      'position'    => new sfWidgetFormInput(),
      'color'       => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'AsignImageset', 'column' => 'id', 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 255)),
      'imageset_id' => new sfValidatorPropelChoice(array('model' => 'Imageset', 'column' => 'id', 'required' => false)),
      'oiimages_id' => new sfValidatorPropelChoice(array('model' => 'Oiimages', 'column' => 'id', 'required' => false)),
      'size'        => new sfValidatorNumber(array('required' => false)),
      'position'    => new sfValidatorInteger(array('required' => false)),
      'color'       => new sfValidatorString(array('max_length' => 10, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('asign_imageset[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsignImageset';
  }


}
