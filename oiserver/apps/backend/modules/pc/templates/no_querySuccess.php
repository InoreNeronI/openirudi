<?php use_helper('I18N', 'Date') ?>
<?php include_partial('pc/assets') ?>
<?php include_partial('global/filter_js') ?>

<div id="sf_admin_container">
  <h1 style="float:left"><?php echo __('Pc List', array(), 'messages') ?></h1>
  <input id="click_filter" value="<?php echo __('Search', array(), 'messages'); ?>" type="button"  style="float:right" />

  
  <div id="sf_admin_header">
  
  </div>

  <div id="show_filter">
  <!--	
  <div id="sf_admin_bar">
  -->
    <?php include_partial('pc/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <div class="sf_admin_list">	 
		<p><?php echo __('No query', array(), 'sf_admin') ?></p>
	</div>
	<ul class="sf_admin_actions">      
      <?php include_partial('pc/list_actions', array('helper' => $helper)) ?>
    </ul>
  </div>

  <div id="sf_admin_footer">
    
  </div>
</div>
