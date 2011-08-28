<?php echo form_tag('/partition/save', array('id' => 'savePartition_'.$diskName, 'name' => 'savePartition')); ?>

<tr id="<?=$p->partitionName?>">
    <td>
	<?php echo input_hidden_tag('partition[diskName]', $diskName) ?>
	<?php echo input_tag('partition[partitionName]', $p->partitionName, array('readonly' => 'readonly', 'size' => 5)) ?>
    </td>
    
    <?php
    if (is_object($p->fileSystem) && $p->fileSystem->isOIFileSystem) { ?>
        <td><?php
        echo __('OpenIrudi System'); ?>
        </td><?php
    } elseif($p->partitionTypeId==0) { ?>
        <td><?php
		echo select_tag('partition[id]', options_for_select($partitionTypes, $p->partitionTypeId)); ?>
        </td><?php
    } else { ?>
        <td><?php
		echo input_tag('partition[id]',  $p->partitionTypeName.'('.$p->partitionTypeId.')',array('readonly'=>true,'size'=>10)); ?>
		</td><?php
    } ?>

    <td><?=$p->startSector?></td>
    <td><?php echo select_tag('partition[boot]', options_for_select(array(0 => __('False'), 1 => __('True')), $p->bootable)) ?></td>
    <td>
            <?php echo input_tag('partition[sizeB]', $p->humanSize['size'], array('size' => 5, 'maxlength' => 8)) ?>
            <?php echo select_tag('partition[unit]', options_for_select(array_combine(array_keys($listSizeUnits), array_keys($listSizeUnits)), $p->humanSize['unit'])) ?>
    </td>
    <td><?php if(is_object($p->fileSystem)) echo $p->fileSystem->free['size'].$p->fileSystem->free['unit'].'/'.$p->fileSystem->size['size'].$p->fileSystem->size['unit'];?></td>
    <td>
            
    <?php echo image_tag('save', array('class'=>'changeConfirm', 'width' => '16', 'title' => __('Save'))) ?>
    <?php echo link_to(image_tag('cancel', array('width' => '16')), 'partition/index', array('title' => __('Cancel'))) ?>
    </td>
</tr>
</form>