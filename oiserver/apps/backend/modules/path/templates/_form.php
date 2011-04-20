<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<div class="sf_admin_form">
   <?php if($form->isNew()):?>
   <?php echo form_tag_for($form, '@path') ?>
   <?php else:?>
	<?php //OHARRA::::form_tag_for-ek edit kasuan ez du ondo sortzen url-a azken finean td-tako show,edit,delete antzeko arazoa, ta honela konpontzen da?>
    <form method="post" action="<?php echo url_for('@path').'/'.$sf_request->getParameter('id');?>">
	<input type="hidden" name="sf_method" value="put" />	
   <?php endif; ?>
    <?php echo $form->renderHiddenFields() ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

    <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
      <?php include_partial('path/form_fieldset', array('path' => $path, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
    <?php endforeach; ?>

    <?php include_partial('path/form_actions', array('path' => $path, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </form>
</div>
