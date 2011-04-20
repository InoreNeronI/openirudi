<?php use_helper('I18N', 'Date') ?>
<?php include_partial('my_task/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Show My task', array(), 'messages') ?></h1>

  <?php //include_partial('show', array('my_task' => $my_task,'pc_list_html'=>$pc_list_html)) ?>
  <?php include_partial('show', array('my_task' => $my_task)) ?>

  <?php include_partial('show_actions', array('my_task' => $my_task, 'configuration' => $configuration, 'helper' => $helper)) ?>

</div>