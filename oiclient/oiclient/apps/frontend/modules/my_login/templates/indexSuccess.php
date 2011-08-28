<?php echo use_helper('I18N') ?>
<?php include_partial('login_js'); ?>
<?php echo use_helper('Javascript'); ?>



<div class="eventos-login">
<div class="login">Login</div>
<form action="<?php echo url_for('my_login/equal');?>" method="post">
  <table class="log" align="center">
    <tr>
    <td><label for="my_login_user"><?php echo __('User');?></label></td>
    <td><input class="linea" type="text" id="my_login_user" name="my_login[user]" value=""/></td>
  </tr>
    <tr>
    <td><label for="my_login_password"><?php echo __('Password');?></label></td>
    <td><input class="linea" type="password" id="my_login_password" name="my_login[password]" value=""/></td>
    </tr>
    <tr>
    <td colspan="2"><input class="linea" type="submit" id="my_login_sign_in" name="my_login_sign_in" value="<?php echo __('Sign in');?>"/></td>
    </tr>
  </table>
</form>
<br><br>
<div class="menua">
<?php
if (count($listOisystems->oisystems) > 0) {
    echo link_to(__('list to works'), 'list_to_work/index', 'class="botoi-listoworks"');
}?>
<br>
<?php echo link_to('Halt', 'list_to_work/halt','class="botoi-halt"'); ?>
<br>
<?php echo link_to('reboot', 'list_to_work/reboot', 'class="botoi-reboot"'); ?>
<br>
</div>
</div>
