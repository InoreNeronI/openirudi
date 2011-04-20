<?php //use_helper('I18N', 'Date') ?>
<?php //include_partial('type/assets') ?>


<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_id">
    <div class="fcell">
        <label><?php echo __('Id', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo $oiimages->getId(); ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_ref">
    <div class="fcell">
        <label><?php echo __('Ref', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo $oiimages->getRef(); ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_name">
    <div class="fcell">
        <label><?php echo __('Name', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo $oiimages->getName(); ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_description">
    <div class="fcell">
        <label><?php echo __('Description', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo nl2br($oiimages->getDescription()); ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_so">
    <div class="fcell">
        <label><?php echo __('Os', array(), 'messages'); ?></label>
        <div>
			&nbsp;<?php //echo $oiimages->getSo(); ?>
			<?php echo $oiimages->getOs(); ?>
		</div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_uuid">
    <div class="fcell">
        <label><?php echo __('Uuid', array(), 'messages'); ?></label>
        <div>
            &nbsp;<?php echo $oiimages->getUuid(); ?>
	</div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_created_at">
    <div class="fcell">
        <label><?php echo __('Created at', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo false !== strtotime($oiimages->getCreatedAt()) ? format_date($oiimages->getCreatedAt(), "f") : '&nbsp;' ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_partition_size">
    <div class="fcell">
        <label><?php echo __('Partition size', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo $oiimages->getPartitionSize(); ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_partition_type">
    <div class="fcell">
        <label><?php echo __('Partition type', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo $oiimages->getPartitionType(); ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_filesystem_size">
    <div class="fcell">
        <label><?php echo __('Filesystem size', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo $oiimages->getFilesystemSize(); ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_filesystem_type">
    <div class="fcell">
        <label><?php echo __('Filesystem type', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo $oiimages->getFilesystemType(); ?></div>
    </div>
</div>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_path">
    <div class="fcell">
        <label><?php echo __('Path', array(), 'messages'); ?></label>
        <div>&nbsp;<?php echo $oiimages->getPath(); ?></div>
    </div>
</div>           