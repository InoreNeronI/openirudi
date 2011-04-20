    <td><?php echo $device->getCode() ?></td>
    <td><?php echo $device->getName() ?></td>
    <td>
		<?php //echo link_to($device->getVendor(), '@vendor_view?cod1='.$device->getVendorId().'&cod2='.$device->getTypeId()); ?>
		<?php echo link_to($device->getVendor(), 'vendor/view?code='.$device->getVendorId().'&type_id='.$device->getTypeId()); ?>
	</td>
    <td><?php echo link_to(strtoupper($device->getType()), 'type/view?id='.$device->getTypeId()); ?></td>

