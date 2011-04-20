<td class="sf_admin_text sf_admin_list_th_id">
  <?php //echo link_to($imageset->getId(), 'imageset_edit', $imageset) ?>
  <?php echo $imageset->getId();?>
</td>
<td class="sf_admin_text sf_admin_list_th_name">
  <?php echo $imageset->getName() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_oiimages_list">
  <?php echo $imageset->getOiimages_list() ?>
</td>