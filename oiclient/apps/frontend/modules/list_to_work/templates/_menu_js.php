
<script type="text/javascript">
    var to;
    var data;
    $(document).ready(function() {
        var timeout;

        function loadBoxy(){
            Boxy.load('<?php echo url_for("list_to_work/loading"); ?>', {
                title: '<?php echo __('Working') . '...'; ?>',
                closeable: true,
                draggable: true,
                modal: false,
                show: true
                //afterShow: sendForm

            });
            //jQuery(".boxy-wrapper, .boxy-modal-blackout").resize(200,200)
        }


        function sendForm(){
            var to="list_to_work/after";
            var data={ };

            // var to=$('#fixBoot').attr('href');
            $.ajax({
                type: 'GET',
                dataType: 'json',
                //dataType: 'html',
                //async: false,
                url: to,
                data: data,
                success: function(d) {
                    txt="";
                    for(var i in d){
                        txt=txt + " "+ d[i]
                    }
                    if(txt.length > 0){
                        alert(txt);
                    }
                },
                error: function() {
                },
                complete: function() {
                }

            })
        }


        function message(){
            sendForm();

        }
        function start(){
            timeout = setTimeout(message,<?php echo sfConfig::get('app_const_bootTimeout')?>);
        }
        function stop(){
            clearTimeout(timeout);
        }
        
        <?php if( count($hw->listDisks->partitionsOS(false))>0 && sfYamlOI::readKey('boot')==1){ ?>
            var boot=1;
        <?php }else{ ?>
            var boot=0;
        <?php }?>
        
        if(boot==1 ){
            start();
        }

        $(document)[0].oncontextmenu = function() {return false;}
        $('#l1').focus();

        $("#login").click(function(){
            //alert("aaa");
//            to = $(this).parent("form").attr("action");
//            data = $(this).parent("form").serialize();
            loadBoxy();
            //return false;
//            var move= $(this).parent("form").attr("class");
//            if(move == 'submitMove'){
//                return true;
//            }else{
//                return false;
//            }

        });


    });
</script>



