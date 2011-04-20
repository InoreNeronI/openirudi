<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * AsignImageset filter form base class.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseAsignImagesetFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(),
      'imageset_id' => new sfWidgetFormPropelChoice(array('model' => 'Imageset', 'add_empty' => true)),
      'oiimages_id' => new sfWidgetFormPropelChoice(array('model' => 'Oiimages', 'add_empty' => true)),
      'size'        => new sfWidgetFormFilterInput(),
      'position'    => new sfWidgetFormFilterInput(),
      'color'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'imageset_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Imageset', 'column' => 'id')),
      'oiimages_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Oiimages', 'column' => 'id')),
      'size'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'position'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'color'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('asign_imageset_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AsignImageset';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'imageset_id' => 'ForeignKey',
      'oiimages_id' => 'ForeignKey',
      'size'        => 'Number',
      'position'    => 'Number',
      'color'       => 'Text',
    );
  }
}
