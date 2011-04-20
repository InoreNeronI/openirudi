<?php

require_once dirname(__FILE__).'/../lib/systemGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/systemGeneratorHelper.class.php';

/**
 * system actions.
 *
 * @package    drivers
 * @subpackage system
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class systemActions extends autoSystemActions {

    public function executeIndex(sfWebRequest $request) {     
         //kam
		if (DriverPeer::is_no_query($this->getFilters()))
		{
		  $this->filters = $this->configuration->getFilterForm($this->getFilters());
		  $this->setTemplate('no_query');
		}else{
			//		
			///////////////////////////////
			parent::executeIndex($request);
			///////////////////////////////
			if (!$request->getParameter('sf_culture')) {
				if ($this->getUser()->isFirstRequest()) {
					$culture = $request->getPreferredCulture(array('eu', 'es', 'en'));
					$this->getUser()->setCulture($culture);
					$this->getUser()->isFirstRequest(false);
				} else {
					$culture = $this->getUser()->getCulture();
				}
				$this->redirect('@localized_system');
			}
		}
    }

    public function executeView(sfWebRequest $request) {
        $this->system = $this->getRoute()->getObject();
        $this->forward404Unless($this->system);
    }
	//kam
    protected function addSortCriteria($criteria)
	{
		if (array(null, null) == ($sort = $this->getSort()))
		{
		  return;
		}
	
		if($sort[0]=='driver_id'){
			$column=DriverPeer::NAME;
			$criteria->addJoin(SystemPeer::DRIVER_ID,DriverPeer::ID,Criteria::LEFT_JOIN);
		}else{	
			// camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
			$column = SystemPeer::translateFieldName(sfInflector::camelize(strtolower($sort[0])), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
		}		

		if ('asc' == $sort[1])
		{
		  $criteria->addAscendingOrderByColumn($column);
		}
		else
		{
		  $criteria->addDescendingOrderByColumn($column);
		}
	}
	//kam
	protected function getPager()
    {
		$pager = $this->configuration->getPager('System');
		$pager->setCriteria($this->buildCriteria());
		$pager->setPage($this->getPage());
		/*$pager->setPeerMethod($this->configuration->getPeerMethod());
		$pager->setPeerCountMethod($this->configuration->getPeerCountMethod());*/
		$pager->setPeerMethod('doSelectCustom');
		$pager->setPeerCountMethod('doCountCustom');
		$pager->init();
	
		return $pager;
    }
}
