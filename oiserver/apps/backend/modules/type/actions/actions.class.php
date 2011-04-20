<?php

require_once dirname(__FILE__).'/../lib/typeGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/typeGeneratorHelper.class.php';

/**
 * type actions.
 *
 * @package    drivers
 * @subpackage type
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class typeActions extends autoTypeActions {

    public function executeIndex(sfWebRequest $request) {
		 //kam
		/*if (DriverPeer::is_no_query($this->getFilters()))
		{
		  $this->filters = $this->configuration->getFilterForm($this->getFilters());
		  $this->setTemplate('no_query');
		}else{*/
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
				$this->redirect('@localized_type');
			}
		//}
    }

    public function executeView(sfWebRequest $request) {
        $this->type = $this->getRoute()->getObject();
        $this->forward404Unless($this->type);
    }

}
