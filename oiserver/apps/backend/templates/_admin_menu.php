<?php $current_module=$sf_request->getParameter('module');?>
<?php if($sf_user->isAuthenticated()):?>	
	<?php $submenu_class=' class="active"';?>
    <?php if($sf_user->hasCredential(array('trans_unit_list','catalogue_list','sf_guard_user_list','sf_guard_group_list','sf_guard_permission_list'),false)):?>
		<?php if(in_array($current_module,sfConfig::get('app_menu_admin_bai'))):?>
			<div id="tab3" class="tabs_admin">
					<ul>
					  <?php if($sf_user->hasCredential('trans_unit_list')):?>
					  <li<?php echo $current_module=='trans_unit' ? $submenu_class : '' ?>>
						<?php echo link_to('<span>'.__('Translate',array(),'messages').'</span>', '@trans_unit') ?>
					  </li>
					  <?php endif;?>
					  <?php if($sf_user->hasCredential('catalogue_list')):?>	
					  <li<?php echo $current_module=='catalogue' ? $submenu_class : '' ?>>
						<?php echo link_to('<span>'.__('Catalogue',array(),'messages').'</span>', '@catalogue') ?>
					  </li>
					  <?php endif;?>
					  <?php if($sf_user->hasCredential('sf_guard_user_list')):?>						 
					 <li<?php echo $current_module=='sfGuardUser' ? $submenu_class : '' ?>>
						<?php echo link_to('<span>'.__('Users',array(),'messages').'</span>', '@sf_guard_user') ?>
					  </li>
					  <?php endif;?>
					  <?php if($sf_user->hasCredential('sf_guard_group_list')):?>						 
					  <li<?php echo $current_module=='sfGuardGroup' ? $submenu_class : '' ?>>
						<?php echo link_to('<span>'.__('Groups',array(),'messages').'</span>', '@sf_guard_group') ?>
					  </li>
					  <?php endif;?>
					  <?php if($sf_user->hasCredential('sf_guard_permission_list')):?>
					  <li<?php echo $current_module=='sfGuardPermission' ? $submenu_class : '' ?>>
						<?php echo link_to('<span>'.__('Permissions',array(),'messages').'</span>', '@sf_guard_permission') ?>
					  </li>		
					  <?php endif;?>					  								
					</ul>
			</div>
		<?php endif;?>
	<?php endif;?>	
<?php endif;?>