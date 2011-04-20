<?php

require_once dirname(__FILE__).'/../lib/vendorGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/vendorGeneratorHelper.class.php';

/**
 * vendor actions.
 *
 * @package    drivers
 * @subpackage vendor
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class vendorActions extends autoVendorActions {

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
				$this->redirect('@localized_vendor');
			}
		}
    }

    public function executeView(sfWebRequest $request) {
        /*$code = $request->getParameter('cod1');
        $type_id = $request->getParameter('cod2');
        $this->vendor = VendorPeer::retrieveByPK($code, $type_id);*/
		$this->vendor = $this->getRoute()->getObject();
        $this->forward404Unless($this->vendor);
    }

  // Acción de insertar/actualizar datos de dispositivos USB desde:  http://www.linux-usb.org/usb.ids
    public function executeReadUsbIds() {
        $this->usb_hook = Vendor::readUsbIds();
    }
    
  // Acción de insertar/actualizar datos de dispositivos PCI desde:
  // http://www.pcidatabase.com/reports.php?type=tab-delimeted, y desde: http://pciids.sourceforge.net/v2.2/pci.ids
    public function executeReadPciIds() {
        $this->pci_hook = Vendor::readPciIds();
    }

      public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@vendor');
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());

    $this->filters->bind($request->getParameter($this->filters->getName()));
//    echo 'lo: '.print_r($request->getParameter('vendor_filters'),1);
//    exit;
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());

      $this->redirect('@vendor');
    }
    
    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    $this->setTemplate('index');

  }
  //kam
  protected function addSortCriteria($criteria)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

	if($sort[0]=='type_id'){
		$column =TypePeer::TYPE;
		$criteria->addJoin(VendorPeer::TYPE_ID,TypePeer::ID);
	}else{
		// camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
		$column = VendorPeer::translateFieldName(sfInflector::camelize(strtolower($sort[0])), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
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
