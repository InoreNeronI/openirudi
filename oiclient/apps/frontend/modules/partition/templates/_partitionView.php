<?php
if ($p->startSector == 0 && $p->sectors == 0 && $p->humanSize['size'] == 0 && $p->humanSize['unit'] == 'B') {

} else { ?>
    <tr id="<?php echo $p->partitionName; ?>">
        <td><?php echo $p->partitionName; ?></td>
        <?php
        if (is_object($p->fileSystem) && $p->fileSystem->isOIFileSystem) { ?>
            <td style="font-weight:bold"><?php
           echo __('OpenIrudi System'); ?>
            </td><?php
        } else { ?>
            <td><?php echo $p->partitionTypeName.' ('.$p->partitionTypeId.')'; ?></td><?php
        } ?>
        <td><?php if ($p->bootable) echo '*'; else  echo '.'; ?></td>
        <td><?php
        $s=unitsClass::diskSectorSize($p->startSector);
        echo $s['size'].$s['unit'];

        ?></td>
        <td ><?php echo $p->humanSize['size'].' '.$p->humanSize['unit']; ?></td>
        <td  style="white-space:nowrap" ><?php
            if ( !is_null($p->fileSystem) && is_object($p->fileSystem) ) {
                echo $p->fileSystem->freeHuman['size'].' '.$p->fileSystem->freeHuman['unit'].' / '.$p->fileSystem->sizeHuman['size'].' '.$p->fileSystem->sizeHuman['unit'];
            } else {
                echo __('NO FS');
            } ?>
        </td><?php
    if(isset($partitionModule)) { ?>
        <td style="white-space:nowrap"><?php
            if($p->editable==1 && ($freePrimarySectorsTotal > 0 || $p->partitionTypeId)) {
                echo link_to(image_tag('edit.png', array('width' => '16')), 'partition/change?id='.$p->partitionName, array('title' => __('Change')));
            }
            if($listOisystems->activeOiSystem() != $p->partitionName ){
            echo image_tag('edittrash.png', array('class'=>'delConfirm','width' => '16'));
                    //, 'partition/remove?diskName='.$diskName.'&partitionName='.$p->partitionName, array('title' => __('Remove'), 'confirm' => __('¿Are you sure?')));
            }?>

        </td><?php
    } ?>
    </tr><?php
} ?>