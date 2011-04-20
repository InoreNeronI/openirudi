<?php slot('sf_admin.current_header') ?>
<th class="sf_admin_text sf_admin_list_th_path">
  <?php if ('path' == $sort[0]): ?>
    <?php echo link_to(__('Path', array(), 'messages'), '@path?sort=path&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Path', array(), 'messages'), '@path?sort=path&sort_type=asc') ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="sf_admin_foreignkey sf_admin_list_th_driver_id">
  <?php if ('driver_id' == $sort[0]): ?>
    <?php echo link_to(__('Driver', array(), 'messages'), '@path?sort=driver_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Driver', array(), 'messages'), '@path?sort=driver_id&sort_type=asc') ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php //slot('sf_admin.current_header') ?>
<!--
<th class="sf_admin_foreignkey sf_admin_list_th_type_id">
-->
  <?php /*if ('type_id' == $sort[0]): ?>
    <?php echo link_to(__('Type', array(), 'messages'), '@path?sort=type_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Type', array(), 'messages'), '@path?sort=type_id&sort_type=asc') ?>
  <?php endif;*/ ?>
<!--
</th>
-->
<?php /*end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header')*/ ?>
<!--
<th class="sf_admin_foreignkey sf_admin_list_th_vendor_id">
-->
  <?php /*if ('vendor_id' == $sort[0]): ?>
    <?php echo link_to(__('Vendor', array(), 'messages'), '@path?sort=vendor_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc')) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Vendor', array(), 'messages'), '@path?sort=vendor_id&sort_type=asc') ?>
  <?php endif;*/ ?>
<!--
</th>
-->
<?php /*end_slot(); ?>
<?php include_slot('sf_admin.current_header')*/ ?>