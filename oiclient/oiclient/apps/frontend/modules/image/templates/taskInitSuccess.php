<?php use_helper('I18N'); ?>
<?php use_helper('Javascript'); ?>

<script type="text/javascript"><!--
    $(document).ready(function () {
        Boxy.load('<?php echo url_for("image/loading"); ?>', {
            title: '<?php echo __('Working').'...'; ?>',
            closeable: false,
            draggable: true,
            modal: true
        });
        $("#divIframe").html("<iframe id=\"iframe\"  width=\"700\" height=\"400\" src=\"deploy#end\" onload=\"iframe_loaded();\" id=\"result\" > </iframe>")
    });

    function iframe_loaded() {
        jQuery(".boxy-wrapper, .boxy-modal-blackout").remove();
    }
--></script>
<noscript><iframe id="iframe"  width="700" height="400" src="deploy#end" onload="iframe_loaded();" id="result" ></iframe></noscript>


<div id="divIframe" width="700" height="400" ></div>


<?

echo button_to(__('Continue'), 'image/index'); 


?>