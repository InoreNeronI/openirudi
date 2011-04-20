        <td><?php echo strtoupper($driver->getString()) ?></td>
        <td><?php echo $driver->getName() ?></td>
        <td><?php echo $driver->getClassType() ?></td>
        <td><?php echo ($driver->getDate() !== null && $driver->getDate() !== '') ? format_date($driver->getDate(), "D") : '' ?></td>
        <td><?php echo link_to(strtoupper($driver->getType()), 'type/view?id='.$driver->getTypeId()); ?></td>
        <td>
			<?php //kam?>
			<?php /*echo link_to($driver->getVendor(), '@vendor_view?cod1='.$driver->getVendorId().'&cod2='.$driver->getTypeId());*/ ?>
			<?php echo link_to($driver->getVendor(), 'vendor/view?code='.$driver->getVendorId().'&type_id='.$driver->getTypeId()); ?>
		</td>
        <td>
		<?php $device=$driver->getDevice();?>
		<?php if(!empty($device)):?>
			<?php echo link_to($driver->getDevice(), 'device/view?id='.$driver->getDevice()->getId()); ?>
		<?php endif;?>
		</td>