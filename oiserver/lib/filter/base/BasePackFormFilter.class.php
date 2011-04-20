<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Pack filter form base class.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BasePackFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'path_id'      => new sfWidgetFormPropelChoice(array('model' => 'Path', 'add_empty' => true)),
      'name'         => new sfWidgetFormFilterInput(),
      'version'      => new sfWidgetFormFilterInput(),
      'release_date' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'path_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Path', 'column' => 'id')),
      'name'         => new sfValidatorPass(array('required' => false)),
      'version'      => new sfValidatorPass(array('required' => false)),
      'release_date' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('pack_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pack';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'path_id'      => 'ForeignKey',
      'name'         => 'Text',
      'version'      => 'Text',
      'release_date' => 'Date',
    );
  }
}
