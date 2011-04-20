<?php

/**
 * TransUnit filter form.
 *
 * @package    ulertu
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class TransUnitFormFilter extends BaseTransUnitFormFilter
{
  public function configure()
  {
	  //kam
	  unset($this['id']);
	  $this->widgetSchema['cat_id']        = new sfWidgetFormPropelChoice(array('model' => 'Catalogue', 'add_empty' => true));
      $this->widgetSchema['source']        = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['target']        = new sfWidgetFormFilterInput(array('with_empty'=>false));
      $this->widgetSchema['comments']      = new sfWidgetFormFilterInput(array('with_empty'=>false));
      //$this->widgetSchema['date_added']    = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false));
      $this->widgetSchema['date_added']   = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')), 'to_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')),'template'  => '%from_date%&nbsp;-&nbsp;%to_date%', 'with_empty' => false));
      //$this->widgetSchema['date_modified'] = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false));
      $this->widgetSchema['date_modified']   = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')), 'to_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')),'template'  => '%from_date%&nbsp;-&nbsp;%to_date%', 'with_empty' => false));      
	  $this->widgetSchema['author']        = new sfWidgetFormFilterInput(array('with_empty'=>false));
      //
  }
}
