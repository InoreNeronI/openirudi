<?php

require_once dirname(__FILE__).'/../lib/BasesfGuardGroupActions.class.php';

/**
 * sfGuardGroup actions.
 *
 * @package    sfGuardPlugin
 * @subpackage sfGuardGroup
 * @author     Fabien Potencier
 * @version    SVN: $Id: actions.class.php 12965 2008-11-13 06:02:38Z fabien $
 */
class sfGuardGroupActions extends BasesfGuardGroupActions
{
  public function executeShow(sfWebRequest $request)
  {
    $this->sf_guard_group = $this->getRoute()->getObject();    
  }	
   protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');

      $sf_guard_group = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $sf_guard_group)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        $this->redirect('@sf_guard_group_new');
      }
      else
      {
        //kam
		//$this->redirect('@sf_guard_group_edit?id='.$sf_guard_group->getId());
      	if($this->getUser()->hasCredential('sf_guard_group_edit')){
			$this->redirect('@sf_guard_group_edit?id='.$sf_guard_group->getId());
		}else{
			$this->redirect('@sf_guard_group');
		}
		//
	  }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.');
    }
  }
}
