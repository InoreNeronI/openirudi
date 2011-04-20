<?php

/**
 * vendor module helper.
 *
 * @package    drivers
 * @subpackage vendor
 * @author     Your name here
 * @version    SVN: $Id: helper.php 12474 2008-10-31 10:41:27Z fabien $
 */
class vendorGeneratorHelper extends BaseVendorGeneratorHelper {

    public function linkToView($object, $params) {
        //return '<li class="sf_admin_action_view">'.link_to(__($params['label'], array(), 'sf_admin'), '@vendor_view?cod1='.$object->getCode().'&cod2='.$object->getTypeId()).'</li>';
    	return '<li class="sf_admin_action_view">'.link_to(__($params['label'], array(), 'sf_admin'), 'vendor/view?code='.$object->getCode().'&type_id='.$object->getTypeId()).'</li>';
	}
	public function linkToEdit($object, $params)
	{
		return '<li class="sf_admin_action_edit">'.link_to(__($params['label'], array(), 'sf_admin'), 'vendor/edit?code='.$object->getCode().'&type_id='.$object->getTypeId()).'</li>';
	}
	public function linkToDelete($object, $params)
  	{
		if ($object->isNew())
		{
		  return '';
		}

    	return '<li class="sf_admin_action_delete">'.link_to(__($params['label'], array(), 'sf_admin'), 'vendor/delete?code='.$object->getCode().'&type_id='.$object->getTypeId(), array('method' => 'delete', 'confirm' => !empty($params['confirm']) ? __($params['confirm'], array(), 'sf_admin') : $params['confirm'])).'</li>';
  	}
}
