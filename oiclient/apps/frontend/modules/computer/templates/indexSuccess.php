<?php echo use_helper('I18N') ?>

<div class="eventos">
<fieldset>
<legend><?php echo __('General') ?></legend>
<!--<?php echo '<p>'.link_to(__('Reload hardware information'), 'computer/reload').'</p>'; ?>-->
<?php include_partial('general', array('hw' => $hw)) ?>
<?php echo '<p>'.link_to(__('Hardware detail'), 'computer/detail', array('target' => '_blank', 'class'=>'botoi')).'</p>'; ?>
</fieldset>
<br />   <div class="spacer">&nbsp;</div>
</div>


<?php //include_partial('partition/partitions', array('hw' => $hw,'listOisystems' => $listOisystems, 'listSizeUnits' => $listSizeUnits, 'modify' => true)) ?>


