<?php if($error_row['error']):?>
	<ul class="error_list">
    	<li><?php echo __($error_row['msg'],array(),'messages');?></li>
  	</ul>
<?php endif;?>