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
 * @version    SVN: $Id: sfGuardGroup.php 9999 2008-06-29 21:24:44Z fabien $
 */
class sfGuardGroup extends PluginsfGuardGroup
{
	//kam
	public function get_permission_list(){
		$cfg=array();
		$permission_list=$this->getsfGuardGroupPermissionsJoinsfGuardPermission();		
		if(count($permission_list)>0){
			foreach($permission_list as $sf_permission_group){				
				$permission=$sf_permission_group->getsfGuardPermission();
				if(!empty($permission)){
					$cfg[]=$permission->getName();
				}		
			}
		}		
		return $cfg;
	}
}
