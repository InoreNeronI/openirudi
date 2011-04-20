<?php

/**
 * TransUnit form.
 *
 * @package    ulertu
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class TransUnitForm extends BaseTransUnitForm
{
  public function configure()
  {
		unset($this['id']);
		unset($this['comments']);
		unset($this['date_added']);
		unset($this['date_modified']);
		unset($this['translated']);
		unset($this['author']);
  }
}
