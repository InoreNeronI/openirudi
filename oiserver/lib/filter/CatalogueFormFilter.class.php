<?php

/**
 * Catalogue filter form.
 *
 * @package    ulertu
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class CatalogueFormFilter extends BaseCatalogueFormFilter
{
  public function configure()
  {
	  //kam	
      $this->widgetSchema['name']          = new sfWidgetFormFilterInput(array('with_empty' => false));
      $this->widgetSchema['source_lang']   = new sfWidgetFormFilterInput(array('with_empty' => false));
      $this->widgetSchema['target_lang']   = new sfWidgetFormFilterInput(array('with_empty' => false));
      //$this->widgetSchema['date_created']  = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false));
      $this->widgetSchema['date_created']   = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')), 'to_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')),'template'  => '%from_date%&nbsp;-&nbsp;%to_date%', 'with_empty' => false));      
	  //$this->widgetSchema['date_modified'] = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false));
      $this->widgetSchema['date_modified']   = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')), 'to_date' => new sfWidgetFormDate(array('format' => '%year% / %month% / %day%')),'template'  => '%from_date%&nbsp;-&nbsp;%to_date%', 'with_empty' => false));      	  
      $this->widgetSchema['author']        = new sfWidgetFormFilterInput(array('with_empty' => false));
  	  //	
  }
}
