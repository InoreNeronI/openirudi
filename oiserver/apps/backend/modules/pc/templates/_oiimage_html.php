<?php foreach($oiimage as $i=>$row):?>
	<!--<b><?php //echo __('Partition');?>:</b>-->
	<?php echo $row['partition'];?><BR/>
	<!--<b><?php //echo __('Oiimage');?>:</b>-->
	<?php echo $row['oiimages'];?><BR/>
	<!--<b><?php //echo __('Date');?>:</b>-->
	<?php echo $row['date'];?><BR/>
	<BR/>			
<?php endforeach;?>
