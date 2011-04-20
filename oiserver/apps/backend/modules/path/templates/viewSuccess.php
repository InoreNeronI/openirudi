<?php use_helper('I18N', 'Date') ?>
<?php include_partial('path/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Path details', array(), 'messages') ?>:</h1>

  <?php include_partial('path/flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('path/form_header', array('path' => path, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('path/view', array('path' => $path, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('path/form_footer', array('path' => path, 'configuration' => $configuration)) ?>
  </div>
</div>
