<ul class="sf_admin_actions">
  <?php echo $helper->linkToList(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Cancel',)) ?>
  <?php if($sf_user->hasCredential('trans_unit_edit')):?>
  	<?php echo $helper->linkToEdit($trans_unit, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
  <?php endif;?>	
</ul>