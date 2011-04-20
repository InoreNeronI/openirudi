<?php

/**
 * trans_unit module helper.
 *
 * @package    ulertu
 * @subpackage trans_unit
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class trans_unitGeneratorHelper extends BaseTrans_unitGeneratorHelper
{
  public function linkToShow($object, $params)
  {
    return '<li class="sf_admin_action_show">'.link_to(__($params['label'], array(), 'sf_admin'), 'trans_unit/show?msg_id='.$object->getMsgId()).'</li>';
  }
  
  public function linkToEdit($object, $params)
  {
    return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), 'trans_unit/edit?msg_id='.$object->getMsgId()).'</li>';
  }

  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }

    return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'), 'trans_unit/delete?msg_id='.$object->getMsgId(), array('method' => 'delete', 'confirm' => $params['confirm'])).'</li>';
  }
}
