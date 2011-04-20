<?php

/**
 * Catalogue form.
 *
 * @package    ulertu
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CatalogueForm extends BaseCatalogueForm
{
  public function configure()
  {
		unset($this['date_created']);
		unset($this['date_modified']);
  		unset($this['author']);
  }
}
