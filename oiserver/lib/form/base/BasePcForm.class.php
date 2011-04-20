<?php

/**
 * Pc form base class.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BasePcForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'mac'        => new sfWidgetFormInput(),
      'hddid'      => new sfWidgetFormInput(),
      'name'       => new sfWidgetFormInput(),
      'ip'         => new sfWidgetFormInput(),
      'netmask'    => new sfWidgetFormInput(),
      'gateway'    => new sfWidgetFormInput(),
      'dns'        => new sfWidgetFormInput(),
      'pcgroup_id' => new sfWidgetFormPropelChoice(array('model' => 'Pcgroup', 'add_empty' => true)),
      'partitions' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'Pc', 'column' => 'id', 'required' => false)),
      'mac'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'hddid'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 255)),
      'ip'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'netmask'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'gateway'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'dns'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'pcgroup_id' => new sfValidatorPropelChoice(array('model' => 'Pcgroup', 'column' => 'id', 'required' => false)),
      'partitions' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pc';
  }


}
