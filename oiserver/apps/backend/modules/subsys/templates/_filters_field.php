<?php if ($field->isPartial()): ?>
  <?php include_partial('subsys/'.$name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
  <?php include_component('subsys', $name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
  <tr class="<?php echo $class ?>">
    <td>
      <?php echo $form[$name]->renderLabel($label) ?>
    </td>
    <td>
      <?php echo $form[$name]->renderError() ?>

	  <?php //kam?>
      <?php if($name=='device_id'):?>
		<?php include_partial('subsys/filters_autocomplete_device_id');?>	
	  <?php else:?>
       <?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?>
	  <?php endif; ?>

      <?php //kam?>	
	  <?php if(in_array($name,sfConfig::get('app_subsys_autocomplete_array'))):?>
		<img class="img_class_<?php echo $name?>" src="/drivers/web/sfPropelPlugin/images/arrow_rotate_clockwise.png" width="16" height="16" />      
	  <?php endif;?>	
      <?php if ($help || $help = $form[$name]->renderHelp()): ?>
        <div class="help"><?php echo __($help, array(), 'messages') ?></div>
      <?php endif; ?>
    </td>
  </tr>
<?php endif; ?>
