<?php use_helper('I18N'); ?>
<?php use_helper('Javascript'); ?>

<?php include_partial('result', array('result' => $result ) ); ?>


<script type="text/javascript"><!--
    var result=0;
    var interval;

     $(document).ready(function () {
        Boxy.load('<?php echo url_for("image/loading"); ?>', {
            title: '<?php echo __('Working').'...'; ?>',
            closeable: false,
            draggable: true,
            modal: true,
            show: true,
            afterShow: function() {
                //loadIframe();
                //sendQ();
            }
        });
    });

    
    function update() {

        $.get("<?php echo url_for('image/process'); ?>", {count:1}, function(data){
            if ( data.substring(0,5) == '!EOF!' ){
                result=data.substring(5,6);
                ask();
                clearInterval(interval);
            }else{
                $("#ssprocess").html(data);
            }
        });
      }

    function loadIframe() {
        //$("#divIframe").html("<iframe id=\"iframe\"  width=\"700\" height=\"300\" src=\"<?php echo $to; ?>#end\" onload=\"removeBoxy();\" id=\"result\" > </iframe>")
        $("#divIframe").html("<iframe id=\"iframe\"  width=\"700\" height=\"300\" src=\"<?php echo url_for('image/processAllLog'); ?>#end\" id=\"result\" > </iframe>")

    }

    function removeBoxy() {
        clearInterval(interval);
        jQuery(".boxy-wrapper, .boxy-modal-blackout").unload();
        jQuery(".boxy-wrapper, .boxy-modal-blackout").remove();
    }

    function ask(){

        var label="<?php echo __("$name"); ?>";

        if(result){
            label+="<?php echo ' '. __("sucesfully"); ?>";
        }else{
            label+="<?php echo ' '. __("With ERRORS!!"); ?>";
        }
        label += "<?php echo "<br>".__("Do you want show log?"); ?>"

        $.get("<?php echo url_for('image/redetect'); ?>");

        Boxy.ask(
            label,
            ["<?php echo __("yes");?>", "<?php echo __("no");?>"],
            function(val) {
                if(val=="<?php echo __("yes");?>"){
                    loadIframe();
                    removeBoxy();

                }else{
                    window.location="<?php echo url_for('image/index') ?>"
                }
                removeBoxy();
            },
            {title: "<?php echo __("log");?>"}
       );

    return false;

    }
    function setResult(result2){
        result=result2
    }

--></script>

<noscript><iframe id="iframe"  width="700" height="300" src="<?php echo $to; ?>#end" id="result" ></iframe></noscript>

<div id="divIframe" width="700" height="300" >

</div>


<?
echo button_to(__('Continue'), $back );
?>
