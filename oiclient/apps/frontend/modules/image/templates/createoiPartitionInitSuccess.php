<?php use_helper('I18N'); ?>
<?php use_helper('Javascript'); ?>


<script type="text/javascript"><!--
    Boxy.load('<?php echo url_for("image/loading"); ?>', {
        title: '<?php echo __('Working').'...'; ?>',
        closeable: false,
        draggable: true,
        modal: true
    });

    function iframe_loaded() {
        jQuery(".boxy-wrapper, .boxy-modal-blackout").remove();
    }
--></script>


<iframe width="700" height="400" src="createImage#end" onload="iframe_loaded();" id="result" >

</iframe>
<br>

<?

echo button_to(__('Continue'), 'image/index'); 


?>