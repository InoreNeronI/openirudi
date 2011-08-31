<?php use_helper('I18N');?>
<div class="eventos">
<p>
<div id="error_msg">
         
            <ul>
                <li><?php echo __('Login required');?></li>
            </ul>
        </div>

</p><br />
<div class="menua">
<?php echo link_to(__('Back'),'my_login/index', 'class="botoi"');?>
<br>
<?php
if (count($listOisystems->oisystems) > 0) {
    echo link_to(__('Logout'), 'list_to_work/index', 'class="botoi"');
}?>
</div>
</div>