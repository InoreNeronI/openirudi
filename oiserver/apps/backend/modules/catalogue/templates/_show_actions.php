<ul class="sf_admin_actions">
  <?php echo $helper->linkToList(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Cancel',)) ?>
  <?php if($sf_user->hasCredential('catalogue_edit')):?>	
  	<?php echo $helper->linkToEdit($catalogue, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
  <?php endif;?>	
</ul>