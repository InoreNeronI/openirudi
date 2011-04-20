<?php use_helper('I18N') ?>
<?php use_stylesheet('/sfPropelPlugin/css/global.css', 'first') ?>
<?php use_stylesheet('/sfPropelPlugin/css/default.css', 'first') ?>

<script type="text/javascript"><!--
    jQuery(document).ready(function() {
        Boxy.load("<?php echo str_replace('readInfs', '', ParseINF::selfURL()).'loading'; ?>", {
            title: "<?php echo __('Wait').'...'; ?>",
            closeable: false,
            draggable: true,
            modal: true
        });
        jQuery.ajax({
          url: "<?php echo str_replace('readInfs', '', ParseINF::selfURL()).'operate'; ?>",
          global: false,
          type: "POST",
          dataType: "html",
          success: function(msg){
             var json = eval('('+msg+')');
             jQuery.get("<?php echo str_replace('readInfs', '', ParseINF::selfURL()).'filesParsed'; ?>", { result: json.text.toString() },
                function (data) {
                    jQuery(".boxy-wrapper, .boxy-modal-blackout").remove();
                    jQuery("#append").append(data);
                });
          }
       });
    });
--></script>

<div id="append"></div>