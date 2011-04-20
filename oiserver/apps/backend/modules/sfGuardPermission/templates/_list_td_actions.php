<td>
  <ul class="sf_admin_td_actions">
    <li class="sf_admin_action_show">
      <?php if ($sf_user->hasCredential(array('sf_guard_permission_show','sf_guard_permission_edit'),false)): ?>
		<?php echo $helper->linkToShow($sf_guard_permission->getId()) ?>		
	  <?php endif; ?>

    </li>
    <?php if ($sf_user->hasCredential(array(  0 => 'sf_guard_permission_edit',))): ?>
<?php echo $helper->linkToEdit($sf_guard_permission, array(  'credentials' =>   array(    0 => 'sf_guard_permission_edit',  ),  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
<?php endif; ?>

    <?php if ($sf_user->hasCredential(array(  0 => 'sf_guard_permission_delete',))): ?>
<?php echo $helper->linkToDelete($sf_guard_permission, array(  'credentials' =>   array(    0 => 'sf_guard_permission_delete',  ),  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
<?php endif; ?>

  </ul>
</td>
