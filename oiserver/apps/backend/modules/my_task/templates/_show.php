<table>
  <tbody>
    <tr>
       <td><b><?php echo __('Id',array(),'messages');?></b>:</td>
<td class="sf_admin_text sf_admin_list_th_id">
  <?php echo link_to($my_task->getId(), 'my_task_edit', $my_task) ?>
</td>
    <tr>
       <td><b><?php echo __('Day',array(),'messages');?></b>:</td>
<td class="sf_admin_date sf_admin_list_th_day">
  <?php echo $my_task->getDay() ? format_date($my_task->getDay(), "f") : '&nbsp;' ?>
</td>
    <tr>
       <td><b><?php echo __('Hour',array(),'messages');?></b>:</td>
<td class="sf_admin_time sf_admin_list_th_hour">
  <?php //echo $my_task->getHour() ?>
  <?php echo $my_task->get_my_hour() ?>	
</td>
    <tr>
       <td><b><?php echo __('Associate',array(),'messages');?></b>:</td>
<td class="sf_admin_boolean sf_admin_list_th_associate">
  <?php echo get_partial('my_task/list_field_boolean', array('value' => $my_task->getAssociate())) ?>
</td>
    <tr>
       <td><b><?php echo __('Oiimages',array(),'messages');?></b>:</td>
<td class="sf_admin_foreignkey sf_admin_list_th_oiimages_id">
  <?php //echo $my_task->getOiimagesId() ?>
	<?php echo $my_task->getOiimages() ?>
</td>   
	 <tr>
       <td><b><?php echo __('Pc',array(),'messages');?></b>:</td>
<td class="sf_admin_foreignkey sf_admin_list_th_pc_id">
  <?php echo $my_task->getPc() ?>
</td>
 <tr>
       <td><b><?php echo __('Partition',array(),'messages');?></b>:</td>
<td class="sf_admin_text sf_admin_list_th_partition">
  <?php echo $my_task->getPartition() ?>
</td>        
</td>
<?php //gemini 2011-2-15 ?>
 <tr>
       <td><b><?php echo __('Is imageset',array(),'messages');?></b>:</td>
<td class="sf_admin_text sf_admin_list_th_partition">
  <?php echo get_partial('my_task/list_field_boolean', array('value' => $my_task->getIsImageset())) ?>
</td>
<?php //gemini 2011-2-15 ?>
 <tr>
       <td><b><?php echo __('Imageset',array(),'messages');?></b>:</td>
<td class="sf_admin_text sf_admin_list_th_partition">
  <?php echo $my_task->getImageset() ?>
</td>
<?php //gaur ?>
 <tr>
       <td><b><?php echo __('Disk',array(),'messages');?></b>:</td>
<td class="sf_admin_text sf_admin_list_th_disk">
  <?php echo $my_task->getDisk() ?>
</td>  
<?php //gemini 2011-2-15 ?>
 <tr>
       <td><b><?php echo __('Is boot',array(),'messages');?></b>:</td>
<td class="sf_admin_text sf_admin_list_th_partition">
  <?php echo get_partial('my_task/list_field_boolean', array('value' => $my_task->getIsBoot())) ?>
</td>            
  </tbody>
</table>