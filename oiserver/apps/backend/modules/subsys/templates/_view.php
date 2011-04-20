<?php use_helper('I18N', 'Date') ?>
<?php include_partial('subsys/assets') ?>


<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_code">
    <div class="fcell">
        <label><?php echo __('Code', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $subsys->getCode() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_name">
    <div class="fcell">
        <label><?php echo __('Name', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $subsys->getName() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_device">
    <div class="fcell">
        <label><?php echo __('Device', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $subsys->getDevice() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_vendor">
    <div class="fcell">
        <label><?php echo __('Vendor', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $subsys->getDevice()->getVendor() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_type">
    <div class="fcell">
        <label><?php echo __('Type', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo strtoupper($subsys->getDevice()->getType()); ?></div>
    </div>
</div>