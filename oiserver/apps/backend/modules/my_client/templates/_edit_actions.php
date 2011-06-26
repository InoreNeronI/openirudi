<ul class="sf_admin_actions">
	<li class="sf_admin_action_save"><input type="submit" value="<?php echo __('Save',array(),'messages');?>" /></li>
        <?php if (file_exists(sfConfig::get('sf_root_dir').'/web/func/root/openirudi.iso')):?>
        	<li class="sf_admin_action_save"><a href="<?php echo url_for('@my_client_download_iso');?>"><?php echo __('Download Image',array(),'messages');?></a></li>
        <?php else: ?>
                <li class="sf_admin_action_save"><?php echo _("You have not created oiclient yet.Set oiclient's password and click \"save\" to do it."); ?>
        <?php endif; ?>
		
</ul>