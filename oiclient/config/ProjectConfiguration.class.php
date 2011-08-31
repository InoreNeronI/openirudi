<?php

# FROZEN_SF_LIB_DIR: /usr/share/php/symfony


require_once '/var/www/openirudi/data/symfony/autoload/sfCoreAutoload.class.php';

sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
  }
}
