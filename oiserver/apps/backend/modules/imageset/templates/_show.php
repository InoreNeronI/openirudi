<fieldset>
	<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_name">
		<div>
			<label><?php echo __('Name', array(), 'messages'); ?></label>
			<div><?php echo $imageset->getName(); ?></div>
		</div>
	</div>
	<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_select_images">
        <div>
     		<?php include_partial('imageset/select_images',array('imageset'=>$imageset,'form'=>'','configuration'=>$configuration,'helper'=>$helper,'mm'=>$mm,'pp'=>$pp,'size'=>$size)) ?>	
        </div>
    </div>
</fieldset>