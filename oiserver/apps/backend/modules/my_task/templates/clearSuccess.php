<?php use_helper('I18N', 'Date','DateForm') ?>
<?php include_partial('my_task/assets') ?>

<div id="sf_admin_container">
	<h1 style="float:left"><?php echo __('Confirm clear program/associate task', array(), 'messages') ?></h1>
	<div id="sf_admin_content">
		<form action="<?php echo url_for('@my_task_clear_confirm') ?>" method="post">	
		<!--
		<div style="clear:both;">
		 <?php //include_partial('program_actions',array('helper'=>$helper));?>
		</div>
		-->
		<div class="sf_admin_list">
		<table class="table_program_list">
			<tr>
				<th><?php echo __('Pc List selected');?></th>				
			</tr>
			<tr>
				<td>											
					<?php if(count($pc_list)>0):?>
						<?php foreach($pc_list as $i=>$pc):?>
							<input type="hidden" id="ids[]" name="ids[]" value="<?php echo $pc->getId();?>"/>	
							<?php echo $pc->getName().' ('.$pc->getIp().')'?><BR/>
						<?php endforeach?>
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