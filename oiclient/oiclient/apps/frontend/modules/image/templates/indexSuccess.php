<?php echo use_helper('I18N'); ?>
<?php echo use_helper('Javascript'); ?>
<?php echo use_helper('Form'); ?>

<div class="eventos">

    <?php if(count($listImages->imageSets)>0 ) { ?>
    <fieldset>
        <legend> <?php echo __('Deploy image group to disk');?> </legend>
        <div class="scroll">
        <table width="95%" align="center">
            <tr>
                <th><?php echo __('Id'); ?></th>
                <th><?php echo __('composition'); ?></th>
                <th>link</th>
                <?php
                $cc=0;
                foreach ($listImages->imageSets as $imageSet) {
                $cc++;
                    echo '<tr ';if($cc%2 == 0) echo'class=""';else echo' class="odd"'; echo'><td>' . $imageSet['name'] . '</td>
                    <td>' . $imageSet['label'] . '</td>
                    <td>' . link_to('[' . __('Deploy') . ']', 'image/deployImageSet1?id=' . $imageSet['id'], array('title' => __('Deploy'))) . '</td></tr>';
                }
                ?>

        </table>
        </div>
    </fieldset>
    <?php } ?>
    <fieldset>
        <legend><?php echo __('Deploy one image to disk partition'); ?></legend>
        <div class="scroll">
        <table width="95%" align="center">
            <tr>
                <th><?php echo __('Id'); ?></th>
                <th><?php echo __('partition_size'); ?></th>
                <th><?php echo __('created_at'); ?></th>
                <th>link</th>
            </tr>

            <?php
            $cc=0;
            foreach ($listImages->list as $image) {
            $cc++;
                $is = unitsClass::diskSectorSize($image->partition_size);
                echo '<tr ';if($cc%2 == 0) echo'class=""';else echo' class="odd"'; echo'><td>' . $image->name . '</td>
                <td>' . $is['size'] . $is['unit'] . '</td>
                <td>' . $image->created_at . '</td>
                <td>' . link_to( __('Deploy') , 'image/deployImage1?id=' . $image->id, array('title' => __('Deploy'))) . '</td></tr>';
            }
            ?>

        </table>
        </div>
    </fieldset>

    <div class="spacer">&nbsp;</div>
</div>


