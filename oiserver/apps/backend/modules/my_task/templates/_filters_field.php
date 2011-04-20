<?php if ($field->isPartial()): ?>
  <?php include_partial('my_task/'.$name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
  <?php include_component('my_task', $name, array('type' => 'filter', 'form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
  <tr class="<?php echo $class ?>">
    <td>
      <?php echo $form[$name]->renderLabel($label) ?>
    </td>
    <td>
      <?php echo $form[$name]->renderError() ?>

	  <?php if($name=='hour'):?>
		<?php $my_html=$form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)?>
		<?php include_partial('my_task/hour_filter_field',array('data'=>$my_html));?>
	 <?php else:?>		
      <?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?>
	<?php endif;?>

      <?php if ($help || $help = $form[$name]->renderHelp()): ?>
        <div class="help"><?php echo __($help, array(), 'messages') ?></div>
      <?php endif; ?>
    </td>
  </tr>
<?php endif; ?>
