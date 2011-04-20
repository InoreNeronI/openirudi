<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * MyTask filter form base class.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseMyTaskFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'day'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'hour'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'associate'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'oiimages_id' => new sfWidgetFormPropelChoice(array('model' => 'Oiimages', 'add_empty' => true)),
      'partition'   => new sfWidgetFormFilterInput(),
      'pc_id'       => new sfWidgetFormPropelChoice(array('model' => 'Pc', 'add_empty' => true)),
      'is_imageset' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'imageset_id' => new sfWidgetFormPropelChoice(array('model' => 'Imageset', 'add_empty' => true)),
      'is_boot'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'disk'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'day'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'hour'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'associate'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'oiimages_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Oiimages', 'column' => 'id')),
      'partition'   => new sfValidatorPass(array('required' => false)),
      'pc_id'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Pc', 'column' => 'id')),
      'is_imageset' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'imageset_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Imageset', 'column' => 'id')),
      'is_boot'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'disk'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('my_task_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MyTask';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'day'         => 'Date',
      'hour'        => 'Date',
      'associate'   => 'Boolean',
      'oiimages_id' => 'ForeignKey',
      'partition'   => 'Text',
      'pc_id'       => 'ForeignKey',
      'is_imageset' => 'Boolean',
      'imageset_id' => 'ForeignKey',
      'is_boot'     => 'Boolean',
      'disk'        => 'Text',
    );
  }
}
