<?php use_helper('I18N', 'Date') ?>
<?php include_partial('driver/assets') ?>


<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_id">
    <div class="fcell">
        <label><?php echo __('Id', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $driver->getId() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_name">
    <div class="fcell">
        <label><?php echo __('Name', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $driver->getName() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_vendor">
    <div class="fcell">
        <label><?php echo __('Vendor', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $driver->getVendor() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_device">
    <div class="fcell">
        <label><?php echo __('Device', array(), 'messages');?></label>
        <div>&nbsp;<?php echo $driver->getDevice() ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_type">
    <div class="fcell">
        <label><?php echo __('Type', array(), 'messages');?></label>
        <div>&nbsp;<?php echo strtoupper($driver->getType()) ?></div>
    </div>
</div>