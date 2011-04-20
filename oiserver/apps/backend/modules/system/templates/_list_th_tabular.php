<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_name">
  <?php if ('name' == $sort[0]): ?>
    <?php echo link_to(__('Name', array(), 'messages'), '@system?sort=name&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Name', array(), 'messages'), '@system?sort=name&sort_type=asc') ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_foreignkey sf_admin_list_th_driver_id">
  <?php if ('driver_id' == $sort[0]): ?>
    <?php echo link_to(__('Driver', array(), 'messages'), '@system?sort=driver_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Driver', array(), 'messages'), '@system?sort=driver_id&sort_type=asc') ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>