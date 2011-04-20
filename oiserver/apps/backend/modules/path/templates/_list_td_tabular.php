<td class="sf_admin_text sf_admin_list_td_path">
  <?php echo $path->getPath() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_driver_id">
  <?php echo link_to($path->getDriver(), 'driver/view?id='.$path->getDriver()->getId()); ?>
</td>
<!--
<td class="sf_admin_foreignkey sf_admin_list_td_type_id">
  <?php //echo $path->getType() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_vendor_id">
  <?php //echo $path->getVendor() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_device_id">
  <?php //echo $path->getDevice() ?>
</td>
-->