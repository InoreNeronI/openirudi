<?php use_helper('I18N', 'Date') ?>
<?php include_partial('device/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Device details', array(), 'messages') ?>:</h1>

  <?php include_partial('device/flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('device/form_header', array('device' => $device, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('device/view', array('device' => $device, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('device/form_footer', array('device' => $device, 'configuration' => $configuration)) ?>
  </div>
</div>
