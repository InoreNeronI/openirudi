<?php use_helper('I18N', 'Date') ?>
<?php include_partial('driver/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Driver details', array(), 'messages') ?>:</h1>

  <?php include_partial('driver/flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('driver/form_header', array('driver' => $driver, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('driver/view', array('driver' => $driver, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('driver/form_footer', array('driver' => $driver, 'configuration' => $configuration)) ?>
  </div>
</div>
