<?php

/**
 * my_task module helper.
 *
 * @package    drivers
 * @subpackage my_task
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class my_taskGeneratorHelper extends BaseMy_taskGeneratorHelper
{
  public function linkToShow($object, $params)
  {
    return '<li class="sf_admin_action_show">'.link_to(__($params['label'], array(), 'sf_admin'), 'my_task/show?id='.$object->getId()).'</li>';
  }
  
  public function linkToEdit($object, $params)
  {
    return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), 'my_task/edit?id='.$object->getId()).'</li>';
  }

  public function linkToDelete($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }

    return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'), 'my_task/delete?id='.$object->getId(), array('method' => 'delete', 'confirm' => $params['confirm'])).'</li>';
  }
  public function linkToPcList()
  {
    return '<li class="sf_admin_action_list">'.link_to(__('Cancel', array(), 'sf_admin'), 'pc/index').'</li>';
  }

  public function linkToProgramSave()
  {
    return '<li class="sf_admin_action_save"><input type="submit" id="program_save" name="program_save" value="'.__('Save', array(), 'sf_admin').'" /></li>';
  }
  public function linkToAssociateSave()
  {
    return '<li class="sf_admin_action_save"><input type="submit" id="program_save" name="program_save" value="'.__('Save', array(), 'sf_admin').'" /></li>';
  }
  public function linkToClear()
  {
    return '<li class="sf_admin_action_task_clear"><input type="submit" id="task_clear" name="task_clear" value="'.__('Confirm clear', array(), 'messages').'" /></li>';
  }
  public function linkToNowSave()
  {
    return '<li class="sf_admin_action_clone_now"><input type="submit" id="clone_now" name="clone_now" value="'.__('Clone now', array(), 'messages').'" /></li>';
  }
}
