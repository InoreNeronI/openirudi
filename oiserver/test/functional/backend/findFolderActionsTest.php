<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

// create a new test browser
$browser = new sfTestBrowser();

$browser->
  get('/findFolder/index')->
  isStatusCode(200)->
  isRequestParameter('module', 'findFolder')->
  isRequestParameter('action', 'index')->
  checkResponseElement('body', '!/This is a temporary page/');
