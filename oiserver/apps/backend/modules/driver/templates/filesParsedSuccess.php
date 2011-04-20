<?php use_helper('I18N') ?>
<?php include_partial('driver/assets') ?>

<div id="sf_admin_container">
    <h1 style="padding-left:1%"><?php echo __('Drivers database upgrade result', array(), 'messages'); ?>:</h1>

    <div id="sf_admin_content">
        <div class="sf_admin_list" style="padding-left:5%"><?php
        $result = explode(',', $_GET['result']);
        if ($result !== false) {
            $time = explode('.', $result[0] / 60);
            $mins = $time[0];
            $secs = round(($result[0] - ($time[0] * 60)));
            $infs = $result[1];
            $processed_infs = $result[2];
            $not_processed_infs = $result[3];
            $binary_infs = $result[4];
            $no_version = $result[5];
            $no_provider = $result[6];
            $no_manufacturer = $result[7];
            $no_provider_neither_manufacturer = $result[8];
            $typ_cont = $result[9];
            $ven_cont = $result[10];
            $dev_cont = $result[11];
            $sub_cont = $result[12];
            $dr_cont = $result[13];
            $dr_cont_update = $result[14]; ?>
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th><?php
                            echo __('%%process_infs%% of %%inf_files%% inf files has been succesfully processed', array('%%process_infs%%' => $processed_infs, '%%inf_files%%' => $infs), 'messages');
                            ?>
                        </th>
                    </tr>
                </thead><?php //echo __('%%devs%% device items has been found for inserting in our database (Driver table)', array('%%devs%%' => $device_items), 'messages'); ?>
                <tfoot><tr><th><div class="sf_admin_pagination_left"><?php
                    echo __('Processing time: %%min%% minutes and %%sec%% seconds', array('%%min%%' => $mins, '%%sec%%' => $secs), 'messages'); ?>
                </div></th></tr></tfoot>
                <tbody><?php
                    if ($not_processed_infs > 0) { ?>
                        <tr class="sf_admin_row odd">
                            <td><?php
                                echo __('%%not_process_infs%% inf files has not been succesfully processed', array('%%not_process_infs%%' => $not_processed_infs), 'messages'); ?>
                            </td>
                        </tr><?php
                    }
                    if ($binary_infs > 0) { ?>
                        <tr class="sf_admin_row odd">
                            <td style="padding-left:5%"><?php
                                echo __('%%binary_infs%% binary inf files', array('%%binary_infs%%' => $binary_infs), 'messages'); ?>
                            </td>
                        </tr><?php
                    }
                    if ($no_version > 0) { ?>
                        <tr class="sf_admin_row odd">
                            <td style="padding-left:5%"><?php
                                echo __('%%no_ver%% inf files without [Version] section', array('%%no_ver%%' => $no_version), 'messages'); ?>
                            </td>
                        </tr><?php
                    }
                    if ($no_provider > 0) { ?>
                        <tr class="sf_admin_row odd">
                            <td style="padding-left:5%"><?php
                                echo __('%%no_prov%% inf files without Provider definition section', array('%%no_prov%%' => $no_provider), 'messages'); ?>
                            </td>
                        </tr><?php
                    }
                    if ($no_manufacturer > 0) { ?>
                        <tr class="sf_admin_row odd">
                            <td style="padding-left:5%"><?php
                                echo __('%%no_manu%% inf files without Manufacturer definition section', array('%%no_manu%%' => $no_manufacturer), 'messages'); ?>
                            </td>
                        </tr><?php
                    }
                    if ($no_provider_neither_manufacturer > 0) { ?>
                        <tr class="sf_admin_row odd">
                            <td style="padding-left:5%"><?php
                                echo __('%%no_prov_manu%% inf files without Provider and Manufacturer definition section', array('%%no_prov_manu%%' => $no_provider_neither_manufacturer), 'messages'); ?>
                            </td>
                        </tr><?php
                    }
                    if ($typ_cont == 0 && $ven_cont == 0 && $dev_cont == 0 && $sub_cont == 0 && $dr_cont == 0 && $dr_cont_update == 0) { ?>
                        <tr class="sf_admin_row odd">
                            <td><?php
                                echo __('Database was already upgraded, nothing to do.', array(), 'messages'); ?>
                            </td>
                        </tr><?php
                    } else {
                        if ($typ_cont > 0) { ?>
                            <tr class="sf_admin_row odd">
                                <td><?php
                                    echo __('%%new_t%% new types added!', array('%%new_t%%' => $typ_cont), 'messages'); ?>
                                </td>
                            </tr><?php
                        }
                        if ($ven_cont > 0) { ?>
                            <tr class="sf_admin_row odd">
                                <td><?php
                                    echo __('%%new_v%% new vendors added!', array('%%new_v%%' => $ven_cont), 'messages'); ?>
                                </td>
                            </tr><?php
                        }
                        if ($dev_cont > 0) { ?>
                            <tr class="sf_admin_row odd">
                                <td><?php
                                    echo __('%%new_d%% new devices added!', array('%%new_d%%' => $dev_cont), 'messages'); ?>
                                </td>
                            </tr><?php
                        }
                        if ($sub_cont > 0) { ?>
                            <tr class="sf_admin_row odd">
                                <td><?php
                                    echo __('%%new_s%% new subvendors added!', array('%%new_s%%' => $sub_cont), 'messages'); ?>
                                </td>
                            </tr><?php
                        }
                        if ($dr_cont > 0) { ?>
                            <tr class="sf_admin_row odd">
                                <td><?php
                                    echo __('%%new_driver%% NEW DRIVERS ADDED!', array('%%new_driver%%' => $dr_cont), 'messages'); ?>
                                </td>
                            </tr><?php
                        }
                        if ($dr_cont_update > 0) { ?>
                            <tr class="sf_admin_row odd">
                                <td><?php
                                    echo __('%%updated_driver%% DRIVERS UPDATED!', array('%%updated_driver%%' => $dr_cont_update), 'messages'); ?>
                                </td>
                            </tr><?php
                        }
                } ?>
                </tbody>
            </table><?php
        //echo __('All list:').'<br />'.print_r($big_list, 1);
        } else {
            echo __('Drivers PATH is NOT CORRECT, please put drivers in or change the path: ').sfConfig::get('app_const_packs_root');
        } ?>
        </div>
    </div>

</div>