<table>
  <tbody>
    <tr>
       <td><b><?php echo __('Id',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_id">
  <?php //echo link_to($pcgroup->getId(), 'pcgroup_edit', $pcgroup) ?>
  <?php echo $pcgroup->getId();?>
</td>
    <tr>
       <td><b><?php echo __('Name',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_name">
  <?php echo $pcgroup->getName() ?>
</td>
    </tr>
  </tbody>
</table>
