<?php $my_html=$data;?>
<?php $my_html=str_replace(' selected="selected"','',$my_html)?>
<?php $my_task_hour_filter=$sf_user->getAttribute('my_task_hour_filter');?>
<?php //if(isset($my_task_hour_filter['from'])):?>
	<?php $hour=0;?>
	<?php //if(!empty($my_task_hour_filter['from']['hour'])):?>
		<?php $hour=$my_task_hour_filter['from']['hour'];?>
		<?php $hour_doble=$hour;?>
		<?php if($hour_doble<10):?>
			<?php $s=(string) $hour_doble;?>
			<?php if(strlen($s)>0):?>
				<?php $s='0'.$s;?>
			<?php endif;?>
			<?php $hour_doble=$s;?>
		<?php endif;?>
	<?php //endif?>
	<?php $minute=0;?>
	<?php //if(!empty($my_task_hour_filter['from']['minute'])):?>
		<?php $minute=$my_task_hour_filter['from']['minute'];?>
		<?php $minute_doble=$minute;?>
		<?php if($minute_doble<10):?>
			<?php $s=(string) $minute_doble;?>
			<?php if(strlen($s)>0):?>
				<?php $s='0'.$s;?>
			<?php endif;?>
			<?php $minute_doble=$s;?>
		<?php endif;?>
	<?php //endif?>

	<?php $to_hour=0;?>
	<?php //if(!empty($my_task_hour_filter['to']['hour'])):?>
		<?php $to_hour=$my_task_hour_filter['to']['hour'];?>
		<?php $to_hour_doble=$to_hour;?>
		<?php if($to_hour_doble<10):?>
			<?php $s=(string) $to_hour_doble;?>
			<?php if(strlen($s)>0):?>
				<?php $s='0'.$s;?>
			<?php endif;?>
			<?php $to_hour_doble=$s;?>
		<?php endif;?>
	<?php //endif?>
	<?php $to_minute=0;?>
	<?php //if(!empty($my_task_hour_filter['to']['minute'])):?>
		<?php $to_minute=$my_task_hour_filter['to']['minute'];?>
		<?php $to_minute_doble=$to_minute;?>
		<?php if($to_minute_doble<10):?>
			<?php $s=(string) $to_minute_doble;?>
			<?php if(strlen($s)>0):?>
				<?php $s='0'.$s;?>
			<?php endif;?>
			<?php $to_minute_doble=$s;?>
		<?php endif;?>
	<?php //endif?>

	<?php $my_array=explode('<select',$my_html)?>
	<?php //echo print_r($my_array,1);exit();?>
	<?php $my_array[1]=str_replace('<option value="'.$hour.'">'.$hour_doble.'</option>','<option value="'.$hour.'" selected="selected">'.$hour_doble.'</option>',$my_array[1]);?>
	<?php $my_array[2]=str_replace('<option value="'.$minute.'">'.$minute_doble.'</option>','<option value="'.$minute.'" selected="selected">'.$minute_doble.'</option>',$my_array[2]);?>
	
	<?php $my_array[3]=str_replace('<option value="'.$to_hour.'">'.$to_hour_doble.'</option>','<option value="'.$to_hour.'" selected="selected">'.$to_hour_doble.'</option>',$my_array[3]);?>
	<?php $my_array[4]=str_replace('<option value="'.$to_minute.'">'.$to_minute_doble.'</option>','<option value="'.$to_minute.'" selected="selected">'.$to_minute_doble.'</option>',$my_array[4]);?>

	<?php $my_html=implode('<select',$my_array);?>
<?php //endif;?>
<?php echo $my_html;?>