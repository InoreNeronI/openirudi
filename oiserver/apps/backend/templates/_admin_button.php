<?php $current_module=$sf_request->getParameter('module');?>
<?php //$the_class='';?>
<?php if(in_array($current_module,array('trans_unit','catalogue','sfGuardUser','sfGuardGroup','sfGuardPermission'))):?>
	<?php //$the_class=' class="active"';?>
<?php endif;?>  
			  <?php if($sf_user->hasCredential('trans_unit_list')):?>
				 	<?php echo link_to('<span>'.__('Administration',array(),'messages').'</span>', '@trans_unit') ?>
				<?php elseif($sf_user->hasCredential('catalogue_list')):?>	
			 		<?php echo link_to('<span>'.__('Administration',array(),'messages').'</span>', '@catalogue') ?>

			  <?php elseif($sf_user->hasCredential('sf_guard_user_list')):?>	

					<?php echo link_to('<span>'.__('Administration',array(),'messages').'</span>', '@sf_guard_user') ?>

			  <?php elseif($sf_user->hasCredential('sf_guard_group_list')):?>	
					<?php echo link_to('<span>'.__('Administration',array(),'messages').'</span>', '@sf_guard_group') ?>

			   <?php elseif($sf_user->hasCredential('sf_guard_permission_list')):?>	

					<?php echo link_to('<span>'.__('Administration',array(),'messages').'</span>', '@sf_guard_permission') ?>
			  	
			  <?php endif;?>