<td class="sf_admin_text sf_admin_list_td_name">
  <?php echo strtoupper($system->getName()) ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_driver_id">
  <?php echo link_to($system->getDriver(), 'driver/view?id='.$system->getDriver()->getId()); ?>
</td>