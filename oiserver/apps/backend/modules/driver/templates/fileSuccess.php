<?php use_helper('I18N', 'Date') ?>
<?php include_partial('driver/assets') ?>

<div id="sf_admin_container"><?php
  echo '<h1>'.pathinfo($file, PATHINFO_BASENAME).'</h1>'; ?>

  <?php include_partial('driver/flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('driver/form_header', array('driver' => $driver, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content"><?php
    $content = explode("\n", file_get_contents($file));
    foreach ($content as $line) echo $line.'<br />'; ?>
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('driver/form_footer', array('driver' => $driver, 'configuration' => $configuration)) ?>
  </div>
</div>
