<?php use_helper('I18N', 'Date') ?>
<?php include_partial('path/assets') ?>
<?php include_partial('global/filter_js') ?>
<?php include_partial('path/clear_autocomplete_js');?>

<div id="sf_admin_container">

    <h1 style="float:left"><?php echo __('Path List', array(), 'messages') ?></h1>
    <input id="click_filter" value="<?php echo __('Search', array(), 'messages'); ?>" type="button"  style="float:right" />

  <div class="list_notice">
  	<?php include_partial('path/flashes') ?>
  </div>

  <div id="sf_admin_header">
    <?php include_partial('path/list_header', array('pager' => $pager)) ?>
  </div>

  <!--<div id="sf_admin_bar">
    <?php //include_partial('path/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>-->

  <div id="show_filter"><?php
    include_partial('path/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('path_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('path/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <!--<ul class="sf_admin_actions">
      <?php //include_partial('path/list_batch_actions', array('helper' => $helper)) ?>
      <?php //include_partial('path/list_actions', array('helper' => $helper)) ?>
    </ul>-->
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('path/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
