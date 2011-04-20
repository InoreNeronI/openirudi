<?php use_helper('I18N', 'Date') ?>
<?php include_partial('system/assets') ?>


<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_id">
    <div class="fcell">
        <label><?php echo __('Id', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $system->getId() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_driver">
    <div class="fcell">
        <label><?php echo __('Driver', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $system->getDriver() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_name">
    <div class="fcell">
        <label><?php echo __('System', array(), 'messages');?></label>
        <div>&nbsp;<?php echo strtoupper($system->getName()) ?></div>
    </div>
</div>