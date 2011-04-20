<table class="table_program_list">			
			
						<tr>
							<th><?php echo __('Pc List selected');?></th>
							<th><?php echo __('Partition');?></th>				
							<th><?php echo __('Oiimage to clone');?></th>
						</tr>											
						<?php if(count($pc_list)>0):?>
							<?php foreach($pc_list as $i=>$pc):?>
														
								<?php $my_partition_list=$partition_list[$pc->getId()];?>							
								<?php if(!empty($my_partition_list)):?>								
									<?php foreach($my_partition_list as $a=>$p):?>
										<tr>	
											<td><?php echo $pc->getName().' ('.$pc->get_my_ident().')'?></td>
											<td><?php echo $p['partitionName'].' ('.$p['size'].')'?></td>
											<?php //gemini 2011-02-15 class='my_style'?>
											<td><?php echo select_tag('oiimages_id['.$pc->getId().'-'.$p['partitionName'].']', options_for_select($oiimages_assoc),array('class'=>'my_style'));?></td>
										</tr>
									<?php endforeach;?>
								<?php else:?>	
									<tr>
										<td><?php echo $pc->getName().' ('.$pc->getIp().')'?></td>
										<td>&nbsp;</td>
										<td><?php echo select_tag('oiimages_id['.$pc->getId().'-]', options_for_select($oiimages_assoc));?></td>
										<?php //gemini 2011-02-15 class='my_style'?>
										<td><?php echo select_tag('oiimages_id['.$pc->getId().'-]', options_for_select($oiimages_assoc),array('class'=>'my_style'));?></td>
									</tr>
								<?php endif;?>								
							<?php endforeach;?>							
						<?php endif;?>																														
					
				
			</tr>
</table>