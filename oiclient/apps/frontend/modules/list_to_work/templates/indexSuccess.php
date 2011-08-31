<?php echo use_helper('I18N') ?>
<?php include_partial('menu_js',array('hw' => $hw)); ?>
<?php echo use_helper('Javascript'); ?>

<div class="eventos">
<fieldset>
    <legend><?php echo __("Partition to boot"); ?></legend>
    <table class="one-column-emphasis" width="100%;">
        <colgroup>
            <col class="oce-first" />
        </colgroup>
        <thead>
            <tr>
                <th scope="col"><?php echo __('os'); ?></th>
                <th scope="col"><?php echo __('partition'); ?></th>
                <th scope="col"><?php echo __('Size'); ?></th>
                <th scope="col"><?php echo __('Boot'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($hw->listDisks->disks as $disk) {

                foreach ($disk->partitions as $partition) {

                    if ($partition->fileSystem != null && $partition->fileSystem->bootable != null && !$partition->fileSystem->isOIFileSystem) {

                        echo '<tr>';
                        echo '<td>';
//                        if(!empty($partition->fileSystem->os) ){
                            echo $partition->fileSystem->os;
//                        }else{
//                            echo "-";
//                        }
                        echo '</td>';
                        
                        echo '<td>' . $disk->model . ' (' . $partition->partitionNumber . ')</td>';
                        $PsizeT = unitsClass::diskSectorSize($partition->sectors);
                        echo '<td>' . $PsizeT['size'] . $PsizeT['unit'] . '</td>';
                        echo '<td>' . link_to('[' . __('Boot') . ']', 'list_to_work/nextboot?partitionName=' . $partition->partitionName . '&diskName=' . $disk->diskName,array('id'=>"l1")) . '</td>';
                        echo '</tr>';
                    }
                }
            }
            ?>
        </tbody>
    </table>
</fieldset>
<div class="menua">
<br>
<?php echo link_to('Login', 'my_login/index', array('class' => 'botoi-login','id'=>"login")); ?>
<br>
<?php echo link_to('Halt', 'list_to_work/halt', 'class="botoi-halt"'); ?>
<br>
<?php echo link_to('reboot', 'list_to_work/reboot', 'class="botoi-reboot"'); ?>
<br>
<?php echo link_to('task', 'list_to_work/index', 'class="botoi-task"'); ?>
</div>
</div>