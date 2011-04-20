<?php use_helper('I18N') ?>
<?php use_stylesheet('/sfPropelPlugin/css/global.css', 'first') ?>
<?php use_stylesheet('/sfPropelPlugin/css/default.css', 'first') ?>

<div id="sf_admin_container">
  <h1 style="padding-left:1%"><?php echo __('%%dev_t%% Devices database upgrade result', array('%%dev_t%%' => $type), 'messages'); ?>:</h1>

  <div id="sf_admin_content"><?php
    if (empty($hook['new_v']))  unset($hook['new_v']);
    $c_new_v = $hook['c_new_v'];
    if (empty($hook['updated_v']))  unset($hook['updated_v']);
    if (empty($hook['updated_old_v']))  unset($hook['updated_old_v']);
    $c_updated_v = $hook['c_updated_v'];

    if (empty($hook['new_d']))  unset($hook['new_d']);
    $c_new_d = $hook['c_new_d'];
    if (empty($hook['updated_d']))  unset($hook['updated_d']);
    if (empty($hook['updated_old_d']))  unset($hook['updated_old_d']);
    $c_updated_d = $hook['c_updated_d'];

    if (empty($hook['new_s']))  unset($hook['new_s']);
    $c_new_s = $hook['c_new_s'];
    if (empty($hook['updated_s']))  unset($hook['updated_s']);
    if (empty($hook['updated_old_s']))  unset($hook['updated_old_s']);
    $c_updated_s = $hook['c_updated_s'];
    
    $type_id = $hook['type_id'];
    $time = explode('.', $hook['time'] / 60);
    $mins = $time[0];
    $secs = round(($hook['time'] - ($time[0] * 60)));
    
    unset($hook['c_new_v'], $hook['c_updated_v'], $hook['c_new_d'], $hook['c_updated_d'], $hook['c_new_s'], $hook['c_updated_s'], $hook['type_id'], $hook['time']);

    if (empty($hook)) { ?>
        <div class="sf_admin_list">
            <p style="padding-left:5%"><?php echo __('Database was already upgraded, nothing to do.', array(), 'messages'); ?></p>
        </div><?php
    } else { ?>
        <div class="sf_admin_list">
            <table cellspacing="0">
                <thead><tr><th><?php
                    echo __('Processing time: %%min%% minutes and %%sec%% seconds', array('%%min%%' => $mins, '%%sec%%' => $secs), 'messages'); ?>
                </th></tr></thead>
                <tbody><?php
                if ($c_new_v == 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%new_v%% new Vendor has been added', array('%%new_v%%' => $c_new_v), 'messages'); ?>
                    </td></tr><?php
                } elseif ($c_new_v > 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%new_v%% new Vendors has been added', array('%%new_v%%' => $c_new_v), 'messages'); ?>
                    </td></tr><?php
                }
                if ($c_updated_v == 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%updated_v%% Vendor has been updated', array('%%updated_v%%' => $c_updated_v), 'messages'); ?>
                    </td></tr><?php
                } elseif ($c_updated_v > 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%updated_v%% Vendors has been updated', array('%%updated_v%%' => $c_updated_v), 'messages'); ?>
                    </td></tr><?php
                }
                if ($c_new_d == 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%new_d%% new Device has been added', array('%%new_d%%' => $c_new_d), 'messages'); ?>
                    </td></tr><?php
                } elseif ($c_new_d > 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%new_d%% new Devices has been added', array('%%new_d%%' => $c_new_d), 'messages'); ?>
                    </td></tr><?php
                }
                if ($c_updated_d == 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%updated_d%% Device has been updated', array('%%updated_d%%' => $c_updated_d), 'messages'); ?>
                    </td></tr><?php
                } elseif ($c_updated_d > 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%updated_d%% Devices has been updated', array('%%updated_d%%' => $c_updated_d), 'messages'); ?>
                    </td></tr><?php
                }
                if ($c_new_s == 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%new_s%% new Subsys has been added', array('%%new_s%%' => $c_new_s), 'messages'); ?>
                    </td></tr><?php
                } elseif ($c_new_s > 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%new_s%% new Subsyses has been added', array('%%new_s%%' => $c_new_s), 'messages'); ?>
                    </td></tr><?php
                }
                if ($c_updated_s == 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%updated_s%% Subsys has been updated', array('%%updated_s%%' => $c_updated_s), 'messages'); ?>
                    </td></tr><?php
                } elseif ($c_updated_s > 1) { ?>
                    <tr class="sf_admin_row odd"><td><?php
                    echo __('%%updated_s%% Subsyses has been updated', array('%%updated_s%%' => $c_updated_s), 'messages'); ?>
                    </td></tr><?php
                } ?>
                </tbody>
            </table>
        </div><?php
        //Vendor//
        if (!empty($hook['new_v'])) {
            $new_vs = $hook['new_v']; ?>
            <div class="sf_admin_list">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo __('Code', array(), 'messages'); ?></th>
                            <th><?php echo __('Name', array(), 'messages'); ?></th>
                        </tr>
                    </thead>
                    <tfoot><tr><th colspan="2"><div class="sf_admin_pagination"><?php
                        if ($c_new_v == 1)  echo __('%%new_v%% new Vendor has been added', array('%%new_v%%' => $c_new_v), 'messages');
                        else    echo __('%%new_v%% new Vendors has been added', array('%%new_v%%' => $c_new_v), 'messages'); ?>
                    </div></th></tr></tfoot>
                    <tbody><?php
                    foreach ($new_vs as $key => $value) { ?>
                        <tr class="sf_admin_row odd">
                            <td><?php echo $key; ?></td>
                            <td><?php echo $value; ?></td>
                        </tr><?php
                    } ?>
                    </tbody>
                </table>
            </div><?php
        }
        if (!empty($hook['updated_v']) && (count($hook['updated_v']) == count($hook['updated_old_v']))) {
            $updated_vs = $hook['updated_v'];
            $updated_old_vs = $hook['updated_old_v']; ?>
            <div class="sf_admin_list">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo __('New name', array(), 'messages'); ?></th>
                            <th><?php echo __('Old name', array(), 'messages'); ?></th>
                            <th><?php echo __('Code', array(), 'messages'); ?></th>
                        </tr>
                    </thead>
                    <tfoot><tr><th colspan="3"><div class="sf_admin_pagination"><?php
                        if ($c_updated_v == 1)  echo __('%%updated_v%% Vendor has been updated', array('%%updated_v%%' => $c_updated_v), 'messages');
                        else    echo __('%%updated_v%% Vendors has been updated', array('%%updated_v%%' => $c_updated_v), 'messages'); ?>
                    </div></th></tr></tfoot>
                    <tbody><?php
                    foreach ($updated_vs as $key => $value) { ?>
                        <tr class="sf_admin_row odd">
                            <td><?php echo $value; ?></td>
                            <td><?php echo $updated_old_vs[$key]; ?></td>
                            <td><?php echo $key; ?></td>
                        </tr><?php
                    } ?>
                    </tbody>
                </table>
            </div><?php
        }
        // Device
        if (!empty($hook['new_d'])) {
            $new_ds = $hook['new_d']; ?>
            <div class="sf_admin_list">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo __('Code', array(), 'messages'); ?></th>
                            <th><?php echo __('Name', array(), 'messages'); ?></th>
                            <th><?php echo __('Vendor', array(), 'messages'); ?></th>
                        </tr>
                    </thead>
                    <tfoot><tr><th colspan="3"><div class="sf_admin_pagination"><?php
                        if ($c_new_d == 1)  echo __('%%new_d%% new Device has been added', array('%%new_d%%' => $c_new_d), 'messages');
                        else    echo __('%%new_d%% new Devices has been added', array('%%new_d%%' => $c_new_d), 'messages'); ?>
                    </div></th></tr></tfoot>
                    <tbody><?php
                    foreach ($new_ds as $v_id => $device) {
                        foreach ($device as $d_id => $d_name) { ?>
                            <tr class="sf_admin_row odd">
                                <td><?php echo $d_id; ?></td>
                                <td><?php echo $d_name; ?></td>
                                <td><?php
                                    $v = VendorPeer::retrieveByPK($v_id, $type_id);
                                    echo $v->getName();
                                    unset($v);
                                ?></td>
                            </tr><?php
                        }
                    } ?>
                    </tbody>
                </table>
            </div><?php
        }
        if (!empty($hook['updated_d']) && (count($hook['updated_d']) == count($hook['updated_old_d']))) {
            $updated_ds = $hook['updated_d'];
            $updated_old_ds = $hook['updated_old_d']; ?>
            <div class="sf_admin_list">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo __('New name', array(), 'messages'); ?></th>
                            <th><?php echo __('Old name', array(), 'messages'); ?></th>
                            <th><?php echo __('Code', array(), 'messages'); ?></th>
                            <th><?php echo __('Vendor', array(), 'messages'); ?></th>
                        </tr>
                    </thead>
                    <tfoot><tr><th colspan="4"><div class="sf_admin_pagination"><?php
                        if ($c_updated_d == 1)  echo __('%%updated_d%% Device has been updated', array('%%updated_d%%' => $c_updated_d), 'messages');
                        else    echo __('%%updated_d%% Devices has been updated', array('%%updated_d%%' => $c_updated_d), 'messages'); ?>
                    </div></th></tr></tfoot>
                    <tbody><?php
                    foreach ($updated_ds as $v_id => $device) {
                        foreach ($device as $d_id => $d_name) { ?>
                            <tr class="sf_admin_row odd">
                                <td><?php echo $d_name; ?></td>
                                <td><?php echo $updated_old_ds[$v_id][$d_id]; ?></td>
                                <td><?php echo $d_id; ?></td>
                                <td><?php
                                    $v = VendorPeer::retrieveByPK($v_id, $type_id);
                                    echo $v->getName();
                                    unset($v);
                                ?></td>
                            </tr><?php
                        }
                    } ?>
                    </tbody>
                </table>
            </div><?php
        }
        // Subsys
        if (!empty($hook['new_s'])) {
            $new_ss = $hook['new_s']; ?>
            <div class="sf_admin_list">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo __('Code', array(), 'messages'); ?></th>
                            <th><?php echo __('Name', array(), 'messages'); ?></th>
                            <th><?php echo __('Vendor', array(), 'messages'); ?></th>
                            <th><?php echo __('Device', array(), 'messages'); ?></th>
                        </tr>
                    </thead>
                    <tfoot><tr><th colspan="4"><div class="sf_admin_pagination"><?php
                        if ($c_new_s == 1)  echo __('%%new_s%% new Subsys has been added', array('%%new_s%%' => $c_new_s), 'messages');
                        else    echo __('%%new_s%% new Subsyses has been added', array('%%new_s%%' => $c_new_s), 'messages'); ?>
                    </div></th></tr></tfoot>
                    <tbody><?php
                    foreach ($new_ss as $v_id => $device) {
                        foreach ($device as $d_id => $subsys) {
                            foreach ($subsys as $s_id => $s_name) { ?>
                                <tr class="sf_admin_row odd">
                                    <td><?php echo $s_id; ?></td>
                                    <td><?php echo $s_name; ?></td>
                                    <td><?php
                                        $v = VendorPeer::retrieveByPK($v_id, $type_id);
                                        echo $v->getName();
                                        unset($v);
                                    ?></td>
                                    <td><?php
                                        $c = new Criteria;
                                        $c->add(DevicePeer::CODE, $d_id);
                                        $c->add(DevicePeer::VENDOR_ID, $v_id);
                                        $c->add(DevicePeer::TYPE_ID, $type_id);
                                        $d = DevicePeer::doSelectOne($c);
                                        echo $d->getName();
                                        unset($d);
                                    ?></td>
                                </tr><?php
                            }
                        }
                    } ?>
                    </tbody>
                </table>
            </div><?php
        }
        if (!empty($hook['updated_s']) && (count($hook['updated_s']) == count($hook['updated_old_s']))) {
            $updated_ss = $hook['updated_s'];
            $updated_old_ss = $hook['updated_old_s']; ?>
            <div class="sf_admin_list">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo __('New name', array(), 'messages'); ?></th>
                            <th><?php echo __('Old name', array(), 'messages'); ?></th>
                            <th><?php echo __('Code', array(), 'messages'); ?></th>
                            <th><?php echo __('Vendor', array(), 'messages'); ?></th>
                            <th><?php echo __('Device', array(), 'messages'); ?></th>
                        </tr>
                    </thead>
                    <tfoot><tr><th colspan="5"><div class="sf_admin_pagination"><?php
                        if ($c_updated_s == 1)  echo __('%%updated_s%% Subsys has been updated', array('%%updated_s%%' => $c_updated_s), 'messages');
                        else    echo __('%%updated_s%% Subsyses has been updated', array('%%updated_s%%' => $c_updated_s), 'messages'); ?>
                    </div></th></tr></tfoot>
                    <tbody><?php
                    foreach ($updated_ss as $v_id => $device) {
                        foreach ($device as $d_id => $subsys) {
                            foreach ($subsys as $s_id => $s_name) { ?>
                                <tr class="sf_admin_row odd">
                                    <td><?php echo $s_name; ?></td>
                                    <td><?php echo $updated_old_ss[$v_id][$d_id][$s_id]; ?></td>
                                    <td><?php echo $s_id; ?></td>
                                    <td><?php
                                        $v = VendorPeer::retrieveByPK($v_id, $type_id);
                                        echo $v->getName();
                                        unset($v);
                                    ?></td>
                                    <td><?php
                                        $c = new Criteria;
                                        $c->add(DevicePeer::CODE, $d_id);
                                        $c->add(DevicePeer::VENDOR_ID, $v_id);
                                        $c->add(DevicePeer::TYPE_ID, $type_id);
                                        $d = DevicePeer::doSelectOne($c);
                                        echo $d->getName();
                                        unset($d);
                                    ?></td>
                                </tr><?php
                            }
                        }
                    } ?>
                    </tbody>
                </table>
            </div><?php
        }        
    } ?>      
  </div>

</div>