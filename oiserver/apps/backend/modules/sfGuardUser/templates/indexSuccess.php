<?php use_helper('I18N', 'Date') ?>
<?php include_partial('sfGuardUser/assets') ?>
<?php include_partial('global/filter_js') ?>

<div id="sf_admin_container">
  <h1 style="float:left"><?php echo __('User list', array(), 'messages') ?></h1>
  <input id="click_filter" value="<?php echo __('Search', array(), 'messages'); ?>" type="button"  style="float:right" />

  <div class="list_notice">
  	<?php include_partial('sfGuardUser/flashes') ?>
  </div>

  <div id="sf_admin_header">
    <?php include_partial('sfGuardUser/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="show_filter">	
	<?php include_partial('sfGuardUser/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>  	
	
  <div id="sf_admin_content">
    <?php include_partial('sfGuardUser/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <?php if($sf_user->hasCredential(array('sf_guard_user_new','sf_guard_user_edit'),false)):?>
    <ul class="sf_admin_actions">
      <?php include_partial('sfGuardUser/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('sfGuardUser/list_actions', array('helper' => $helper)) ?>
    </ul>
  	<?php endif;?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('sfGuardUser/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
