<?php echo use_helper('I18N'); ?>
<?php include_partial('boxy_js'); ?>

<?php echo use_helper('Javascript'); ?>
<?php echo use_helper('Form'); ?>


    <?php echo '** '.link_to('[PROBA]', 'config/proba'); ?>

<div class="eventos">
   
    <fieldset class="config">
        <legend><?php echo __('oiClient in your disk'); ?></legend>
        <div class="celda">
            <?php include_partial('oipartition', array('hw' => $hw, 'listOisystems' => $listOisystems)); ?>
        </div>
    </fieldset>

    <fieldset class="config">
        <legend><?php echo __('Change IP Adrress'); ?></legend>
        <div class="celda">
            <?php
            echo form_tag('/config/changeIpAddress', array('name' => 'changeIpAddress' ,'class'=>'submitMove'));

            echo input_hidden_tag('ipAddress[device]', $hw->network->ipAddress['main']['device']); ?>
            <table  width="100%">
                <tr>
                    <th><?php echo __('Device') . ':'; ?></th>
                    <th><?php echo __('Method of assignment') . ':'; ?></th>
                </tr>
                <tr>
                    <td align="center"><?php echo $hw->network->ipAddress['main']['device']; ?>
                    </td><td>
                        <?php echo radiobutton_tag("ipAddress[dhcp]", 'true', $hw->network->ipAddress['main']['dhcp']) . ' ' . __('Dynamic IP Address (DHCP)'); ?><br />
                        <?php echo radiobutton_tag("ipAddress[dhcp]", 'false', !$hw->network->ipAddress['main']['dhcp']) . ' ' . __('Static'); ?>

                        <?php echo __("IP Address") . ':&nbsp;&nbsp;'; ?>
                        <?php echo input_tag("ipAddress[ip]", "{$hw->network->ipAddress['main']['ip']}", 'maxlenght=15 size=15 class="linea1"'); ?>
                        <?php echo __("Netmask") . ':&nbsp;&nbsp;'; ?>
                        <?php echo input_tag("ipAddress[netmask]", "{$hw->network->ipAddress['main']['netmask']}", 'maxlenght=15 size=15 class="linea1"'); ?>
                        <?php echo __("Default gateway") . ':&nbsp;&nbsp;'; ?>
                        <?php echo input_tag('ipAddress[gateway]', "{$hw->network->route['default']['gateway']}", 'maxlenght=15 size=15 class="linea1"'); ?>
                        <?php echo __("Name server") . ':&nbsp;&nbsp;'; ?>
                        <?php echo input_tag('ipAddress[dns_server]', "" . implode(', ', $hw->network->dns), 'maxlenght=15 size=15 class="linea1"'); ?>
                    </td>
                </tr>
            </table>

            <?php echo submit_tag(__('Save'), array('id' => 'change_ip')); ?>
            <?php echo button_to(__('Cancel'), 'image/index'); ?>
                        <div class="spacer">&nbsp;</div>
                        </form>
                    </div>
                </fieldset>

                <fieldset class="config">
                    <legend><?php echo __('Change Host Name'); ?></legend>
                    <div class="celda">
            <? echo form_tag('/config/hostname', array('name' => 'hostname','class'=>'submitNoMove')); ?>
            <?php echo input_tag("hostname", "{$hw->network->hostname}", 'maxlenght=15 size=15 class="linea1"'); ?>
            <?php echo submit_tag(__('Save'), array('id' => 'change_hostname')); ?>
                        </form>
                    </div>
                </fieldset>
                <br>


                <fieldset class="config">
                    <legend><?php echo __('OpenIrudi Server IP address'); ?></legend>
                    <div class="celda">
                        <?php echo form_tag('/config/server', array('name' => 'server','class'=>'submitNoMove')); ?>

                            <?php echo __("IP Address") . ': ' . input_tag("serverAddress", ImageServerOppClass::address(), 'maxlenght=15 size=15 class="linea1"'); ?>
                            <?php echo submit_tag(__('Save'), array('id' => 'change_server')); ?>
                            <?php echo button_to(__('Cancel'), 'config/index'); ?>
                        </form>
                    </div>
                </fieldset>
                <br />
                
    <div class="spacer">&nbsp;</div>
</div>
