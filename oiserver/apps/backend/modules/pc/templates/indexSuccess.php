<?php use_helper('I18N', 'Date') ?>
<?php include_partial('pc/assets') ?>
<?php include_partial('global/filter_js') ?>
<?php include_partial('pc/txek_js',array('pc_id_js_array'=>$pc_id_js_array)) ?>

<div id="sf_admin_container">
  <h1 style="float:left"><?php echo __('Pc List', array(), 'messages') ?></h1>
  <input id="click_filter" value="<?php echo __('Search', array(), 'messages'); ?>" type="button"  style="float:right" />

  <?php //OHARRA::::list-notice gehitu da bestela ezabatzean mezua itulu gainean geratzen da ?>
  <div class="list_notice">
  	<?php include_partial('pc/flashes') ?>
  </div>

  <div id="sf_admin_header">
    <?php include_partial('pc/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="show_filter">
  <!--	
  <div id="sf_admin_bar">
  -->
    <?php include_partial('pc/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">     
    <?php include_partial('pc/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>	
    <ul class="sf_admin_actions">
      <?php //include_partial('pc/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('pc/list_actions', array('helper' => $helper)) ?>
    </ul>    
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('pc/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
