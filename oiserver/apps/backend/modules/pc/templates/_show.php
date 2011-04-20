<table>
  <tbody>
    <tr>
       <td><b><?php echo __('Id',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_id">
  <?php //echo link_to($pc->getId(), 'pc_edit', $pc) ?>
  <?php echo $pc->getId();?>
</td>
    <tr>
       <td><b><?php echo __('Mac',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_mac">
  <?php echo $pc->getMac() ?>
</td>
    <tr>
       <td><b><?php echo __('Hddid',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_hddid">
  <?php echo $pc->getHddid() ?>
</td>
    <tr>
       <td><b><?php echo __('Name',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_name">
  <?php echo $pc->getName() ?>
</td>
    <tr>
       <td><b><?php echo __('Ip',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_ip">
  <?php echo $pc->getIp() ?>
</b></td>
    <tr>
       <td><b><?php echo __('Netmask',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_netmask">
  <?php echo $pc->getNetmask() ?>
</td>
    <tr>
       <td><b><?php echo __('Gateway',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_gateway">
  <?php echo $pc->getGateway() ?>
</td>
    <tr>
       <td><b><?php echo __('Dns1',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_dns1">
  <?php echo $pc->getDns1() ?>
</td>    
	<tr>
	   <td><b><?php echo __('Dns2',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_dns2">
  <?php echo $pc->getDns2() ?>
</td>
    <tr>
       <td><b><?php echo __('Pcgroup',array(),'messages');?>:</b></td>
<td class="sf_admin_foreignkey sf_admin_list_th_pcgroup_id">
  <?php echo $pc->getPcgroupId() ?>
</td>
    <tr>
       <td><b><?php echo __('Partitions',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_partitions">
  <?php //echo nl2br($pc->getPartitions()); ?>
 <?php include_partial('partitions_html',array('partition_list'=>$pc->get_partition_list()))?>	
</td>
    </tr>
	<tr>
       <td><b><?php echo __('Oiimage',array(),'messages');?>:</b></td>
<td class="sf_admin_foreignkey sf_admin_list_th_oiimage">
  <?php //echo $pc->getOiimage() ?>
  <?php $oiimage=$pc->getOiimage();?>
  <?php if(count($oiimage)>0):?>
	<?php include_partial('oiimage_html',array('oiimage'=>$oiimage));?>
  <?php else:?>
	&nbsp;
  <?php endif;?>
</td>
    <tr>
       <td><b><?php echo __('Date',array(),'messages');?>:</b></td>
<td class="sf_admin_text sf_admin_list_th_date">
  <?php echo nl2br($pc->getDate()); ?>
</td>
    </tr>
  </tbody>
</table>
