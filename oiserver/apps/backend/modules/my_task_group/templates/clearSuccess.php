<?php use_helper('I18N', 'Date','DateForm') ?>
<?php include_partial('my_task/assets') ?>

<div id="sf_admin_container">
	<h1 style="float:left"><?php echo __('Confirm clear group program/associate group task', array(), 'messages') ?></h1>
	<div id="sf_admin_content">
		<form action="<?php echo url_for('@my_task_group_clear_confirm') ?>" method="post">	
		
		<div class="sf_admin_list">
		<table class="table_program_list">
			<tr>
				<th><?php echo __('Pcgroup selected');?></th>				
			</tr>
			<tr>
				<td>											
					<?php if(!empty($pcgroup)):?>
						<input type="hidden" id="ids[]" name="ids[]" value="<?php echo $pcgroup->getId();?>"/>	
						<?php echo $pcgroup->getName()?>				
					<?php else:?>
						&nbsp;
					<?php endif;?>
				</td>								
			</tr>
		</table>
		</div>
		
		 <?php include_partial('clear_actions',array('helper'=>$helper));?>
		</form>
	</div>
</div>