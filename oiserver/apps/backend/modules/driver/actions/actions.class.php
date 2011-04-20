<?php

require_once dirname(__FILE__).'/../lib/driverGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/driverGeneratorHelper.class.php';

/**
 * driver actions.
 *
 * @package    drivers
 * @subpackage driver
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class driverActions extends autoDriverActions {

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
				$this->redirect('@localized_driver');
			}
		}
    }

	
    
    public function executeReadInfs() {

    }

    public function executeLoading() {

    }

    public function executeOperate(sfWebRequest $request) {
        $this->getResponse()->setContentType('application/json');
        $result = array('text' => ParseINF::operate(sfConfig::get('app_const_packs_root')));
        return $this->renderText(json_encode($result));
    }
    
    public function executeFilesParsed(sfWebRequest $request) {
        
    }

    //public function executeSearch() {
    public function executeSearch(sfWebRequest $request) {
        //kam
        $params=$this->get_params_search($request);
        //
        $this->result = DriverPeer::searchDriver($params);
        if ($this->result !== false)    Driver::returnSearch($this->result);
        return sfView::NONE;
    }

    public function executeView(sfWebRequest $request) {
        //$this->driver = $this->getRoute()->getObject();
        $this->driver =DriverPeer::retrieveByPk($request->getParameter('id'));
		$this->forward404Unless($this->driver);
    }

    public function executeFile(sfWebRequest $request) {
        //$this->driver = $this->getUrl();
        //$this->forward404Unless($url);
        $this->file = $request->getParameter('file');
        $this->forward404Unless($this->file);
    }

    public function executeFolder(sfWebRequest $request) {
        $this->driver = $this->getRoute()->getObject();
        $this->folder = $request->getParameter('folder');
        $this->forward404Unless($this->folder);
    }

    public function executeZip(sfWebRequest $request) {
        $this->driver = $this->getRoute()->getObject();
        return Driver::returnSearch($this->driver);
    }
    private function get_params_search(sfWebRequest $request){
        //return
        //type=$type&vid=$vendor&pid=$device&subsys=$subsys&rev=$rev
        $cfg='?';        
        $args=array('type','vid','pid','subsys','rev');
        $kont=0;
        foreach($args as $i=>$name){
            if($request->hasParameter($name)){
                if($kont>0){
                    $cfg.='&';
                }
                $cfg.=$name.'='.$request->getParameter($name);
                $kont++;
            }
        }
        return $cfg;
    }    
   //kam
   protected function buildCriteria()
  {
    if (is_null($this->filters))
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
    }

    //kam
    $filters=$this->getFilters();
    if(isset($filters['vendor_id']) && !empty($filters['vendor_id'])){
        $filters=$this->fix_vendor_id($filters);
    }
    //

    $criteria = $this->filters->buildCriteria($filters);

    

    $this->addSortCriteria($criteria);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_criteria'), $criteria);
    $criteria = $event->getReturnValue();

    return $criteria;
  }
  private function fix_vendor_id($filters){
    $cfg=$filters;

    $vendor_id_array=explode('-',$cfg['vendor_id']);

    $cfg['vendor_id']=$vendor_id_array[0];
    //$cfg['type_id']=$vendor_id_array[1];

    return $cfg;
  }
	//kam
	protected function addSortCriteria($criteria)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

	//kam
	if($sort[0]=='type_id'){
		$column=TypePeer::TYPE;
		$criteria->addJoin(DriverPeer::TYPE_ID,TypePeer::ID,Criteria::LEFT_JOIN);		
	}else if($sort[0]=='vendor_id'){
		$column=VendorPeer::NAME;
		$criteria->addJoin(DriverPeer::VENDOR_ID,VendorPeer::CODE,Criteria::LEFT_JOIN);		
	}else if($sort[0]=='device_id'){
		$column=DevicePeer::NAME;
		$criteria->addJoin(DriverPeer::DEVICE_ID,devicePeer::CODE,Criteria::LEFT_JOIN);		
	}else{
    	// camelize lower case to be able to compare with BasePeer::TYPE_PHPNAME translate field name
    	$column = DriverPeer::translateFieldName(sfInflector::camelize(strtolower($sort[0])), BasePeer::TYPE_PHPNAME, BasePeer::TYPE_COLNAME);
    }
	//

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
		//OHARRA::::autoocomplete ta device aurrizki bezela jarri ez gero filter balidazioan ez da ezer egin beharrik, filterraren parte driver_filters aurrizkia dutenak harzten baitira	
    	//OHARRA::::device_id bat aukeratzean, code,vendor_id ta type_id arabera begiratu behar da
		if ($request->hasParameter('_reset')){
			$this->getUser()->getAttributeHolder()->remove('driver_filters_device_id');
			$this->getUser()->getAttributeHolder()->remove('autocomplete_driver_filters_device_id');
			$this->getUser()->getAttributeHolder()->remove('device_driver_filters_vendor_id');
			$this->getUser()->getAttributeHolder()->remove('device_driver_filters_type_id');
		}else{
			$this->getUser()->setAttribute('driver_filters_device_id', $request->getParameter('driver_filters[device_id]'));
          	$this->getUser()->setAttribute('autocomplete_driver_filters_device_id', $request->getParameter('autocomplete_driver_filters[device_id]'));
			$this->getUser()->setAttribute('device_driver_filters_vendor_id', $request->getParameter('device_driver_filters[vendor_id]'));
			$this->getUser()->setAttribute('device_driver_filters_type_id', $request->getParameter('device_driver_filters[type_id]'));  
		}  
		//
		parent::executeFilter($request);
	}
	//kam
	protected function getPager()
    {
		$pager = $this->configuration->getPager('Driver');
		$pager->setCriteria($this->buildCriteria());
		$pager->setPage($this->getPage());
		//kam
		/*$pager->setPeerMethod($this->configuration->getPeerMethod());
		$pager->setPeerCountMethod($this->configuration->getPeerCountMethod());*/
		//OHARRA::::device_id bat aukeratzean, code,vendor_id ta type_id arabera begiratu behar da
		$pager->setPeerMethod('doSelectCustom');
		$pager->setPeerCountMethod('doCountCustom');
		//
		$pager->init();

    	return $pager;
    }
}
