<?php echo use_helper('I18N'); ?>
<?php echo use_helper('Javascript'); ?>
<?php echo use_helper('Form'); ?>

<script type="text/javascript">
    var p=0;
    $(document).ready(function() {
        $(".pradio").click(function(){
            p=1
        })
         $("#create_image").click(function(){
             if(!p){
                 alert("<?php echo __('Select partition'); ?>");
                 return false;
             }

             if( $('#name').val() =="" ){
                 alert("<?php echo __('Name is empty'); ?>");
                 return false;
             }
             if( $('#name').val() =="" ){
                 alert("<?php echo __('Name is empty'); ?>");
                 return false;
             }             
         })
    })


</script>

<?php echo form_tag('image/newImage2'); ?>
<div class="eventos">
    <fieldset>
        <legend><?php echo __('Create Image from partition'); ?></legend>
            <div class="fcell-form">
                <label for="izena"><?php echo __('name') ?>: </label>
                <?php echo input_tag('new[name]','',array('id'=>'name','size'=>'20','maxlength'=>'20','class'=>'linea' )); ?>
            </div>
            <div class="fcell-form">
                <label for="ezaugarri"><?php echo __('Image Description') ?>: </label>
                <?php echo textarea_tag('new[description]', '', 'size=35x4 class="linea"'); ?>
            </div>
    </fieldset>
    <fieldset>
        <legend><?php echo __('Source partition'); ?></legend>
        <?php
        foreach ($hw->listDisks->disks as $disk) {

            foreach ($disk->partitions as $partition) {
                if (!is_null($partition->fileSystem) && $partition->fileSystem->canCreateImage && !$partition->fileSystem->isOIFileSystem) {

                    echo radiobutton_tag('new[source]', $partition->partitionName, false , array('class'=>'pradio'));
                    echo ' ' . $partition->fileSystem->os . ' ' . $partition->partitionName . ' (' . $partition->fileSystem->type . ') ';
                    echo $partition->fileSystem->sizeHuman['size'] . ' ' . $partition->fileSystem->sizeHuman['unit'] . '<br />';
                }
            }
        }
        ?>

    </fieldset>
    <?php echo submit_tag(__('Save'), array('id' => 'create_image')); ?>
    <?php echo button_to(__('Cancel'), 'image/index'); ?>
    <div class="spacer">&nbsp;</div>

</div>
</form>