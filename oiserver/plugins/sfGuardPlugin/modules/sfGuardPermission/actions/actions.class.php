<?php

require_once dirname(__FILE__).'/../lib/BasesfGuardPermissionActions.class.php';

/**
 * sfGuardPermission actions.
 *
 * @package    sfGuardPlugin
 * @subpackage sfGuardPermission
 * @author     Fabien Potencier
 * @version    SVN: $Id: actions.class.php 12965 2008-11-13 06:02:38Z fabien $
 */
class sfGuardPermissionActions extends BasesfGuardPermissionActions
{
  public function executeShow(sfWebRequest $request)
  {
    $this->sf_guard_permission = $this->getRoute()->getObject();   
  }
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');

      $sf_guard_permission = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $sf_guard_permission)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        $this->redirect('@sf_guard_permission_new');
      }
      else
      {
        if($this->getUser()->hasCredential('sf_guard_permission_edit')){
			$this->redirect('@sf_guard_permission_edit?id='.$sf_guard_permission->getId());
      	}else{
			$this->redirect('@sf_guard_permission');
		}
	  }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.');
    }
  }
}
