<ul class="sf_admin_actions">
  	<?php if ($sf_user->hasCredential(array('sf_guard_user_delete'))): ?>	
		<?php echo $helper->linkToDelete($sf_guard_user, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
	<?php endif; ?>  
	
	<?php echo $helper->linkToList(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Cancel',)) ?>
  	
	<?php if ($sf_user->hasCredential(array('sf_guard_user_edit'))): ?>
		<?php echo $helper->linkToEdit($sf_guard_user, array(  'credentials' =>   array(    0 => 'sf_guard_user_edit',  ),  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
	<?php endif; ?>
</ul>
