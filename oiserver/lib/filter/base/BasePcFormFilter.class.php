<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Pc filter form base class.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BasePcFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'mac'        => new sfWidgetFormFilterInput(),
      'hddid'      => new sfWidgetFormFilterInput(),
      'name'       => new sfWidgetFormFilterInput(),
      'ip'         => new sfWidgetFormFilterInput(),
      'netmask'    => new sfWidgetFormFilterInput(),
      'gateway'    => new sfWidgetFormFilterInput(),
      'dns'        => new sfWidgetFormFilterInput(),
      'pcgroup_id' => new sfWidgetFormPropelChoice(array('model' => 'Pcgroup', 'add_empty' => true)),
      'partitions' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mac'        => new sfValidatorPass(array('required' => false)),
      'hddid'      => new sfValidatorPass(array('required' => false)),
      'name'       => new sfValidatorPass(array('required' => false)),
      'ip'         => new sfValidatorPass(array('required' => false)),
      'netmask'    => new sfValidatorPass(array('required' => false)),
      'gateway'    => new sfValidatorPass(array('required' => false)),
      'dns'        => new sfValidatorPass(array('required' => false)),
      'pcgroup_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Pcgroup', 'column' => 'id')),
      'partitions' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pc_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pc';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'mac'        => 'Text',
      'hddid'      => 'Text',
      'name'       => 'Text',
      'ip'         => 'Text',
      'netmask'    => 'Text',
      'gateway'    => 'Text',
      'dns'        => 'Text',
      'pcgroup_id' => 'ForeignKey',
      'partitions' => 'Text',
    );
  }
}
