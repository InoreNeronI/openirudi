<?php use_helper('I18N', 'Date','DateForm') ?>
<?php include_partial('my_task/assets') ?>
<?php include_partial('program_imageset_js');?>


<div id="sf_admin_container">
	<h1 style="float:left"><?php echo __('Clone group now', array(), 'messages') ?></h1>
	<div id="sf_admin_content">
		<form action="<?php echo url_for('@my_task_group_now_save') ?>" method="post">	

		<div class="sf_admin_list">
		<?php include_partial('program_table',array('pcgroup'=>$pcgroup,'group_partition_list'=>$group_partition_list,'oiimages_assoc'=>$oiimages_assoc))?>		
		
		<?php include_partial('select_imageset',array('pcgroup'=>$pcgroup,'imageset_assoc'=>$imageset_assoc,'disk_assoc'=>$disk_assoc,'is_when'=>false)) ?>
		
		</div>
		

		 <?php include_partial('now_actions',array('helper'=>$helper));?>
		</form>
	</div>
</div>