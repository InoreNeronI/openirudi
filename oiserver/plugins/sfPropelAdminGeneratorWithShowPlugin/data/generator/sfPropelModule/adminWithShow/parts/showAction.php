  public function executeShow(sfWebRequest $request)
  {
    $this-><?php echo $this->getSingularName() ?> = <?php echo constant($this->getModelClass().'::PEER') ?>::retrieveByPk(<?php echo $this->getRetrieveByPkParamsForAction(49) ?>);
    $this->forward404Unless($this-><?php echo $this->getSingularName() ?>);
  }
