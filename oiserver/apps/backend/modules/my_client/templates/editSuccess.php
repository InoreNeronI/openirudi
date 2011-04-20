<?php use_helper('I18N', 'Date') ?>
<?php include_partial('global/assets') ?>
<?php include_partial('my_client/edit_js',array('my_client'=>$my_client))?>



<div id="sf_admin_container">

  <h1><?php echo __('Edit Client', array(), 'messages') ?></h1>
  <?php if($my_error['error']):?>
  <div class="error"><?php echo __('The item has not been saved due to some errors.',array(),'sf_admin');?></div>
  <?php endif;?>
  <?php include_partial('update_client') ?>
  <?php include_partial('edit', array('my_client'=>$my_client,'server_list'=>$server_list,'my_error'=>$my_error)) ?>
 

  <?php include_partial('edit_actions') ?>

</div>