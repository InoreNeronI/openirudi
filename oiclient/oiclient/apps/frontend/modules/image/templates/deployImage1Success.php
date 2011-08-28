<?php echo use_helper('I18N'); ?>
<?php echo use_helper('Javascript'); ?>
<?php echo use_helper('Form'); ?>

<script type="text/javascript">
    var p=0;
    $(document).ready(function() {
        $(".pradio").click(function(){
            p=1
        })
         $("#deploy_image").click(function(){
             if(!p){
                 alert("<?php echo __('Select partition'); ?>");
                 return false;
             }    
         })
    })


</script>



<div class="eventos">
<fieldset>
    <legend><?php echo __('Image properties'); ?></legend>
    <table>
        <tr><td><?php echo __('Name') . ':'; ?></td>
            <td><?php echo $image->name; ?></td>
        </tr>

        <tr><td><?php echo __('Created at') . ':'; ?></td>
            <td><?php echo $image->created_at; ?></td>
        </tr>

        <?php $PsizeT = unitsClass::diskSectorSize($image->partition_size); ?>
        <tr><td><?php echo __('Partition  size') . ':'; ?></td>
            <td><?php echo $PsizeT['size'] . $PsizeT['unit']; ?></td>
        </tr>

        <?php $fs = unitsClass::converse(array('size' => $image->filesystem_size, 'unit' => 'B')); ?>
        <tr><td><?php echo __('filesystem  size') . ':'; ?></td>
            <td><?php echo $fs['size'] . $fs['unit']; ?></td>
        </tr>

        <tr><td><?php echo __('Description') . ':'; ?></td>
            <td><?php echo $image->description; ?></td>
        </tr>
    </table>
</fieldset>

<br />
<?php
        echo form_tag('image/deployImage2');
        echo input_hidden_tag('deploy[id]', "$id");
?>

        <div>

    <?php if (count($hw->listDisks->allPartitions()) > 0) {
    ?>
            <fieldset>
                <legend><?php echo __('Deploy and overwrite partition'); ?></legend>
                <table>
                    <tr>
                        <th><?php echo __('Sel') . ':'; ?></th>
                        <th><?php echo __('Partition') . ':'; ?></th>
                        <th><?php echo __('now') . ':'; ?></th>
                    </tr>

            <?php
            foreach ($hw->listDisks->disks as $disk) {
                foreach ($disk->partitions as $partition) {
                    if (!is_null($partition->fileSystem) && $partition->fileSystem->isOIFileSystem) continue;
                    if ($disk->hasExtendPartition && $partition->partitionName == $disk->extendedPartition ) continue;
                    echo '<tr><td>' . radiobutton_tag('deploy[partitionName]', $partition->partitionName, false,array('class'=>'pradio')) . '</td>';
                    echo '<td>' . $disk->model . '  ' . $partition->partitionNumber . ' (' . $partition->humanSize['size'] . ' ' . $partition->humanSize['unit'] . ')' . '</td>';
                    if (is_null($partition->fileSystem)) {
                        echo '<td>' . $partition->partitionTypeName. '</td>';
                    } else {
                        echo '<td>' . $partition->fileSystem->type .' / '.$partition->fileSystem->os.'</td>';
                    }
                    echo '</tr>';
                }
            }
            ?>
        </table>
    </fieldset>

    <?php } ?>

    </div><div>

    <?php
        $maxPartition = unitsClass::diskSectorSize($hw->listDisks->maxPartitionAvailable(), 'B');
        if ($maxPartition['size'] > $image->partition_size) {
    ?>
            <fieldset>
                <legend><?php echo __('Deploy in new partition'); ?></legend>
                <table>
                    <tr>
                        <th><?php echo __('sel') . ':'; ?></th>
                        <th><?php echo __('disk') . ':'; ?></th>
                    </tr>
            <?php
            foreach ($hw->listDisks->disks as $disk) {
                $diskPrimaryFree = unitsClass::diskSectorSize($disk->maxNewPrimaryPartitionSectors, 'B');
                $diskLogicFree = unitsClass::diskSectorSize($disk->maxNewLogicPartitionSectors, 'B');

                if ($diskPrimaryFree['size'] >= $image->filesystem_size) {
                    echo '<tr><td>' . radiobutton_tag('deploy[partitionName]', 'new_primary_' . $disk->diskName, false,array('class'=>'pradio')) . '</td>';
                    echo '<td>' . __('new primary partition') . '</td></tr>';
                }

                if ($diskLogicFree['size'] >= $image->filesystem_size) {
                    echo '<tr><td>' . radiobutton_tag('deploy[partitionName]', 'new_logic_' . $disk->diskName, false,array('class'=>'pradio')) . '</td>';
                    echo '<td>' . __('new logic partition') . '</td></tr>';
                }
            }
            ?>
        </table>
    </fieldset>
<?php } ?>
</div>

<?php echo submit_tag(__('Deploy'),array('id' => 'deploy_image')); ?>
<?php echo button_to(__('Cancel'), 'image/index'); ?>

</form>
</div>