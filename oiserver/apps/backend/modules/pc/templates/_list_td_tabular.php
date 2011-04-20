<td class="sf_admin_text sf_admin_list_th_id">
  <?php //kam?>
  <?php //echo link_to($pc->getId(), 'pc_edit', $pc) ?>
   <?php echo $pc->getId(); ?>
</td>
<td class="sf_admin_text sf_admin_list_th_mac">
  <?php echo $pc->getMac() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_hddid">
  <?php echo $pc->getHddid() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_name">
  <?php echo $pc->getName() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_ip">
  <?php echo $pc->getIp() ?>
</td>
<!--
<td class="sf_admin_text sf_admin_list_th_netmask">
  <?php //echo $pc->getNetmask() ?>
</td>
<td class="sf_admin_text sf_admin_list_th_gateway">
  <?php //echo $pc->getGateway() ?>
</td>
-->

<td class="sf_admin_text sf_admin_list_th_oiimage">
  <?php //echo $pc->getOiimage() ?>  

  <?php $oiimage=$pc->getOiimage();?>
  <?php if(count($oiimage)>0):?>
	<?php include_partial('oiimage_html',array('oiimage'=>$oiimage));?>
  <?php else:?>
	&nbsp;
  <?php endif;?>	

</td>

<td class="sf_admin_text sf_admin_list_th_imageset">
  <?php echo $pc->getImagesetTabular();?>  
</td>
<!--
<td class="sf_admin_text sf_admin_list_th_date">
-->
  <?php //echo $pc->getDate() ?>
<!--
</td>
-->
<td class="sf_admin_foreignkey sf_admin_list_th_pcgroup_id">
  <?php echo $pc->getPcgroup() ?>
</td>