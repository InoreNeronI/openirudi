<table id="catalogue_table_show">
  <tbody>
    <tr>
       <td><b><?php echo __('Cat',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_cat_id">
  <?php echo link_to($catalogue->getCatId(), 'catalogue_edit', $catalogue) ?>
</td>
    <tr>
       <td><b><?php echo __('Name',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_name">
  <?php echo $catalogue->getName() ?>
</td>
    <tr>
       <td><b><?php echo __('Source lang',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_source_lang">
  <?php echo $catalogue->getSourceLang() ?>
</td>
    <tr>
       <td><b><?php echo __('Target lang',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_target_lang">
  <?php echo $catalogue->getTargetLang() ?>
</td>
    <tr>
       <td><b><?php echo __('Date created',array(),'messages');?>:</b></td>
<td class="sf_admin_date sf_admin_list_th_date_created">
  <?php echo $catalogue->getDateCreated() ? format_date($catalogue->getDateCreated(), "f") : '&nbsp;' ?>
</td>
    <tr>
       <td><b><?php echo __('Date modified',array(),'messages');?>:</b></td>
<td class="sf_admin_date sf_admin_list_th_date_modified">
  <?php echo $catalogue->getDateModified() ? format_date($catalogue->getDateModified(), "f") : '&nbsp;' ?>
</td>
    <tr>
       <td><b><?php echo __('Author',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_author">
  <?php echo $catalogue->getAuthor() ?>
</td>
    </tr>
  </tbody>
</table>
