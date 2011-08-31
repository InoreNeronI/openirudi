<table class="one-column-emphasis" >
	<colgroup>
    	<col class="oce-first" />
    </colgroup>
    <!--<thead></thead>-->
    <tbody>
        <tr>
            <th style="" colspan="2"><?php echo __('Machine') ?></th>
        </tr><tr>
            <td width="30%"><?php echo __('Motherboard') ?></td>
            <td><?=$hw->motherBoard?></td>
        </tr><tr>
            <td><?php echo __('Processor') ?></td>
            <td><?=$hw->cpuDescription?></td>
        </tr><tr>
            <th style="" colspan="2"><?php echo __('Memory') ?></th>
        </tr><tr>
            <td><?php echo __('Size') ?></td>
            <td><?php echo $hw->ramType; ?></td>
        </tr><tr>
            <th style=";"><?php echo __('Network') ?></th>
            <th><?php
                echo __('Interface').': '.__('IP').' / '.__('Subnet Mask'); ?>
            </th>
        </tr><?php
            foreach($hw->network->ipAddress as $address) {
                if (empty($address)) { ?>
                    <tr><td colspan="2"><?php echo __('No network device detected') ?></td></tr><?php
                } else { ?>
                    <tr><td><?php
                    echo "{$address['device']}:";
                    
                    ?>
                    </td><td><?php
                    echo "{$address['ip']} / {$address['netmask']}"; ?>
                    </td></tr><?php
                }
            } ?>
        <tr>
            <th style="" colspan="2"><?php echo __('Hardware Devices'); ?></th>
        </tr>
        <tr>
            <td><?php echo __('Found PCI Device-Identification Strings'); ?></td>
            <td><?php
            $i = 1;
            foreach($hw->lspci as $pciDevice) {
                $vid = $pciDevice['vendor'];
                $pid = $pciDevice['device'];
                if ($pciDevice['subsys'] != '00000000')   $subsys = $pciDevice['subsys'];
                if ($pciDevice['rev'] != '00')   $rev = $pciDevice['rev'];
                    if (isset($subsys) && isset($rev))
                        echo strtoupper('pci\ven_'.$vid.'&dev_'.$pid.'&subsys_'.$subsys.'&rev_'.$rev);
                    elseif (isset($subsys))
                        echo strtoupper('pci\ven_'.$vid.'&dev_'.$pid.'&subsys_'.$subsys);
                    else
                        echo strtoupper('pci\ven_'.$vid.'&dev_'.$pid);
                unset($vid, $pid);
                if (isset($subsys)) unset($subsys);
                if (isset($rev))    unset($rev);
                if ($i < count($hw->lspci)) echo ', ';
                $i++;
            } ?>
            </td>
        </tr>
    </tbody>
</table>