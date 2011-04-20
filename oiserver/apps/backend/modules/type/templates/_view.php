<?php use_helper('I18N', 'Date') ?>
<?php include_partial('type/assets') ?>


<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_type">
    <div class="fcell">
        <label><?php echo __('Id', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo $type->getId(); ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_type">
    <div class="fcell">
        <label><?php echo __('Type', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo strtoupper($type->getType()); ?></div>
    </div>
</div>