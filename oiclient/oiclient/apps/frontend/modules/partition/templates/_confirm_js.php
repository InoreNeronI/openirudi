<script type="text/javascript">
        var to;
        var data;

        $(document).ready(function() {

            function removeBoxy() {
                jQuery(".boxy-wrapper, .boxy-modal-blackout").unload();
                jQuery(".boxy-wrapper, .boxy-modal-blackout").remove();
            }

            function loadBoxy(){
                 Boxy.load('<?php echo url_for("image/loading"); ?>', {
                        title: '<?php echo __('Working').'...'; ?>',
                        closeable: false,
                        draggable: true,
                        modal: true,
                        show: true,
                        afterShow: sendForm
                   });
                   //jQuery(".boxy-wrapper, .boxy-modal-blackout").resize(200,200)
            }

            function sendForm(){
                $.ajax({
                       type: 'GET',
                       dataType: 'json',
                       //dataType: 'html',
                       //async: false,
                       url: to,
                       data: data,
                       success: function(d) {
                           //window.location = '<?php echo url_for('partition/index') ?>';
                           //removeBoxy();
                           txt="";
                           for(var i in d){
                               txt=txt + " "+ d[i]
                           }
                           if(txt.length > 0){
                               alert(txt);
                           }
                           removeBoxy();
                       },
                       error: function() {
                            removeBoxy();
                        },
                        complete: function() {
                            window.location = '<?php echo url_for('partition/index') ?>';
                            removeBoxy();
                        }
                   })
            }
            
            $(".changeConfirm").click(function(){
                var r;
                removeBoxy();
		r=confirm("Are you sure?");
                if(r){
                    data={
                        partitionName:$('#partition_partitionName').val(),
                        diskName:$('#partition_diskName').val(),
                        sizeB:$('#partition_sizeB').val(),
                        unit:$('#partition_unit').val(),
                        id:$('#partition_id').val()
                    };
                    to='<?php echo url_for('partition/save') ?>';
                    loadBoxy();
                    return true;
                   
                }
            });


            $(".newConfirm").click(function(){
                 var r;
                removeBoxy();
		r=confirm("Are you sure?");
                if(r){
                    data={
                        diskName:$('#partition_diskName').val(),
                        type:$('#partition_type').val(),
                        fs:$('#partition_fs').val(),
                        boot:$('#partition_boot').val(),
                        size:$('#partition_size').val(),
                        unit:$('#partition_unit').val()
                    };
                    to='<?php echo url_for('partition/add') ?>';
                    loadBoxy();
                    return true;
                }
            });

            $(".delConfirm").click(function(){
                var r;
                removeBoxy();
		r=confirm("Are you sure?");
                var p=$(this).parent().parent().attr("id");
                if(r){
                    data={
                        partitionName:p
                    };
                    to='<?php echo url_for('partition/remove') ?>';
                    loadBoxy();
                    return true;
                }
            });

});
</script>