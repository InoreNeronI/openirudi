<?php use_helper('I18N', 'Date') ?>
<?php include_partial('type/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Type details', array(), 'messages') ?>:</h1>

  <?php include_partial('type/flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('type/form_header', array('type' => $type, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('type/view', array('type' => $type, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('type/form_footer', array('type' => $type, 'configuration' => $configuration)) ?>
  </div>
</div>
