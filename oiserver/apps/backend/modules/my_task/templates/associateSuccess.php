<?php use_helper('I18N', 'Date','DateForm') ?>
<?php include_partial('my_task/assets') ?>
<?php //gaur komentatu checkbox_js?>
<?php //include_partial('checkbox_js');?>
<?php //gemini 2011-02-15 ?>
<?php include_partial('program_imageset_js');?>


<div id="sf_admin_container">
	<h1 style="float:left"><?php echo __('Associate Task', array(), 'messages') ?></h1>
	<div id="sf_admin_content">
		<form action="<?php echo url_for('@my_task_associate_save') ?>" method="post">	

		<!--
		<div style="clear:both;">
		 <?php //include_partial('program_actions',array('helper'=>$helper));?>
		</div>
		-->
		<div class="sf_admin_list">
		<?php include_partial('program_table',array('pc_list'=>$pc_list,'partition_list'=>$partition_list,'oiimages_assoc'=>$oiimages_assoc))?>


		<?php //gaur disk_assoc ?>
		<?php include_partial('select_imageset',array('pc_list'=>$pc_list,'imageset_assoc'=>$imageset_assoc,'disk_assoc'=>$disk_assoc,'is_when'=>false)) ?>
				
		</div>
		
					
		 <?php include_partial('associate_actions',array('helper'=>$helper));?>
		</form>
	</div>
</div>