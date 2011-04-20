<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Driver filter form base class.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseDriverFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'type_id'    => new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => true)),
      'vendor_id'  => new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => true)),
      'device_id'  => new sfWidgetFormPropelChoice(array('model' => 'Device', 'add_empty' => true, 'key_method' => 'getCode')),
      'class_type' => new sfWidgetFormFilterInput(),
      'name'       => new sfWidgetFormFilterInput(),
      'date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'string'     => new sfWidgetFormFilterInput(),
      'url'        => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'type_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Type', 'column' => 'id')),
      'vendor_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Vendor', 'column' => 'code')),
      'device_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Device', 'column' => 'code')),
      'class_type' => new sfValidatorPass(array('required' => false)),
      'name'       => new sfValidatorPass(array('required' => false)),
      'date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'string'     => new sfValidatorPass(array('required' => false)),
      'url'        => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('driver_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Driver';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'type_id'    => 'ForeignKey',
      'vendor_id'  => 'ForeignKey',
      'device_id'  => 'ForeignKey',
      'class_type' => 'Text',
      'name'       => 'Text',
      'date'       => 'Date',
      'string'     => 'Text',
      'url'        => 'Text',
      'created_at' => 'Date',
    );
  }
}
