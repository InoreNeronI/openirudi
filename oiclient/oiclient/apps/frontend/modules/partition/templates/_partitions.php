<?php echo use_helper('Form'); ?>
<?php include_partial('confirm_js'); ?>


<div class="eventos">
<fieldset>
    <legend><?php echo __('Partitions'); ?></legend>

    <?php
    foreach ($hw->listDisks->disks as $diskName => $disk) {
    ?>
        <table width="100%">
            <tr>
                <th colspan="<?php
        if (isset($partitionModule))
            echo 7; else
            echo 6; ?>">
                    <?php
                    echo __('Disk') . ': ' . $diskName . ' (' . $disk->humanSize['size'] . ' ' . $disk->humanSize['unit'] . ')';
                    ?>
            </th>
        </tr>

        <tr>
            <th><?php echo __('Partition'); ?></th>
            <th><?php echo __('Type'); ?> (<?php echo __('ID'); ?>)</th>
            <th><?php echo __('Bootable'); ?></th>
            <th><?php echo __('Start'); ?></th>
            <th><?php echo __('Parttion size'); ?></th>
            <th><?php echo __('FS Free/size'); ?></th><?php if (isset($partitionModule)) { ?>
                <th><?php echo __(''); ?></th><?php } ?>
        </tr>
        <?php
                    if (is_array($disk->partitions)) {
                        foreach ($disk->partitions as $p) {
                            if (isset($partitionModule) && isset($partitionName) && $p->partitionName == $partitionName) {
                                $args = array('p' => $p, 'partitionModule' => $partitionModule, 'listSizeUnits' => $listSizeUnits, 'diskName' => $diskName, 'partitionTypes' => $partitionTypes, 'listOisystems' => $listOisystems);
                                include_partial('partition/partitionChange', $args);
                            } else {
                                $args = array('p' => $p, 'diskName' => $diskName, 'freePrimarySectorsTotal' => $disk->freePrimarySectorsTotal, 'freeLogicSectorsTotal' => $disk->freeLogicSectorsTotal, 'listOisystems' => $listOisystems);
                                if (isset($partitionModule)) {
                                    $args['partitionModule'] = $partitionModule;
                                }
                                include_partial('partition/partitionView', $args);
                            }
                        }
                    }
        ?>

                </table>
    <?php
                    if (isset($partitionModule)) {
                        $args = array('diskName' => $diskName, 'disk' => $disk, 'listSizeUnits' => $listSizeUnits);
                        include_partial('partition/partitionNew', $args);
                    }
    ?>
<? } ?>

</fieldset>
   <div class="spacer">&nbsp;</div>
</div>
