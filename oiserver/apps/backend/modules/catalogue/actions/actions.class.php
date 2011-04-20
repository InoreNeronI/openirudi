<?php

require_once dirname(__FILE__).'/../lib/catalogueGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/catalogueGeneratorHelper.class.php';

/**
 * catalogue actions.
 *
 * @package    ulertu
 * @subpackage catalogue
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class catalogueActions extends autoCatalogueActions
{
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');

      $catalogue = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $catalogue)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        $this->redirect('@catalogue_new');
      }
      else
      {
        if($this->getUser()->hasCredential()){
			$this->redirect('@catalogue_edit?cat_id='.$catalogue->getCatId());
      	}else{
			$this->redirect('@catalogue');
		}	
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.');
    }
  }
}
