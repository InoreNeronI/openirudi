<?php use_helper('I18N', 'Date') ?>
<?php include_partial('oiimages/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Oiimages details', array(), 'messages') ?></h1>

  <?php include_partial('oiimages/flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('oiimages/form_header', array('oiimages' => $oiimages, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('oiimages/view', array('oiimages' => $oiimages)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('oiimages/form_footer', array('oiimages' => $oiimages, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
