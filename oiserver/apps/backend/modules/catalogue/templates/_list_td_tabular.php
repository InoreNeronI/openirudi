<td class="sf_admin_text sf_admin_list_th_cat_id">
  <?php //echo link_to($catalogue->getCatId(), 'catalogue_edit', $catalogue) ?>
  <?php echo $catalogue->getCatId();?>
</td>
<td class="sf_admin_text sf_admin_list_th_name">
  <?php echo $catalogue->getName() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_source_lang">
  <?php echo $catalogue->getSourceLang() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_target_lang">
  <?php echo $catalogue->getTargetLang() ?>
</td>
<td class="sf_admin_date sf_admin_list_th_date_created">
  <?php echo $catalogue->getDateCreated() ? format_date($catalogue->getDateCreated(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_th_date_modified">
  <?php echo $catalogue->getDateModified() ? format_date($catalogue->getDateModified(), "f") : '&nbsp;' ?>
</td>
<td class="sf_admin_text sf_admin_list_th_author">
  <?php echo $catalogue->getAuthor() ?>
</td>
