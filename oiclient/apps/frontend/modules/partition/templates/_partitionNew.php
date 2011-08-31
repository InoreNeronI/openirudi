
<?php echo form_tag('/partition/add', array('id' => 'addPartition_'.$diskName, 'name' => 'addPartition')); ?>
<?php echo input_hidden_tag('partition[diskName]', $diskName) ?>

<?php if($disk->freePrimarySectorsTotal>0 || $disk->freeLogicSectorsTotal>0 ) { ?>
    <tr id="newPartition">
        <td>
        <?php echo "NewPartition in $diskName "; ?>
        </td>

        <td>
            <?php
                $type_opts=array();
                if($disk->freePrimarySectorsTotal>0){
                    $type_opts['primary']=__('Primary');
                    $type_opts['extended']=__('Extended');
                    $type_opts['oisystem']=__('OiPartition');
                }

                if( $disk->hasExtendPartition && $disk->freeLogicSectorsTotal>0){
                    $type_opts['logical']= __('Logical');
                }

                echo select_tag('partition[type]', options_for_select($type_opts));
            ?>
        </td>

        <td>
            <?php
                $fs_opts=explode(',',sfConfig::get('app_oipartition_fsImageCreateType'));
                echo select_tag('partition[fs]', options_for_select($fs_opts));
             ?>
        </td>

        <td>
            <?php echo select_tag('partition[boot]', options_for_select(array(0 => __('False'), 1 => __('True')))) ?>
        </td>

        <td>
            <?php
            if($disk->freePrimarySectorsTotal>0){
                $free = unitsClass::diskSectorSize($disk->maxNewPrimaryPartitionSectors);
            }else{
                $free = unitsClass::diskSectorSize($disk->maxNewLogicPartitionSectors);
            }
            echo input_tag('partition[size]', $free['size'], array('size' => 8, 'maxlength' => 8));
            echo select_tag('partition[unit]', options_for_select(array_combine(array_keys($listSizeUnits), array_keys($listSizeUnits)), $free['unit']))
            ?>
        </td>

        <td>
            <?php echo image_tag('save', array('class'=>'newConfirm', 'width' => '16', 'title' => __('Save'))) ?>
            <?php echo link_to(image_tag('cancel', array('width' => '16')), 'partition/index', array('title' => __('Cancel'))) ?>
        </td>
    </tr>
<?php } ?>
