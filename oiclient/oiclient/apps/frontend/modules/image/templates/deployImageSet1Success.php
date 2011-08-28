<?php echo use_helper('I18N'); ?>
<?php echo use_helper('Javascript'); ?>
<?php echo use_helper('Form'); ?>

<script type="text/javascript">
    var p=0;
    $(document).ready(function() {
        $(".pradio").click(function(){
            p=1
        })
         $("#deploy_imageSet").click(function(){
             if(!p){
                 alert("<?php echo __('Select disk'); ?>");
                 return false;
             }
         })
    })


</script>

<div class="eventos">

    <fieldset>
        <legend><?php echo __('Image Set properties'); ?></legend>
        <table>
            <tr><td><?php echo __('Name') . ':'; ?></td>
                <td><?php echo $imageSet['name']; ?></td>
            </tr>
            <tr><td>
                    <?php echo __('Images') . ':'; ?>
                </td><td>
                    <?php echo $imageSet['label']; ?>
                </td>
            </tr>
        </table>
    </fieldset>

    <br />
    <?php
                    echo form_tag('image/deployImageSet2');
                    echo input_hidden_tag('deploy[id]', "$id");
    ?>
                    <fieldset>
                        <legend><?php echo __('Deploy in disk'); ?></legend>
                        <table>
                            <tr>
                                <th><?php echo __('Selection') . ':'; ?></th>
                                <th><?php echo __('Disk') . ':'; ?></th>
                            </tr>
            <?php foreach ($hw->listDisks->disks as $disk) {
            ?>
                        <tr><td><?php echo radiobutton_tag('deploy[diskName]', $disk->diskName, false,array('class'=>'pradio')); ?></td>
                            <td><?php echo $disk->model . ' ' . $disk->humanSize['size'] . $disk->humanSize['unit']; ?></td></tr>
            <?php } ?>
                </table>
            </fieldset>

            <div>
        <?php echo submit_tag(__('Deploy'),array('id' => 'deploy_imageSet')); ?>
        <?php echo button_to(__('Cancel'), 'image/index'); ?>
    </div>


</form>
</div>