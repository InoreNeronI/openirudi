<?php use_helper('I18N', 'Date') ?>
<?php include_partial('imageset/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Edit Imageset', array(), 'messages') ?></h1>

  <?php include_partial('imageset/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('imageset/form_header', array('imageset' => $imageset, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('imageset/form', array('imageset' => $imageset, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper,'mm'=>$mm,'pp'=>$pp,'size'=>$size)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('imageset/form_footer', array('imageset' => $imageset, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
