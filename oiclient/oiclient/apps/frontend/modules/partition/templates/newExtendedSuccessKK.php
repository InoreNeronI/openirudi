<?php echo use_helper('Form') ?>
<?php echo use_helper('I18N') ?><?php
        if (isset($freePartitions)) { ?>
<?php echo form_tag('/partition/save', array('name' => 'addPartition')) ?>
	<?php echo input_hidden_tag('disk', $diskName) ?>
	<?php echo input_hidden_tag('partition[id]', 5) ?> <!-- Extended type -->
	<?php echo input_hidden_tag('partition[new_extend]', 1) ?> <!-- Extended type -->
	<div class="flerro">
		<label for="partition[partition]"><?php echo __('Partition') ?>:</label>
		<?php echo select_tag('partition[partitionName]', options_for_select($freePartitions)) ?>
	</div>

	<div class="flerro">
		<label for="partition[size]"><?php echo __('Size') ?>:</label>
		<?php echo input_tag('partition[sizeB]', $freeSize['size'], array('size' => '10')) ?>
		<?php echo select_tag('partition[unit]', options_for_select(array_combine(array_keys($listSizeUnits), array_keys($listSizeUnits)), $freeSize['unit'])) ?>
		<label><?php echo __('Max. allowed size: %1%', array('%1%' => $freeSize['size'].$freeSize['unit'])) ?></label>
	</div>

	<?php echo submit_tag(__('Save')) ?>
	<?php echo button_to(__('Cancel'), 'partition/index') ?><a><?php
        } ?>
</form>