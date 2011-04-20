<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Oiimages filter form base class.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseOiimagesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ref'             => new sfWidgetFormFilterInput(),
      'name'            => new sfWidgetFormFilterInput(),
      'description'     => new sfWidgetFormFilterInput(),
      'os'              => new sfWidgetFormFilterInput(),
      'uuid'            => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'partition_size'  => new sfWidgetFormFilterInput(),
      'partition_type'  => new sfWidgetFormFilterInput(),
      'filesystem_size' => new sfWidgetFormFilterInput(),
      'filesystem_type' => new sfWidgetFormFilterInput(),
      'path'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'ref'             => new sfValidatorPass(array('required' => false)),
      'name'            => new sfValidatorPass(array('required' => false)),
      'description'     => new sfValidatorPass(array('required' => false)),
      'os'              => new sfValidatorPass(array('required' => false)),
      'uuid'            => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'partition_size'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'partition_type'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'filesystem_size' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'filesystem_type' => new sfValidatorPass(array('required' => false)),
      'path'            => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('oiimages_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Oiimages';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'ref'             => 'Text',
      'name'            => 'Text',
      'description'     => 'Text',
      'os'              => 'Text',
      'uuid'            => 'Text',
      'created_at'      => 'Date',
      'partition_size'  => 'Number',
      'partition_type'  => 'Number',
      'filesystem_size' => 'Number',
      'filesystem_type' => 'Text',
      'path'            => 'Text',
    );
  }
}
