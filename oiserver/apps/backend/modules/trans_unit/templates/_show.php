<table id="trans_unit_table_show">
  <tbody>
    <tr>
       <td><b><?php echo __('Msg',array(),'messages');?>:</b></th>
<td class="sf_admin_text sf_admin_list_th_msg_id">
  <?php echo link_to($trans_unit->getMsgId(), 'trans_unit_edit', $trans_unit) ?>
</td>
    <tr>
       <td><b><?php echo __('Cat',array(),'messages');?>:</b></th>
<td class="sf_admin_foreignkey sf_admin_list_th_cat_id">
  <?php //echo $trans_unit->getCatId() ?>
  <?php echo $trans_unit->getCatalogue() ?>
</td>
    <tr>
       <td><b><?php echo __('Id',array(),'messages');?>:</b></th>
<td class="sf_admin_text sf_admin_list_th_id">
  <?php echo $trans_unit->getId() ?>
</td>
    <tr>
       <td><b><?php echo __('Source',array(),'messages');?>:</b></th>
<td class="sf_admin_text sf_admin_list_th_source">
  <?php echo $trans_unit->getSource() ?>
</td>
    <tr>
       <td><b><?php echo __('Target',array(),'messages');?>:</b></th>
<td class="sf_admin_text sf_admin_list_th_target">
  <?php echo $trans_unit->getTarget() ?>
</td>
    <tr>
       <td><b><?php echo __('Comments',array(),'messages');?>:</b></th>
<td class="sf_admin_text sf_admin_list_th_comments">
  <?php echo $trans_unit->getComments() ?>
</td>
    <tr>
       <td><b><?php echo __('Date added',array(),'messages');?>:</b></th>
<td class="sf_admin_date sf_admin_list_th_date_added">
  <?php echo $trans_unit->getDateAdded() ? format_date($trans_unit->getDateAdded(), "f") : '&nbsp;' ?>
</td>
    <tr>
       <td><b><?php echo __('Date modified',array(),'messages');?>:</b></th>
<td class="sf_admin_date sf_admin_list_th_date_modified">
  <?php echo $trans_unit->getDateModified() ? format_date($trans_unit->getDateModified(), "f") : '&nbsp;' ?>
</td>
    <tr>
       <td><b><?php echo __('Author',array(),'messages');?>:</b></th>
<td class="sf_admin_text sf_admin_list_th_author">
  <?php echo $trans_unit->getAuthor() ?>
</td>
    <tr>
       <td><b><?php echo __('Translated',array(),'messages');?>:</b></th>
<td class="sf_admin_boolean sf_admin_list_th_translated">
  <?php echo get_partial('trans_unit/list_field_boolean', array('value' => $trans_unit->getTranslated())) ?>
</td>
    </tr>
  </tbody>
</table>
