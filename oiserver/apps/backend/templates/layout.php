<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<?php echo include_http_metas() ?>
<?php echo include_metas() ?>
<?php use_helper('I18N') ?>
<?php //echo __(include_title()) ?>


<link rel="shortcut icon" href="/favicon.ico" />

</head>
<?php $module=$sf_request->getParameter('module');?>
<?php if(in_array($module,array('oiimages','sfGuardUser','pc'))):?>
<body id="<?php echo $module;?>">
<?php else:?>
<body>
<?php endif;?>
    <div id="head_title">
    		<?php echo link_to(image_tag('openlogo.png'),'home/index');?>
    </div> 
   

	<?php if($sf_user->isAuthenticated()):?>
		<div id="tab2" class="tabs">
        <?php include_component('sfLanguageSwitch', 'get') ?>
    </div>
    <!--<div id="tab1" class="tabs">
      <ul>
        <li><?php echo link_to('<span>'.__('Type').'</span>', 'type/index')?></li>
        <li><?php echo link_to('<span>'.__('Vendor').'</span>', 'vendor/index')?></li>
        <li><?php echo link_to('<span>'.__('Device').'</span>', 'device/index')?></li>
        <li><?php echo link_to('<span>'.__('Subsys').'</span>', 'subsys/index')?></li>
        <li><?php echo link_to('<span>'.__('Driver').'</span>', 'driver/index')?></li>
        <li><?php echo link_to('<span>'.__('System').'</span>', 'system/index')?></li>
        <li><?php echo link_to('<span>'.__('Path').'</span>', 'path/index')?></li>
        <li><?//php echo link_to(__('Pack'), 'pack/index')?></li>
       <li><?php echo link_to('<span>'.__('Oiimages').'</span>', 'oiimages/index')?></li>
		<li><?php echo link_to('<span>'.__('Pc group').'</span>', 'pcgroup/index')?></li>
        <li><?php echo link_to('<span>'.__('Pc List').'</span>', 'pc/index')?></li>
		<li><?php echo link_to('<span>'.__('Task').'</span>', 'my_task/index')?></li>
		<li><?php echo link_to('<span>'.__('Client').'</span>', '@my_client_edit')?></li>
		<li><?php echo link_to('<span>'.__('Imageset').'</span>', 'imageset/index')?></li>
		<?php include_partial('global/admin_button');?>
		<li><?php echo link_to('<span>'.__('Logout').'</span>', '@sf_guard_signout')?></li>		
      </ul>
    </div>-->

   

	<?php include_partial('global/admin_menu');?>	

	<?php endif;?>

    <div id="container">
    	<?php if($sf_user->isAuthenticated()):?>
    		<div id="menu">
				<ul>
					<!--<li class="seccion"><h3>Drivers</h3>
							<ul>
			        <li><?php echo link_to('<span>'.__('Type').'</span>', 'type/index')?></li>
			        <li><?php echo link_to('<span>'.__('Vendor').'</span>', 'vendor/index')?></li>
			        <li><?php echo link_to('<span>'.__('Device').'</span>', 'device/index')?></li>
			        <li><?php echo link_to('<span>'.__('Subsys').'</span>', 'subsys/index')?></li>
			        <li><?php echo link_to('<span>'.__('Driver').'</span>', 'driver/index')?></li>
			        <li><?php echo link_to('<span>'.__('System').'</span>', 'system/index')?></li>
			        <li><?php echo link_to('<span>'.__('Path').'</span>', 'path/index')?></li>
			        </ul>
        	</li>-->
        <!--<li><?//php echo link_to(__('Pack'), 'pack/index')?></li>-->
        	<li class="seccion"><h3>Images</h3>
	        	<ul>
	       			 <li><?php echo link_to('<span>'.__('Oiimages').'</span>', 'oiimages/index')?></li>
						   <li><?php echo link_to('<span>'.__('Pc group').'</span>', 'pcgroup/index')?></li>
	       			 <li><?php echo link_to('<span>'.__('Pc List').'</span>', 'pc/index')?></li>
							 <li><?php echo link_to('<span>'.__('Task').'</span>', 'my_task/index')?></li>
							 <li><?php echo link_to('<span>'.__('Client').'</span>', '@my_client_edit')?></li>
							 <li><?php echo link_to('<span>'.__('Imageset').'</span>', 'imageset/index')?></li>
						</ul>
					</li>
					<li class="seccion"><h3><?php include_partial('global/admin_button');?></h3></li>
		<li><?php echo link_to('<img src="/oiserver/web/images/logout.png" />', '@sf_guard_signout')?></li>		
      </ul>
				</div>
				<?php endif;?>
        <div id="content" style="clear:right">
            <?php echo $sf_content ?>
        </div>
<div class="spacer">&nbsp;</div>
    </div>
    
</body>
</html>
