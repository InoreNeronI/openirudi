<ul class="sf_admin_actions">
	<li class="sf_admin_action_save"><input type="submit" value="<?php echo __('Save',array(),'messages');?>" /></li>
        <?php if (file_exists(sfConfig::get('sf_root_dir').'/web/func/root/openirudi.iso')):?>
        	<li class="sf_admin_action_save"><a href="<?php echo url_for('@my_client_download_iso');?>"><?php echo __('Download Image',array(),'messages');?></a></li>
        <?php endif; ?>
		
</ul>