<?php

/**
 * catalogue module helper.
 *
 * @package    ulertu
 * @subpackage catalogue
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class catalogueGeneratorHelper extends BaseCatalogueGeneratorHelper
{
  public function linkToShow($object, $params)
  {
    return '<li class="sf_admin_action_show">'.link_to(__($params['label'], array(), 'sf_admin'), 'catalogue/show?cat_id='.$object->getCatId()).'</li>';
  }
  public function linkToEdit($object, $params)
  {
    return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), 'catalogue/edit?cat_id='.$object->getCatId()).'</li>';
  }

  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }

    return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'),  'catalogue/delete?cat_id='.$object->getCatId(), array('method' => 'delete', 'confirm' => $params['confirm'])).'</li>';
  }
}
