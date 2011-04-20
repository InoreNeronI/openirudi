<?php

/**
 * Catalogue form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseCatalogueForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'cat_id'        => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInput(),
      'source_lang'   => new sfWidgetFormInput(),
      'target_lang'   => new sfWidgetFormInput(),
      'date_created'  => new sfWidgetFormDateTime(),
      'date_modified' => new sfWidgetFormDateTime(),
      'author'        => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'cat_id'        => new sfValidatorPropelChoice(array('model' => 'Catalogue', 'column' => 'cat_id', 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 100)),
      'source_lang'   => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'target_lang'   => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'date_created'  => new sfValidatorDateTime(array('required' => false)),
      'date_modified' => new sfValidatorDateTime(array('required' => false)),
      'author'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('catalogue[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Catalogue';
  }


}
