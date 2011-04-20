<?php use_helper('I18N', 'Date') ?>
<?php include_partial('vendor/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Vendor details', array(), 'messages') ?>:</h1>

  <?php include_partial('vendor/flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('vendor/form_header', array('vendor' => $vendor, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('vendor/view', array('vendor' => $vendor, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('vendor/form_footer', array('vendor' => $vendor, 'configuration' => $configuration)) ?>
  </div>
</div>
