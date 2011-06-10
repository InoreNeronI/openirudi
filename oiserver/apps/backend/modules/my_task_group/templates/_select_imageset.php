		<input type="hidden" name="imageset_pcgroup_id" value="<?php echo $pcgroup->getId()?>"/>
		<table>
			
			<tr><th><?php echo __('Imageset');?></th>
			<?php //gaur ?>
			<th><?php echo __('Disk');?></th>
			
			<th><?php echo __('Is boot');?></th>
			<?php if($is_when):?>
				<th><?php echo __('When');?></th>
			<?php endif;?>
			</tr>
			<tr>
				<td><input type="checkbox" id="is_imageset" name="is_imageset" value="1"/>
				<?php echo __('Is imageset');?>
				<?php echo select_tag('imageset_id', options_for_select($imageset_assoc));?>
				</td>
			
			<?php //gaur ?>
			<td>			    
				<?php echo select_tag('disk', options_for_select($disk_assoc));?>
			</td>
		
			<td><input type="checkbox" id="is_boot" name="is_boot" value="1"/></td>
			
			<?php if($is_when):?>
			<td>
				<?php echo input_date_tag('day','','rich=true');?>
				<?php echo select_time_tag('hour', '');?>
			</td>
			<?php endif;?>
		</tr>
		</table>