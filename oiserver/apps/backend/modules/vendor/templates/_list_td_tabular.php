<td class="sf_admin_text sf_admin_list_td_code">
  <?php echo $vendor->getCode() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_name">
  <?php echo $vendor->getName() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_type_id">
  <?php echo link_to(strtoupper($vendor->getType()), 'type/view?id='.$vendor->getTypeId()); ?>
</td>
