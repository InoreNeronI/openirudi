<table class="table_program_list">			
			
						<tr>
							<th><?php echo __('Group selected');?></th>
							<th><?php echo __('Partition');?></th>				
							<th><?php echo __('Oiimage to clone');?></th>
						</tr>											
						<?php //if(count($pc_list)>0):?>
							<?php //foreach($pc_list as $i=>$pc):?>
														
								<?php if(!empty($group_partition_list)):?>								
									<?php foreach($group_partition_list as $a=>$partitionName):?>
										<tr>	
											<td><?php echo $pcgroup->getName();?></td>
											<td><?php echo $partitionName;?></td>
											<?php //gemini 2011-02-15 class='my_style'?>
											<td><?php echo select_tag('oiimages_id['.$pcgroup->getId().'-'.$partitionName.']', options_for_select($oiimages_assoc),array('class'=>'my_style'));?></td>
										</tr>
									<?php endforeach;?>
								<?php else:?>	
									<tr>
										<td><?php echo $pcgroup->getName();?></td>
										<td>&nbsp;</td>
										<td><?php echo select_tag('oiimages_id['.$pcgroup->getId().'-]', options_for_select($oiimages_assoc));?></td>
										<?php //gemini 2011-02-15 class='my_style'?>
										<td><?php echo select_tag('oiimages_id['.$pcgroup->getId().'-]', options_for_select($oiimages_assoc),array('class'=>'my_style'));?></td>
									</tr>
								<?php endif;?>								
							<?php //endforeach;?>							
						<?php //endif;?>																														
					
				
			</tr>
</table>