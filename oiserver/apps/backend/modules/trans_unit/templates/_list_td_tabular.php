<td class="sf_admin_text sf_admin_list_th_msg_id">
  <?php //echo link_to($trans_unit->getMsgId(), 'trans_unit_edit', $trans_unit) ?>
  <?php echo $trans_unit->getMsgId()?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_th_cat_id">
  <?php //echo $trans_unit->getCatId() ?>
  <?php echo $trans_unit->getCatalogue() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_source">
  <?php echo $trans_unit->getSource() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_target">
  <?php echo $trans_unit->getTarget() ?>
</td>
