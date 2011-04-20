<?php use_helper('I18N', 'Date') ?>
<?php include_partial('sfGuardGroup/assets') ?>
<?php include_partial('global/filter_js') ?>

<div id="sf_admin_container">
  <h1 style="float:left"><?php echo __('Group list', array(), 'messages') ?></h1>
  <input id="click_filter" value="<?php echo __('Search', array(), 'messages'); ?>" type="button"  style="float:right" />

  <div class="list_notice">
  	<?php include_partial('sfGuardGroup/flashes') ?>
  </div>

  <div id="sf_admin_header">
    <?php include_partial('sfGuardGroup/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="show_filter">
    <?php include_partial('sfGuardGroup/filters', array('form' => $filters, 'configuration' => $configuration)) ?>  		
  </div>

  <div id="sf_admin_content">
    <?php include_partial('sfGuardGroup/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
  	<?php if($sf_user->hasCredential(array('sf_guard_group_new','sf_guard_group_edit'),false)):?>  
	<ul class="sf_admin_actions">
      <?php include_partial('sfGuardGroup/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('sfGuardGroup/list_actions', array('helper' => $helper)) ?>
    </ul>
  	<?php endif;?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('sfGuardGroup/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
