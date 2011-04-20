<td class="sf_admin_text sf_admin_list_td_id">
  <?php //kam?>
  <?php //echo link_to($oiimages->getId(), 'oiimages_edit', $oiimages) ?>
  <?php echo $oiimages->getId(); ?>
</td>
<td class="sf_admin_text sf_admin_list_td_ref">
  <?php echo $oiimages->getRef() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_name">
  <?php echo $oiimages->getName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_so">
  <?php //gemini?>
  <?php //echo $oiimages->getSo() ?>  
  <?php echo $oiimages->getOs() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_uuid">
  <?php echo $oiimages->getUuid() ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php //echo $oiimages->getCreatedAt() ? format_date($oiimages->getCreatedAt(), "f") : '&nbsp;' ?>
  <?php //echo $oiimages->getCreatedAt() ? format_date($oiimages->getCreatedAt(),'I',$sf_user->getCulture()) : '&nbsp;' ?>	
  <?php echo $oiimages->getCreatedAt() ? $oiimages->get_custom_created_at() : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_td_partition_size">
  <?php echo $oiimages->getPartitionSize() ?>
</td>
<!--
<td class="sf_admin_text sf_admin_list_td_partition_type">
  <?php //echo $oiimages->getPartitionType() ?>
</td>
-->
<td class="sf_admin_text sf_admin_list_td_filesystem_size">
  <?php echo $oiimages->getFilesystemSize() ?>
</td>
<!--
<td class="sf_admin_text sf_admin_list_td_filesystem_type">
  <?php //echo $oiimages->getFilesystemType() ?>
</td>
-->