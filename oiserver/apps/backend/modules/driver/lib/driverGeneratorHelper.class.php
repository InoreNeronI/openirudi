<?php

/**
 * driver module helper.
 *
 * @package    drivers
 * @subpackage driver
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class driverGeneratorHelper extends BaseDriverGeneratorHelper {

    public function linkToView($object, $params) {
        return '<li class="sf_admin_action_view">'.link_to(__($params['label'], array(), 'sf_admin'), 'driver/view?id='.$object->getId()).'</li>';
    }

    public function linkToFile($object, $params) {
        return '<li class="sf_admin_action_view">'.link_to(__($params['label'], array(), 'sf_admin'), 'driver/file?id='.$object->getId().'&file='.$params['file']).'</li>';
    }

    public function linkToFolder($object, $params) {
        return '<li class="sf_admin_action_view">'.link_to(__($params['label'], array(), 'sf_admin'), 'driver/folder?id='.$object->getId().'&folder='.$params['folder']).'</li>';
    }

    public function linkToZip($object_id, $params) {
        return '<li class="sf_admin_action_view">'.link_to(__($params['label'], array(), 'sf_admin'), 'driver/zip?id='.$object_id).'</li>';
    }
	//kam    
	public function linkToEdit($object, $params)
    {
    	return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), 'driver/edit?id='.$object->getId()).'</li>';
    }	
	//kam   
    public function linkToDelete($object, $params)
    {
		if ($object->isNew())
		{
		  return '';
		}

    	return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'),'driver/delete?id='.$object->getId() , array('method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])).'</li>';
    }
}