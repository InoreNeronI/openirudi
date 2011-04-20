<?php

# FROZEN_SF_LIB_DIR: /usr/share/php/symfony

require_once dirname(__FILE__).'/../lib/symfony/autoload/sfCoreAutoload.class.php';
//require_once 'C:\wamp\php\pear\symfony/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enableAllPluginsExcept(array('sfDoctrinePlugin', 'sfCompat10Plugin')); 	
	//
	sfConfig::set('app_driver_autocomplete_array',array('vendor_id','device_id'));
	sfConfig::set('app_driver_custom_criteria_fields',array('device_driver_filters_vendor_id','device_driver_filters_type_id'));	
	sfConfig::set('app_menu_admin_bai',array('trans_unit','catalogue','sfGuardUser','sfGuardGroup','sfGuardPermission',
	'type','origin','manager','company','status','mode','priority'));
	sfConfig::set('app_device_autocomplete_array',array('vendor_id'));
	sfConfig::set('app_path_autocomplete_array',array('driver_name','vendor_id'));
	sfConfig::set('app_subsys_autocomplete_array',array('device_id'));
	sfConfig::set('app_system_autocomplete_array',array('driver_name','vendor_id'));
	sfConfig::set('app_path_custom_criteria_fields',array('driver_name','type_id','vendor_id'));		
	//
	//sfConfig::set('app_path_oiimage','c:\wamp\www\drivers/web/uploads/oiImages/');
	sfConfig::set('app_path_oiimage','/oiImages/');
    sfConfig::set('app_my_client_fields',array('server','type','ip','netmask','gateway','dns1','dns2','user','password'));
  	//gemini
	//sfConfig::set('app_imageset_colors',array('#FF0000', '#00FF00', '#0000FF', '#0066FF', '#009999 ', '#00CC33 ', '#00CCFF', '#00FF99 ', '#330033 ', '#3300FF', '#333399 ', '#336633 ', '#3366FF', '#339999 ', '#33CC33 ', '#33CCFF', '#33FF99 ', '#660033 ', '#6600FF', '#663399 ', '#666633 ', '#6666FF', '#669999 ', '#66CC33 ', '#66CCFF', '#66FF99 ', '#990033 ', '#9900FF', '#993399 ', '#996633 ', '#9966FF', '#999999 ', '#99CC33 ', '#99CCFF', '#99FF99 ', '#CC0033 ', '#CC00FF', '#CC3399 ', '#CC6633 ', '#CC66FF', '#CC9999 ', '#CCCC33 ', '#CCCCFF', '#CCFF99 ', '#FF0033 ', '#FF00FF', '#FF3399 ', '#FF6633 ', '#FF66FF', '#FF9999 ', '#FFCC33 ', '#FFCCFF', '#FFFF99 '));
  }
}
