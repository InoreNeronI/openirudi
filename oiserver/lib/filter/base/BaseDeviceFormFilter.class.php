<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Device filter form base class.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseDeviceFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'code'      => new sfWidgetFormFilterInput(),
      'vendor_id' => new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => true)),
      'type_id'   => new sfWidgetFormPropelChoice(array('model' => 'Type', 'add_empty' => true)),
      'name'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'code'      => new sfValidatorPass(array('required' => false)),
      'vendor_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Vendor', 'column' => 'code')),
      'type_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Type', 'column' => 'id')),
      'name'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('device_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Device';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'code'      => 'Text',
      'vendor_id' => 'ForeignKey',
      'type_id'   => 'ForeignKey',
      'name'      => 'Text',
    );
  }
}
