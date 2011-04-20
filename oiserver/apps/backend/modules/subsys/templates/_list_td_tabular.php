<td class="sf_admin_text sf_admin_list_td_code">
  <?php $s_id = $subsys->getCode();
        $s_id = substr($s_id, 0, 4).':'.substr($s_id, 4, 4);
        //echo link_to($s_id, 'subsys_edit', $subsys) 
		//kam
		echo $s_id;	
	?>
</td>
<td class="sf_admin_text sf_admin_list_td_name">
  <?php echo $subsys->getName() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_device">
  <?php echo link_to($subsys->getDevice(), 'device/view?id='.$subsys->getDevice()->getId()); ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_vendor">
  <?php //echo link_to($subsys->getDevice()->getVendor(), '@vendor_view?cod1='.$subsys->getDevice()->getVendorId().'&cod2='.$subsys->getDevice()->getTypeId()); ?>
  <?php echo link_to($subsys->getDevice()->getVendor(), 'vendor/view?code='.$subsys->getDevice()->getVendorId().'&type_id='.$subsys->getDevice()->getTypeId()); ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_type">
  <?php echo link_to(strtoupper($subsys->getDevice()->getType()), 'type/view?id='.$subsys->getDevice()->getTypeId()); ?>
</td>