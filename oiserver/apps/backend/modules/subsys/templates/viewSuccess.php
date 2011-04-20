<?php use_helper('I18N', 'Date') ?>
<?php include_partial('subsys/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Subsys details', array(), 'messages') ?>:</h1>

  <?php include_partial('subsys/flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('subsys/form_header', array('subsys' => $subsys, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('subsys/view', array('subsys' => $subsys, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('subsys/form_footer', array('subsys' => $subsys, 'configuration' => $configuration)) ?>
  </div>
</div>
