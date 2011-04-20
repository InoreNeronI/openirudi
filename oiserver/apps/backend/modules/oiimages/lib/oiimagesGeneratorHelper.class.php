<?php

/**
 * oiimages module helper.
 *
 * @package    drivers
 * @subpackage oiimages
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class oiimagesGeneratorHelper extends BaseOiimagesGeneratorHelper
{
    public function linkToView($id) {
        return '<li class="sf_admin_action_view">'.link_to(__('View', array(), 'sf_admin'), 'oiimages/view?id='.$id).'</li>';
    }
    /*public function linkToOutInsert($out_params) {
       // return '<li class="sf_admin_action_out_insert">'.link_to(__('Out insert', array(), 'messages'), '@oiimages_out_insert?out_params='.$out_params).'</li>';
       return '<li class="sf_admin_action_out_insert">'.link_to(__('Out insert', array(), 'messages'), 'oiimages?out_params='.$out_params).'</li>';
    }*/
  public function linkToEdit($object, $params)
  {
    return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), 'oiimages/edit?id='.$object->getId()).'</li>';
  }
  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }

    return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'), 'oiimages/delete?id='.$object->getId(), array('method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])).'</li>';
  }
}
