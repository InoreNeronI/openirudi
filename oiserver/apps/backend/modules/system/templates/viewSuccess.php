<?php use_helper('I18N', 'Date') ?>
<?php include_partial('system/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('System details', array(), 'messages') ?>:</h1>

  <?php include_partial('system/flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('system/form_header', array('system' => $system, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('system/view', array('system' => $system, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('system/form_footer', array('system' => $system, 'configuration' => $configuration)) ?>
  </div>
</div>
