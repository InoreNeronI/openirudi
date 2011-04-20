<td class="sf_admin_text sf_admin_list_th_id">
  <?php //echo link_to($my_task->getId(), 'my_task_edit', $my_task) ?>
  <?php echo $my_task->getId();?>
</td>
<td class="sf_admin_date sf_admin_list_th_day">
  <?php //echo $my_task->getDay() ? format_date($my_task->getDay(), "f") : '&nbsp;' ?>
  <?php echo $my_task->getDay() ? $my_task->getDayCustom() : '&nbsp;' ?>
</td>
<td class="sf_admin_time sf_admin_list_th_hour">
  <?php //echo $my_task->getHour() ?>
  <?php echo $my_task->get_my_hour() ?>
</td>
<td class="sf_admin_boolean sf_admin_list_th_associate">
  <?php echo get_partial('my_task/list_field_boolean', array('value' => $my_task->getAssociate())) ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_th_oiimages_id">
  <?php //echo $my_task->getOiimagesId() ?>
  <?php echo $my_task->getOiimages() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_th_pc_id">
  <?php //echo $my_task->getPcId() ?>
  <?php echo $my_task->getPc() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_partition">
  <?php echo $my_task->getPartition() ?>
</td>
<?php //gemini 2011-02-15 ?>
<td class="sf_admin_text sf_admin_list_th_partition">
  <?php echo $my_task->getImageset() ?>
</td>
<?php //gaur ?>
<td class="sf_admin_text sf_admin_list_th_partition">
  <?php echo $my_task->getDisk() ?>
</td>
<?php //gemini 2011-02-15 ?>
<td class="sf_admin_boolean sf_admin_list_th_is_boot">
  <?php echo get_partial('my_task/list_field_boolean', array('value' => $my_task->getIsBoot())) ?>
</td>
