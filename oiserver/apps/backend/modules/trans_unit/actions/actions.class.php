<?php

require_once dirname(__FILE__).'/../lib/trans_unitGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/trans_unitGeneratorHelper.class.php';

/**
 * trans_unit actions.
 *
 * @package    ulertu
 * @subpackage trans_unit
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class trans_unitActions extends autoTrans_unitActions
{ 
	protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');

      $trans_unit = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $trans_unit)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        $this->redirect('@trans_unit_new');
      }
      else
      {
		if($this->getUser()->hasCredential('trans_unit_edit')){	
        	$this->redirect('@trans_unit_edit?msg_id='.$trans_unit->getMsgId());
      	}else{
			$this->redirect('@trans_unit');
		}	
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.');
    }
  }
  protected function addSortCriteria($criteria)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

	if($sort[0]=='cat_id'){
		$column=CataloguePeer::NAME;
		$criteria->addJoin(TransUnitPeer::CAT_ID,CataloguePeer::CAT_ID);
	}

    // camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
    $column = TransUnitPeer::translateFieldName(sfInflector::camelize(strtolower($sort[0])), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
    if ('asc' == $sort[1])
    {
      $criteria->addAscendingOrderByColumn($column);
    }
    else
    {
      $criteria->addDescendingOrderByColumn($column);
    }
  }
}