<?php use_helper('I18N', 'Date') ?>
<?php include_partial('vendor/assets') ?>


<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_code">
    <div class="fcell">
        <label><?php echo __('Code', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $vendor->getCode() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_name">
    <div class="fcell">
        <label><?php echo __('Name', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $vendor->getName() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_type">
    <div class="fcell">
        <label><?php echo __('Type', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo strtoupper($vendor->getType()); ?></div>
    </div>
</div>