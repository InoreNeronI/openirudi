<?php use_helper('I18N', 'Date') ?>
<?php include_partial('driver/assets') ?>

<div id="sf_admin_container"><?php
  $offset = stripos($folder, sfConfig::get('app_const_packs_dir_name')) + strlen(sfConfig::get('app_const_packs_dir_name'));
  echo '<h1>'.__('Index of .%%folder%%', array('%%folder%%' => substr($folder, $offset)), 'messages').':</h1>'; ?>

  <?php include_partial('driver/flashes') ?>

  <div id="sf_admin_header">
    <?php //include_partial('driver/form_header', array('driver' => $driver, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content"><?php
        $str = file_get_contents($folder);
        $str = str_replace('</a>', '', str_replace('<td valign="top"></td>', '', str_replace('<hr>', '', $str)));
        $str = preg_replace("/<img.src[= = ].*?>+/i", "", $str);
        $str = preg_replace("/<a.href[= = ].*?>+/i", "", $str);
        $tx = new tableExtractor;
        $tx->source = $str;
        $tx->anchor = '<h1>Index of';
        $table2array = $tx->extractTable();
        if (!empty($table2array)) { ?>
            <div class="sf_admin_list">
                <table cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo __('Name', array(), 'messages'); ?></th>
                            <th><?php echo __('Last modified', array(), 'messages'); ?></th>
                            <th><?php echo __('Size', array(), 'messages'); ?></th>
                        </tr>
                    </thead>
                    <tbody><?php
                foreach ($table2array as $file) {
                    if (trim($file['Name']) != 'Parent Directory' && trim($file['Name']) != '') { ?>
                        <tr class="sf_admin_row odd">
                            <td><?php echo link_to($file['Name'], $folder.'/'.$file['Name']); ?></td>
                            <td><?php echo format_date($file['Last modified'], 'D'); ?></td>
                            <td><?php echo $file['Size']; ?></td>
                        </tr><?php
                    }
                } ?>
                    </tbody>
                </table>
            </div><?php
        } ?>
  </div>

  <div id="sf_admin_footer">
    <?php //include_partial('driver/form_footer', array('driver' => $driver, 'configuration' => $configuration)) ?>
  </div>
</div>