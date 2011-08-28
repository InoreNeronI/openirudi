<div id="menu-lang">
<ul id="lang">
<?php foreach($sf_data->getRaw('languages') as $language =>
$information): ?>
<li<?php echo $language == $sf_user->getCulture() ? ' class="active"' :
'' ?>>
<?php /*echo link_to(
         image_tag(
       $information['image'],
       array(
         'alt' => $information['title']
       )
     ),
         $current_module . '/' . $current_action . $information['query']
       ) */?>



<?php $args='';?>
<?php foreach($_GET as $izena=>$balioa):?>
<?php $args.='&'.$izena.'='.$balioa;?>
<?php endforeach;?>


<?php echo link_to($information['title'],$current_module . '/' .
$current_action . $information['query'].$args) ?>
</li>
<?php endforeach; ?>
</ul>
</div>