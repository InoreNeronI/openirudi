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
 * @version    SVN: $Id: sfGuardPermission.php 9999 2008-06-29 21:24:44Z fabien $
 */
class sfGuardPermission extends PluginsfGuardPermission
{
	//kam
	public function get_group_list(){
		$cfg=array();
		$group_list=$this->getsfGuardGroupPermissionsJoinsfGuardGroup();		
		if(count($group_list)>0){
			foreach($group_list as $sf_permission_group){				
				$group=$sf_permission_group->getsfGuardGroup();
				if(!empty($group)){
					$cfg[]=$group->getName();
				}		
			}
		}
		return $cfg;
	}
}
