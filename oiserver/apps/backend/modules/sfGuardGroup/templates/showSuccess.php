<?php use_helper('I18N', 'Date') ?>
<?php include_partial('sfGuardGroup/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Show Group "%%name%%"', array('%%name%%' => $sf_guard_group->getName()), 'messages') ?></h1>

  <?php include_partial('sfGuardGroup/flashes') ?>

  <div id="sf_admin_header">
  </div>

  <div id="sf_admin_content">
	<div class="sf_admin_form">
    	<fieldset id="sf_fieldset_none">
			<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_name">
        		<div>
      				<label for="sf_guard_group_name"><?php echo __('Name',array(),'messages');?></label>
     				<div><?php include_partial('global/show_value',array('value'=>$sf_guard_group->getName()));?></div>
          		</div>
  			</div>
            
			<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_description">
        		<div>
					<label for="sf_guard_group_description"><?php echo __('Description',array(),'messages');?></label>
          			<div class="div_group_description"><?php echo nl2br($sf_guard_group->getDescription());?></div>
				</div>
  			</div>
            
			<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_sf_guard_group_permission_list">
        		<div>
      				<label for="sf_guard_group_sf_guard_group_permission_list"><?php echo __('Permissions',array(),'messages');?></label>
					<div class="div_group_permission_list">
						<?php //echo implode('<BR/>',$sf_guard_group->get_permission_list()->getRawValue());?>
						<?php echo implode('<BR/>',$sf_guard_group->get_permission_list());?>
					</div>
      			</div>
  			</div>
      </fieldset>
	  <?php include_partial('sfGuardGroup/show_actions', array('sf_guard_group' => $sf_guard_group, 'helper' => $helper)) ?>
	 </div>

  <div id="sf_admin_footer">
    
  </div>
</div>
