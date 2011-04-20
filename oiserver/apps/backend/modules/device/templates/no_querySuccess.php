<?php use_helper('I18N', 'Date') ?>
<?php include_partial('device/assets') ?>
<?php include_partial('global/filter_js') ?>
<?php include_partial('device/clear_autocomplete_js');?>

<div id="sf_admin_container">

    <h1 style="float:left"><?php echo __('Device List', array(), 'messages') ?></h1>
    <input id="click_filter" value="<?php echo __('Search', array(), 'messages'); ?>" type="button"  style="float:right" />

  

  <div id="sf_admin_header">
    
  </div>

 

  <div id="show_filter"><?php
    include_partial('device/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
	    <div class="sf_admin_list">	 
			<p><?php echo __('No query', array(), 'sf_admin') ?></p>
		</div>
  </div>

  <div id="sf_admin_footer">
   
  </div>
</div>
