<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * TransUnit filter form base class.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseTransUnitFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'cat_id'        => new sfWidgetFormPropelChoice(array('model' => 'Catalogue', 'add_empty' => true)),
      'id'            => new sfWidgetFormFilterInput(),
      'source'        => new sfWidgetFormFilterInput(),
      'target'        => new sfWidgetFormFilterInput(),
      'comments'      => new sfWidgetFormFilterInput(),
      'date_added'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'date_modified' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'author'        => new sfWidgetFormFilterInput(),
      'translated'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'cat_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Catalogue', 'column' => 'cat_id')),
      'id'            => new sfValidatorPass(array('required' => false)),
      'source'        => new sfValidatorPass(array('required' => false)),
      'target'        => new sfValidatorPass(array('required' => false)),
      'comments'      => new sfValidatorPass(array('required' => false)),
      'date_added'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'date_modified' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'author'        => new sfValidatorPass(array('required' => false)),
      'translated'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('trans_unit_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'TransUnit';
  }

  public function getFields()
  {
    return array(
      'msg_id'        => 'Number',
      'cat_id'        => 'ForeignKey',
      'id'            => 'Text',
      'source'        => 'Text',
      'target'        => 'Text',
      'comments'      => 'Text',
      'date_added'    => 'Date',
      'date_modified' => 'Date',
      'author'        => 'Text',
      'translated'    => 'Boolean',
    );
  }
}
