<?php use_helper('I18N', 'Date') ?>
<?php include_partial('device/assets') ?>


<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_id">
    <div class="fcell">
        <label><?php echo __('Id', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $device->getId() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_code">
    <div class="fcell">
        <label><?php echo __('Code', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $device->getCode() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_name">
    <div class="fcell">
        <label><?php echo __('Name', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $device->getName() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_vendor">
    <div class="fcell">
        <label><?php echo __('Vendor', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $device->getVendor() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_type">
    <div class="fcell">
        <label><?php echo __('Type', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo strtoupper($device->getType()); ?></div>
    </div>
</div>