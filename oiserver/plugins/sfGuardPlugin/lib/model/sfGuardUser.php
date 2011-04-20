<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUser.php 9999 2008-06-29 21:24:44Z fabien $
 */
class sfGuardUser extends PluginsfGuardUser
{
	//kam
	public function getIsActiveImg(){
		$cfg=sfConfig::get('sf_admin_module_web_dir').'/images/';
      	
		if($this->is_active){
           $cfg.='tick.png';
        }else{
           $cfg.='delete.png';
		}
		return $cfg;
	}
	//kam
	public function getIsSuperAdminImg(){
		$cfg=sfConfig::get('sf_admin_module_web_dir').'/images/';
      	
		if($this->is_super_admin){
           $cfg.='tick.png';
        }else{
           $cfg.='delete.png';
		}
		return $cfg;
	}	
	//kam
	public function get_group_list(){
		$cfg=array();
		$group_list=$this->getGroups();
		if(count($group_list)>0){
			foreach($group_list as $sf_guard_group){
				$cfg[]=$sf_guard_group->getName();
			}
		}		
		return $cfg;
	}
	//kam
	public function get_permission_list(){
		$cfg=array();
		$permission_list=$this->getPermissions();
		if(count($permission_list)>0){
			foreach($permission_list as $sf_permission_group){
				$cfg[]=$sf_permission_group->getName();
			}
		}		
		return $cfg;
	}
}
