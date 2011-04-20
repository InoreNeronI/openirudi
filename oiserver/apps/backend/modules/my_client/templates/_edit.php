<?php use_helper('Object')?>
<?php include_partial('my_client/flashes') ?>

<div id="sf_admin_content">
	<div class="sf_admin_form">
  	    <form method="post" action="<?php echo url_for('@my_client_save')?>">
			<input type="hidden" id="my_client_id" name="my_client[id]" value="<?php echo $my_client['id']?>"/>
			<fieldset id="sf_fieldset_none">				
				<?php $is_error='';?>
				<?php if($my_error['fields']['server']['error']):?>	
					<?php $is_error=' errors';?>
				<?php endif;?>
				<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_server<?php echo $is_error;?>">
        			<?php include_partial('my_client/my_error_msg',array('error_row'=>$my_error['fields']['server']))?>
					<div>
      					<label for="my_client_server"><?php echo __('Server',array(),'messages');?></label>
      					<?php $server_selected_ip=''?>
						<?php if(isset($my_client['server'])):?>
							<?php $server_selected_ip=$my_client['server']?>
						<?php endif;?>
						<?php echo select_tag('my_client[server]', options_for_select($server_list,$server_selected_ip)) ?>
          			</div>
  				</div>
				<?php $is_error='';?>
				<?php if($my_error['fields']['type']['error']):?>	
					<?php $is_error=' errors';?>
				<?php endif;?>
				<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_type<?php echo $is_error;?>">
        			<?php include_partial('my_client/my_error_msg',array('error_row'=>$my_error['fields']['type']))?>					
					<div>
      					<label for="my_client_type"><?php echo __('Type',array(),'messages');?></label>
      					<?php $selected_static='';?>
						<?php $selected_dhcp='';?>
						<?php if(isset($my_client['type']) && !empty($my_client['type']) && $my_client['type']=='dhcp'):?>
							<?php $selected_dhcp=' checked="checked"';?>
						<?php else:?>
							<?php $selected_static=' checked="checked"';?>
						<?php endif;?>												
						<input type="radio" id="my_client_static" name="my_client[type]" value="static"<?php echo $selected_static?>/>
						<?php echo __('Static',array(),'messages');?>																		
						<input type="radio" id="my_client_dhcp" name="my_client[type]" value="dhcp"<?php echo $selected_dhcp?>/>
						<?php echo __('Dhcp',array(),'messages');?>						
          			</div>
  				</div>
				<?php $is_error='';?>
				<?php if($my_error['fields']['ip']['error']):?>	
					<?php $is_error=' errors';?>
				<?php endif;?>
				<div id="div_ip" class="sf_admin_form_row sf_admin_text sf_admin_form_field_ip<?php echo $is_error;?>">
					<?php include_partial('my_client/my_error_msg',array('error_row'=>$my_error['fields']['ip']))?>
					
        			<div>
      					<label for="my_client_ip"><?php echo __('Ip',array(),'messages');?></label>
      					<input type="text" id="my_client_ip" name="my_client[ip]" value="<?php echo $my_client['ip']?>"/>
          			</div>
  				</div>
				<?php $is_error='';?>
				<?php if($my_error['fields']['netmask']['error']):?>	
					<?php $is_error=' errors';?>
				<?php endif;?>
				<div id="div_netmask" class="sf_admin_form_row sf_admin_text sf_admin_form_field_netmask<?php echo $is_error;?>">
        			<?php include_partial('my_client/my_error_msg',array('error_row'=>$my_error['fields']['netmask']))?>
					
					<div>
      					<label for="my_client_netmask"><?php echo __('Netmask',array(),'messages');?></label>
      					<input type="text" id="my_client_netmask" name="my_client[netmask]" value="<?php echo $my_client['netmask']?>"/>
          			</div>
  				</div>
				<?php $is_error='';?>
				<?php if($my_error['fields']['gateway']['error']):?>	
					<?php $is_error=' errors';?>
				<?php endif;?>
				<div id="div_gateway" class="sf_admin_form_row sf_admin_text sf_admin_form_field_gateway<?php echo $is_error;?>">
        			<?php include_partial('my_client/my_error_msg',array('error_row'=>$my_error['fields']['gateway']))?>
					
					<div>
      					<label for="my_client_gateway"><?php echo __('Gateway',array(),'messages');?></label>
      					<input type="text" id="my_client_gateway" name="my_client[gateway]" value="<?php echo $my_client['gateway']?>"/>
          			</div>
  				</div>
				<?php $is_error='';?>
				<?php if($my_error['fields']['dns1']['error']):?>	
					<?php $is_error=' errors';?>
				<?php endif;?>
				<div id="div_dns1" class="sf_admin_form_row sf_admin_text sf_admin_form_field_dns1<?php echo $is_error;?>">
        			<?php include_partial('my_client/my_error_msg',array('error_row'=>$my_error['fields']['dns1']))?>
					
					<div>
      					<label for="my_client_dns1"><?php echo __('Dns1',array(),'messages');?></label>
      					<input type="text" id="my_client_dns1" name="my_client[dns1]" value="<?php echo $my_client['dns1']?>"/>
          			</div>
  				</div>
				<?php $is_error='';?>
				<?php if($my_error['fields']['dns2']['error']):?>	
					<?php $is_error=' errors';?>
				<?php endif;?>
				<div id="div_dns2" class="sf_admin_form_row sf_admin_text sf_admin_form_field_dns2<?php echo $is_error;?>">
					<?php include_partial('my_client/my_error_msg',array('error_row'=>$my_error['fields']['dns2']))?>
					
        			<div>
      					<label for="my_client_dns2"><?php echo __('Dns2',array(),'messages');?></label>
      					<input type="text" id="my_client_dns2" name="my_client[dns2]" value="<?php echo $my_client['dns2']?>"/>
          			</div>
  				</div>
				<?php $is_error='';?>
				<?php if($my_error['fields']['user']['error']):?>	
					<?php $is_error=' errors';?>
				<?php endif;?>
				<div id="div_user" class="sf_admin_form_row sf_admin_text sf_admin_form_field_user<?php echo $is_error;?>">
					<?php include_partial('my_client/my_error_msg',array('error_row'=>$my_error['fields']['user']))?>
					
        			<div>
      					<label for="my_client_user"><?php echo __('User',array(),'messages');?></label>
      					<input type="text" id="my_client_user" name="my_client[user]" value="<?php echo $my_client['user']?>"/>
          			</div>
  				</div>
				<?php $is_error='';?>
				<?php if($my_error['fields']['password']['error']):?>	
					<?php $is_error=' errors';?>
				<?php endif;?>
				<div id="div_password" class="sf_admin_form_row sf_admin_text sf_admin_form_field_password<?php echo $is_error;?>">
        			<?php include_partial('my_client/my_error_msg',array('error_row'=>$my_error['fields']['password']))?>
					
					<div>
      					<label for="my_client_password"><?php echo __('Password',array(),'messages');?></label>
      					<input type="password" id="my_client_password" name="my_client[password]" value="<?php echo $my_client['password']?>"/>
          			</div>
  				</div>
			</fieldset>			
      </div>
</div>