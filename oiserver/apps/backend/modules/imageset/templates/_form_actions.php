<ul class="sf_admin_actions">

  <?php echo $helper->linkToDelete($form->getObject(), array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>

  <?php echo $helper->linkToList(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Cancel',)) ?>

  <?php if(!$form->isNew()):?>
  	<?php echo $helper->linkToShow($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'show',  'label' => 'Show',)) ?>
  <?php endif;?>

  <li class="sf_admin_action_add_new_partition">
  	<input id="add_new_partition" type="button" name="add_new" value="<?php echo __('Add new partition',array(),'messages');?>" />
  </li>

  <li class="sf_admin_action_execute">
  	<input id="execute" type="submit" name="repart" value="<?php echo __('Execute',array(),'messages')?>" />
  </li>

  <?php //echo $helper->linkToSave($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save',  'label' => 'Save',)) ?>

  <?php //echo $helper->linkToSaveAndAdd($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save_and_add',  'label' => 'Save and add',)) ?>
</ul>
