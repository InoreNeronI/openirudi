<?php

/**
 * Device form.
 *
 * @package    drivers
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class DeviceForm extends BaseDeviceForm {
    
    public function configure() {

        $this->setWidget('vendor_id', new sfWidgetFormPropelChoice(array('model' => 'Vendor', 'add_empty' => false, 'key_method' => 'getPrimaryKeys')));
        //kam
		$this->validatorSchema['vendor_id'] = new sfValidatorChoice(array('choices'=>VendorPeer::get_choices_primary_compose()));
		//
    }
}
