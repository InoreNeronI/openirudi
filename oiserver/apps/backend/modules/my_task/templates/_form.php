<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<?php include_partial('my_task/pc_change_ajax');?>
<?php //gemini 2011-02-15 ?>
<?php include_partial('my_task/imageset_js',array('my_task'=>$my_task));?>

<div class="sf_admin_form">
  <?php if($form->isNew()):?>
  <?php echo form_tag_for($form, '@my_task') ?>
  <?php else:?>
	<?php //OHARRA::::form_tag_for-ek edit kasuan ez du ondo sortzen url-a azken finean td-tako show,edit,delete antzeko arazoa, ta honela konpontzen da?>
    <form method="post" action="<?php echo url_for('@my_task').'/'.$sf_request->getParameter('id');?>">
	<input type="hidden" name="sf_method" value="put" />	
  <?php endif; ?>
    <?php echo $form->renderHiddenFields() ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

    <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
      <?php include_partial('my_task/form_fieldset', array('my_task' => $my_task, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
    <?php endforeach; ?>

    <?php include_partial('my_task/form_actions', array('my_task' => $my_task, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </form>
</div>
