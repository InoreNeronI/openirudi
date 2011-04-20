<?php

/**
 * TransUnit form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseTransUnitForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'msg_id'        => new sfWidgetFormInputHidden(),
      'cat_id'        => new sfWidgetFormPropelChoice(array('model' => 'Catalogue', 'add_empty' => false)),
      'id'            => new sfWidgetFormInput(),
      'source'        => new sfWidgetFormTextarea(),
      'target'        => new sfWidgetFormTextarea(),
      'comments'      => new sfWidgetFormTextarea(),
      'date_added'    => new sfWidgetFormDateTime(),
      'date_modified' => new sfWidgetFormDateTime(),
      'author'        => new sfWidgetFormInput(),
      'translated'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'msg_id'        => new sfValidatorPropelChoice(array('model' => 'TransUnit', 'column' => 'msg_id', 'required' => false)),
      'cat_id'        => new sfValidatorPropelChoice(array('model' => 'Catalogue', 'column' => 'cat_id')),
      'id'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'source'        => new sfValidatorString(),
      'target'        => new sfValidatorString(array('required' => false)),
      'comments'      => new sfValidatorString(array('required' => false)),
      'date_added'    => new sfValidatorDateTime(array('required' => false)),
      'date_modified' => new sfValidatorDateTime(array('required' => false)),
      'author'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'translated'    => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('trans_unit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TransUnit';
  }


}
