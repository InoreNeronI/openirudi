<?php

/**
 * Vendor form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseVendorForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'    => new sfWidgetFormInputHidden(),
      'type_id' => new sfWidgetFormInputHidden(),
      'name'    => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'code'    => new sfValidatorPropelChoice(array('model' => 'Vendor', 'column' => 'code', 'required' => false)),
      'type_id' => new sfValidatorPropelChoice(array('model' => 'Type', 'column' => 'id', 'required' => false)),
      'name'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vendor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Vendor';
  }


}
