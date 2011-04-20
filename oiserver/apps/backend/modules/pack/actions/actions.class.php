<?php

require_once dirname(__FILE__).'/../lib/packGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/packGeneratorHelper.class.php';

/**
 * pack actions.
 *
 * @package    drivers
 * @subpackage pack
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class packActions extends autoPackActions {

    public function executeIndex(sfWebRequest $request) {
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
            $this->redirect('@localized_pack');
        }

    }
    
}
