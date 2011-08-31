<?php echo use_helper('Form') ?>
<?php echo use_helper('I18N') ?>
<?php echo form_tag('/partition/save', array('name' => 'savePartition')) ?>
	<?php echo input_hidden_tag('disk', $diskName) ?>
	<?php echo input_hidden_tag('partition[new_logic]',1) ?>			
	<div class="flerro">
		<label for="partition[partition]"><?php echo __('Partition') ?>:</label>
		<?php echo input_tag('partition[partitionName]', $nextPartition,'readonly=true') ?>
	</div>
	<div class="flerro">
		<label for="partition[partition]"><?php echo __('Type') ?> (<?php echo __('ID') ?>)</label>
		<?php echo select_tag('partition[id]', options_for_select($partitionTypes)) ?>
	</div>
	<div class="flerro">
		<label for="partition[size]"><?php echo __('Size') ?>:</label>
		<?php echo input_tag('partition[sizeB]', $freeSize['size'], array('size' => '10')) ?>
		<?php echo select_tag('partition[unit]', options_for_select(array_combine(array_keys($listSizeUnits), array_keys($listSizeUnits)), $freeSize['unit'])) ?>
		<label><?php echo __('Max. allowed size: %1%', array('%1%' => $freeSize['size'].$freeSize['unit'])) ?></label>
	</div> 
	<?php echo submit_tag(__('Save')) ?>
	<?php echo button_to(__('Cancel'), 'partition/index') ?>
	</p>
</form>