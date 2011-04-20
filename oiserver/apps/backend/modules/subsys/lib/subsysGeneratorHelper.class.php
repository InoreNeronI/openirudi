<?php

/**
 * subsys module helper.
 *
 * @package    drivers
 * @subpackage subsys
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class subsysGeneratorHelper extends BaseSubsysGeneratorHelper {

    public function linkToView($object, $params) {
        //kam
		//return '<li class="sf_admin_action_view">'.link_to(__($params['label'], array(), 'sf_admin'), 'subsys/view?code='.$object->getCode()).'</li>';
		return '<li class="sf_admin_action_view">'.link_to(__($params['label'], array(), 'sf_admin'), 'subsys/view?code='.$object->getCode().'&device_id='.$object->getDeviceId().'&revision='.$object->getRevision()).'</li>';
    }
	/*
	public function linkToEdit($object, $params)
    {
      return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('edit'), $object).'</li>';
    }*/

    public function linkToDelete($object, $params)
    {
      if ($object->isNew())
      {
        return '';
      }

      return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'), 'subsys/delete?code='.$object->getCode().'&device_id='.$object->getDeviceId().'&revision='.$object->getRevision(), array('method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])).'</li>';
    }
}