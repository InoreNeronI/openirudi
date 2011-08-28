
<?php
echo __('If you Install oiclient in local disk, you deploy faster and  you can boot oiclient from disk without PXE');
echo "<br>";
if(count($listOisystems->oisystems) == 0) {
    echo form_tag('image/installOIsystem2',array('class'=>'submitMove'));
    foreach ($hw->listDisks->disks as $k => $disk) {
        echo radiobutton_tag('partition[diskName]', $disk->diskName, false, array('class' => 'radio_partition'));
        echo $disk->diskName . ' (' . $disk->humanSize['size'] . $disk->humanSize['unit'] . ')';

        echo __('Size') . ':';
        $free = unitsClass::diskSectorSize($disk->maxNewPrimaryPartitionSectors);
        echo input_tag('partition[size][size]', $free['size'], array('size' => 6, 'maxlength' => 6, 'id' => 'input_' . $k));
        echo select_tag('partition[size][unit]', options_for_select(unitsClass::listSizeUnits(true), $free['unit']), array('id' => 'select_' . $k));
    }
    echo '<br />'.submit_tag(__('Create'), array('id' => 'create_oi_partition'));
    echo '</form>';
}else{
    ?>
        <table width="95%" align="center">
        <tr>
            <th><?php echo __('partition'); ?></th>
            <th><?php echo _('operations'); ?></th>
        </tr>
            <?php
            $cc=0;
            foreach($hw->listDisks->oiPartitions()  as $partitionName => $partition ){
                $diskName=$hw->listDisks->diskOfpartition($partitionName);
                $disk=$hw->listDisks->disks[$diskName];
                $cc++;
                echo '<tr ';if($cc%2 == 0) echo'class=""';else echo' class="odd"';echo'>';
                echo '<td>' . $disk->model .' ( '. $partition->partitionNumber .' )</td>';
                echo '<td>';
                echo link_to('['.__('Reinstall').']', 'image/reinstallOiSystem2?partitionName='.$partition->partitionName );
                echo link_to('['.__('FixMbr').']', 'image/mKBoot' );
                echo '</td></tr>';
            }

            $cc++;
            echo '<tr ';if($cc%2 == 0) echo'class=""';else echo' class="odd"';echo'>';
            $is_boot=$listOisystems->getConfProperty('boot');
            if( $is_boot === 0 || empty($is_boot) ){
                echo '<td colspan=2 >'.link_to('['.__('Boot first partition').']', 'config/isBoot?boot=1',array('id'=>'isboot') ).'</td></tr>';
            }else{
                echo '<td colspan=2 >'.link_to('['.__('Boot menu').']', 'config/isBoot?boot=0',array('id'=>'isboot') ).'</td></tr>';
            }
            ?>

        </table>
            <br>

    <?php
   
}
?>



