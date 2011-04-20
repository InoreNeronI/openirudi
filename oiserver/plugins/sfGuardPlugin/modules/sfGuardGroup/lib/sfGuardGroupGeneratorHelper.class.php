<?php

/**
 * sfGuardGroup module helper.
 *
 * @package    sfGuardPlugin
 * @subpackage sfGuardGroup
 * @author     Fabien Potencier
 * @version    SVN: $Id: sfGuardGroupGeneratorHelper.class.php 12896 2008-11-10 19:02:34Z fabien $
 */
class sfGuardGroupGeneratorHelper extends BaseSfGuardGroupGeneratorHelper
{
  public function linkToShow($id)
  {
    return '<li class="sf_admin_action_show">'.link_to(__('Show', array(), 'messages'),'sfGuardGroup/show?id='.$id).'</li>';
  }
  public function linkToEdit($object, $params)
  {
    return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), 'sfGuardGroup/edit?id='.$object->getId()).'</li>';
  }

  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }

    return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'),'sfGuardGroup/delete?id='.$object->getId(), array('method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])).'</li>';
  }
}
