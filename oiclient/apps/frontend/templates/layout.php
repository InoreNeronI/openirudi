<?php use_helper('I18N') ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>

        <?php include_http_metas() ?>
        <?php include_metas() ?>

        <?php include_title() ?>

        <link rel="shortcut icon " href="/favicon.ico" />

    </head>
    <body>

        <div id="wrapper">
            <div id="header">
                
                <div id="logo" style="float:left">
                    <?php echo link_to(image_tag('/images/openlogo.png', array('alt' => "Openirudi")), '@homepage') ?>
                </div>
                <div style="float:right"><?php include_component('sfLanguageSwitch', 'get') ?></div>
                
            </div>
            <div id="container">
                <div class="flerro_bot">
                    <?php include_partial('global/menu') ?>
                    
                </div>
                <div class="content">
                    <?php include_partial('global/messages') ?>
                    <?php echo $sf_content; ?>
                </div>
            </div>
        </div>
    </body>
</html>
