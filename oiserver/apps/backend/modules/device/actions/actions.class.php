<?php

require_once dirname(__FILE__).'/../lib/deviceGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/deviceGeneratorHelper.class.php';

/**
 * device actions.
 *
 * @package    drivers
 * @subpackage device
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class deviceActions extends autoDeviceActions {

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
				$this->redirect('@localized_device');
			}
		}
    }

    public function executeView(sfWebRequest $request) {
        $this->device = $this->getRoute()->getObject();
        $this->forward404Unless($this->device);
    }
	//kam   
   protected function addSortCriteria($criteria)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

	if($sort[0]=='vendor_id'){
		$column=VendorPeer::NAME;
		$criteria->addJoin(DevicePeer::VENDOR_ID,VendorPeer::CODE,Criteria::LEFT_JOIN);
	}else if($sort[0]=='type_id'){
		$column=TypePeer::TYPE;
		$criteria->addJoin(DevicePeer::TYPE_ID,TypePeer::ID,Criteria::LEFT_JOIN);
	}else{    
		// camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
		$column = DevicePeer::translateFieldName(sfInflector::camelize(strtolower($sort[0])), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
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
	//
}
