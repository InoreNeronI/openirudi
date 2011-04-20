<?php use_helper('I18N', 'Date') ?>
<?php include_partial('sfGuardPermission/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Show Permission "%%name%%"', array('%%name%%' => $sf_guard_permission->getName()), 'messages') ?></h1>

  <?php include_partial('sfGuardPermission/flashes') ?>

  <div id="sf_admin_header">
  </div>

  <div id="sf_admin_content">
	
	<div class="sf_admin_form">
  		<fieldset id="sf_fieldset_none">
  			<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_name">
        		<div>
      				<label for="sf_guard_permission_name"><?php echo __('Name',array(),'messages') ?></label>
      				<?php include_partial('global/show_value',array('value'=>$sf_guard_permission->getName()))?>
          		</div>
 	 		</div>
            
			<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_description">
				<div>
      				<label for="sf_guard_permission_description"><?php echo __('Description',array(),'messages') ?></label>
      				<div class="div_permission_description"><?php echo nl2br($sf_guard_permission->getDescription());?></div>
          		</div>
  			</div>
            
			<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_sf_guard_group_permission_list">
        		<div>
      				<label for="sf_guard_permission_sf_guard_group_permission_list"><?php echo __('Groups',array(),'messages') ?></label>
					<div class="div_permission_group_list">
						<?php echo implode('<BR/>',$sf_guard_permission->get_group_list());?>
					</div>
				</div>
  			</div>
      </fieldset>
	  <?php include_partial('sfGuardPermission/show_actions', array('sf_guard_permission' => $sf_guard_permission, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    
  </div>
</div>
