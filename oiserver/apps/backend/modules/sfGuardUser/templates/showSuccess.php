<?php use_helper('I18N', 'Date') ?>
<?php include_partial('sfGuardUser/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Show User "%%username%%"', array('%%username%%' => $sf_guard_user->getUsername()), 'messages') ?></h1>

  <?php include_partial('sfGuardUser/flashes') ?>

  <div id="sf_admin_header">
  </div>

  <div id="sf_admin_content">
  <div class="sf_admin_form">	   
	<fieldset id="sf_fieldset_none">
		<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_username">
        	<div>
      			<label for="sf_guard_user_username"><?php echo __('Username',array(),'messages');?></label>
     			<div><?php include_partial('global/show_value',array('value'=>$sf_guard_user->getUsername()))?></div>
          </div>
  		</div>
    </fieldset>
    
	<fieldset id="sf_fieldset_permissions_and_groups">
      	<h2><?php echo __('Permissions and groups',array(),'messages');?></h2>
  		
		<div class="sf_admin_form_row sf_admin_boolean sf_admin_form_field_is_active">
        	<div>
      			<label for="sf_guard_user_is_active"><?php echo __('Is active',array(),'messages');?></label>
      			<div><?php echo image_tag($sf_guard_user->getIsActiveImg());?></div>
         	</div>
  		</div>

        <div class="sf_admin_form_row sf_admin_boolean sf_admin_form_field_is_super_admin">
        	<div>
      			<label for="sf_guard_user_is_super_admin"><?php echo __('Is super admin',array(),'messages');?></label>
      			<div><?php echo image_tag($sf_guard_user->getIsSuperAdminImg());?></div>
          </div>
		</div>
            
		<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_sf_guard_user_group_list">
        	<div>
      			<label for="sf_guard_user_sf_guard_user_group_list"><?php echo __('Groups',array(),'messages');?></label>
      			<div class="div_user_group_list">
					<?php echo implode('<BR/>',$sf_guard_user->get_group_list());?>	
				</div>
          	</div>
  		</div>

        <div class="sf_admin_form_row sf_admin_text sf_admin_form_field_sf_guard_user_permission_list">
        	<div>
      			<label for="sf_guard_user_sf_guard_user_permission_list"><?php echo __('Permissions',array(),'messages');?></label>
      			<div class="div_user_permission_list">
					<?php echo implode('<BR/>',$sf_guard_user->get_permission_list());?>					
				</div>
          	</div>
  		</div>
  	</fieldset>	
  	<?php include_partial('sfGuardUser/show_actions', array('sf_guard_user' => $sf_guard_user, 'helper' => $helper)) ?>
  </div>
  </div>

  <div id="sf_admin_footer">
    
  </div>
</div>
