<?php

require_once dirname(__FILE__).'/../lib/subsysGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/subsysGeneratorHelper.class.php';

/**
 * subsys actions.
 *
 * @package    drivers
 * @subpackage subsys
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class subsysActions extends autoSubsysActions {

    public function executeIndex(sfWebRequest $request) {
		//kam
		if (DriverPeer::is_no_query($this->getFilters()))
		{
		  $this->filters = $this->configuration->getFilterForm($this->getFilters());
		  $this->setTemplate('no_query');
		}else{
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
				$this->redirect('@localized_subsys');
			}
		}
    }

    public function executeView(sfWebRequest $request) {
        $this->subsys = $this->getRoute()->getObject();
        $this->forward404Unless($this->subsys);
    }
    //kam
	protected function addSortCriteria($criteria)
	{
		if (array(null, null) == ($sort = $this->getSort()))
		{
		  return;
		}
	
		//kam
		if($sort[0]=='device_id'){
			$column=DevicePeer::NAME;
			$criteria->addJoin(SubsysPeer::DEVICE_ID,DevicePeer::ID,Criteria::LEFT_JOIN);
		}else if($sort[0]=='vendor_id'){
			$column=VendorPeer::NAME;
			$criteria->addJoin(SubsysPeer::DEVICE_ID,DevicePeer::ID,Criteria::LEFT_JOIN);
			$criteria->addJoin(DevicePeer::VENDOR_ID,VendorPeer::CODE,Criteria::LEFT_JOIN);
		}else if($sort[0]=='type_id'){
			$column=TypePeer::TYPE;
			$criteria->addJoin(SubsysPeer::DEVICE_ID,DevicePeer::ID,Criteria::LEFT_JOIN);
			$criteria->addJoin(DevicePeer::TYPE_ID,TypePeer::ID,Criteria::LEFT_JOIN);
		}else{
			// camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
			$column = SubsysPeer::translateFieldName(sfInflector::camelize(strtolower($sort[0])), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
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
	//kam
	public function executeFilter(sfWebRequest $request)
    {
    	//kam		
		if ($request->hasParameter('_reset')){
			$this->getUser()->getAttributeHolder()->remove('subsys_filters_device_id');
			$this->getUser()->getAttributeHolder()->remove('autocomplete_subsys_filters_device_id');			
		}else{
			$this->getUser()->setAttribute('subsys_filters_device_id', $request->getParameter('subsys_filters[device_id]'));
          	$this->getUser()->setAttribute('autocomplete_subsys_filters_device_id', $request->getParameter('autocomplete_subsys_filters[device_id]'));
		}  
		//
		parent::executeFilter($request);
	}	
}
