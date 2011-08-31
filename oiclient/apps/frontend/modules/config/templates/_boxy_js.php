<script type="text/javascript">
    var to;
    var data;
    $(document).ready(function() {
        function removeBoxy() {
            jQuery(".boxy-wrapper, .boxy-modal-blackout").unload();
            jQuery(".boxy-wrapper, .boxy-modal-blackout").remove();
        }

        function loadBoxy(){
            Boxy.load('<?php echo url_for("list_to_work/loading"); ?>', {
                title: '<?php echo __('Working') . '...'; ?>',
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
                    removeBoxy();
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
                    removeBoxy();
                }

            })
        }

        $(":submit").click(function(){
            to = $(this).parent("form").attr("action");
            data = $(this).parent("form").serialize();
            loadBoxy();
            var move= $(this).parent("form").attr("class");
            if(move == 'submitMove'){
                return true;
            }else{
                return false;
            }
            
        });


    });
</script>