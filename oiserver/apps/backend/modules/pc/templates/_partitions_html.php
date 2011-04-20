<?php if(count($partition_list)>0):?>
	<?php foreach($partition_list as $i=>$p):?>
	<table>
			<tr><td><b><?php echo __('serial');?></b></td><td><?php echo $p['serial']?></td></tr>
			
			<tr><td><b><?php echo __('partitionName');?></b><td><?php echo $p['partitionName']?></td></tr>
			
         	<tr><td><b><?php echo __('startSector');?></b><td><?php echo $p['startSector']?></td></tr>
            
			<tr><td><b><?php echo __('sectors');?></b><td><?php echo $p['sectors']?></td></tr>
            
			<tr><td><b><?php echo __('size');?></b><td><?php echo $p['size']?></td></tr>
  			
			<tr><td><b><?php echo __('partitionTypeId');?></b><td><?php echo $p['partitionTypeId']?></td></tr>
            
			<tr><td><b><?php echo __('partitionTypeName');?></b><td><?php echo $p['partitionTypeName']?></td></tr>
			
			<tr><td><b><?php echo __('fstype');?></b><td><?php echo $p['fstype']?></td></tr>
			
	</table>
	<?php endforeach;?>
<?php else:?>
	&nbsp;
<?php endif;?>