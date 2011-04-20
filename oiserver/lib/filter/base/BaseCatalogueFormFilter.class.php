<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Catalogue filter form base class.
 *
 * @package    drivers
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 13459 2008-11-28 14:48:12Z fabien $
 */
class BaseCatalogueFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'          => new sfWidgetFormFilterInput(),
      'source_lang'   => new sfWidgetFormFilterInput(),
      'target_lang'   => new sfWidgetFormFilterInput(),
      'date_created'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'date_modified' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'author'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'          => new sfValidatorPass(array('required' => false)),
      'source_lang'   => new sfValidatorPass(array('required' => false)),
      'target_lang'   => new sfValidatorPass(array('required' => false)),
      'date_created'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'date_modified' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'author'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('catalogue_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Catalogue';
  }

  public function getFields()
  {
    return array(
      'cat_id'        => 'Number',
      'name'          => 'Text',
      'source_lang'   => 'Text',
      'target_lang'   => 'Text',
      'date_created'  => 'Date',
      'date_modified' => 'Date',
      'author'        => 'Text',
    );
  }
}
