<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/../lib/BasesfGuardAuthActions.class.php');

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: actions.class.php 9999 2008-06-29 21:24:44Z fabien $
 */
class sfGuardAuthActions extends BasesfGuardAuthActions
{
	public function executeSignout($request)
  {
    $this->getUser()->signOut();

    $signoutUrl = sfConfig::get('app_sf_guard_plugin_success_signout_url', $request->getReferer());

	//kam
    //$this->redirect('' != $signoutUrl ? $signoutUrl : '@homepage');
  	//OHARRA::::bestela goikoarekin errorea ematen du, baino horrela primeran doa
    $this->redirect('@homepage');
  }
}
