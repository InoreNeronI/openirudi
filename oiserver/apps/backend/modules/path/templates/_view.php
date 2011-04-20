<?php use_helper('I18N', 'Date') ?>
<?php include_partial('path/assets') ?>


<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_id">
    <div class="fcell">
        <label><?php echo __('Id', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $path->getId() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_driver">
    <div class="fcell">
        <label><?php echo __('Driver', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $path->getDriver() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_name">
    <div class="fcell">
        <label><?php echo __('Path', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $path->getPath() ?></div>
    </div>
</div>