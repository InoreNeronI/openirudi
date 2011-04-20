<?php use_helper('I18N') ?>
<?php include_partial('home/assets') ?>

<script type="text/javascript">
    var jcu;
    jQuery(document).ready(function() {
        var conf = {
            url: "<?php echo str_replace('home', '', ParseINF::selfURL()).('home/upload'); ?>",

            flash_file: "<?php echo str_replace($_SERVER['REQUEST_URI'], '', ParseINF::selfURL()).'/drivers/web/jcupload.swf'; ?>",
            flash_width: 64,
            flash_height: 64,
            flash_background: "<?php echo str_replace($_SERVER['REQUEST_URI'], '', ParseINF::selfURL()).'/drivers/web/images/jcu_button.png'; ?>",

            file_icon_ready: "<?php echo str_replace($_SERVER['REQUEST_URI'], '', ParseINF::selfURL()).'/drivers/web/images/jcu_file_ready.gif'; ?>",
            file_icon_uploading: "<?php echo str_replace($_SERVER['REQUEST_URI'], '', ParseINF::selfURL()).'/drivers/web/images/jcu_file_uploading.gif'; ?>",
            file_icon_finished: "<?php echo str_replace($_SERVER['REQUEST_URI'], '', ParseINF::selfURL()).'/drivers/web/images/jcu_file_finished.gif'; ?>",

            hide_file_after_finish: false,
            hide_file_after_finish_timeout: 2000,
            error_timeout: 3000,

            max_file_size: 4 * 1024 * 1024 * 5, // =20MB
            max_queue_count: 99,
            max_queue_size: 50 * 1024 * 1024 * 10, // =500MB

            extensions: ["<?php echo __('Zip Archive Files'); ?> (*.zip)|*.zip"],

            multi_file: 0,

            callback: {
                init: function(uo, jcu_version, flash_version) {
                    var lines= [];
                    lines[0]= "jcUpload successfuly initialized!";
                    lines[1]= "jcu_version=" + jcu_version;
                    lines[2]= "flash_version=" + flash_version;
                },
                file_added: function(uo) {
                    jQuery('.jcu_file_cell_icon').each(function() { jQuery(this).css("border", "0px solid white"); });
                    jQuery('.jcu_file_cell_name').each(function() { jQuery(this).css("border", "0px solid white"); });
                    jQuery('.jcu_file_cell_name').each(function() { jQuery(this).css("border-left", "2px solid blue"); });
                    jQuery('.jcu_file_cell_name').each(function() { jQuery(this).css("margin-top", "1%"); });
                    jQuery('.jcu_file_cell_status').each(function() { jQuery(this).css("border", "0px solid white"); });
                    jQuery('.jcu_file_delimeter').each(function() { jQuery(this).css("border", "0px solid white"); });
                },
                upload_end: function(uo, file_index) {
                    jQuery.get("<?php echo str_replace('home', '', ParseINF::selfURL()).'home/uploadEnd'; ?>", '',
                    function (msg1) {
                        if (msg1 != '') {
                            var json1 = eval('('+msg1+')');
                            if (json1.path != 'null') {
                                alert("<?php echo __('The archive successfuly uploaded and unzipped,\nlet\'s parse its content to upgrade our repository'); ?>");
                                jQuery('.jcu_file_table').each(function() {
                                    jQuery(this).find('tr:first').find('td.jcu_file_cell_name').each(function() {
                                        jQuery(this).attr('id', 'append');
                                    });
                                });
                                Boxy.load("<?php echo str_replace('home', '', ParseINF::selfURL()).'driver/loading'; ?>", {
                                    title: "<?php echo __('Please wait until database upgrade finish').'...'; ?>",
                                    closeable: false,
                                    draggable: true,
                                    modal: true
                                });
                                jQuery.ajax({
                                  url: "<?php echo str_replace('home', '', ParseINF::selfURL()).'home/operate'; ?>",
                                  global: false,
                                  type: "POST",
                                  data: "path="+json1.path,
                                  dataType: "html",
                                  success: function(msg2){
                                     var json2 = eval('('+msg2+')');
                                     jQuery.get("<?php echo str_replace('home', '', ParseINF::selfURL()).'home/filesParsed'; ?>", { result: json2.text.toString() },
                                        function (data) {
                                            jQuery(".boxy-wrapper, .boxy-modal-blackout").remove();
                                            jQuery("#append").append(data);
                                            jQuery.each(json1.output, function() { jQuery("#div_log").append(this + '<br />'); });
                                        });
                                  }
                               });
                            } else if (json1.path == 'null') {
                                alert("<?php echo __('This is not a valid Zip archive, sorry').'...'; ?>");
                            }
                        }
                    });
                },
                queue_upload_end: function(uo) {
                    //alert("<?php //echo __('All files from queue successfuly uploaded!'); ?>");
                },
                error_file_size: function(uo, file_name, file_type, file_size) {
                    alert("File " + file_name +" is to big!");
                },
                error_queue_count: function(uo, file_name, file_type, file_size) {
                    alert("File " + file_name +" ignored, because the file queue is full!");
                },
                error_queue_size: function(uo, file_name, file_type, file_size) {
                    alert("File " + file_name +" ignored, because the file queue size is too big!");
                }
                // other callbacks...
            }
        };

        jcu = jQuery.jcuploadUI(conf);
        jcu.append_to("#jcupload_content");

    });
</script>

<h1 align="center">..:: <?php echo __('WELCOME TO OPENIRUDI'); ?> ::..</h1>
<!--
<br />
<h2 align="center">.: <?php echo __('Select one of the following actions or navigate trough the different sections'); ?> :.</h2>
<br />
<br />
<br />
<div width="45%" style="margin-right:auto;margin-left:auto;float:left">
    <h4 align="center"><?php echo __('Update PCI Database List'); ?></h4>
    <p align="center"><?php
        //echo link_to(image_tag('k-cm-pci-48x48.png  ', 'align=absmiddle'), ParseINF::selfURL().'vendor/readPciIds').'<br />'; ?>
    </p>
</div>
<div width="10%" style="margin-right:auto;margin-left:auto;float:left">&nbsp;&nbsp;&nbsp;</div>
<div width="45%" style="margin-right:auto;margin-left:auto;float:left">
    <h4 align="center"><?php echo __('Update USB Database List'); ?></h4>
    <p align="center"><?php
        //echo link_to(image_tag('USB-Connection-48x48.png', 'align=absmiddle'), ParseINF::selfURL().'vendor/readUsbIds').'<br />'; ?>
    </p>
</div>
<br />
<br />
<div style="clear:both" class="demo_app_box">
    <h4><?php //echo __('Upload new zipped Driver (Click on the globe!)'); ?></h4>
    <p align="center" class="jcu_plugin_insert_area" id="jcupload_content"></p>
</div>
-->