<script type="text/javascript">
    jQuery(document).ready(function() {
		var type='static';
		var fields=new Array('ip','netmask','gateway','dns1','dns2');
        <?php if(isset($my_client['type']) && !empty($my_client['type'])):?>
			type='<?php echo $my_client['type'];?>';			
		<?php endif;?>
		if(type=='dhcp'){
			set_state_fields(fields,false);
		}else{
			set_state_fields(fields,true);
		}
		//
		$('#my_client_static').click(function() {
  			set_state_fields(fields,true);
		});
		//
		$('#my_client_dhcp').click(function() {
  			set_state_fields(fields,false);
		});
    });
	function set_state_fields(fields,state){
		var num=fields.length;
		if(num>0){
			var f='';
			for(var i=0;i<num;i++){
				f=fields[i];
				if(state){
					$('#my_client_'+f).removeAttr("disabled");
					$("#div_"+f).css("display", "block");	 
				}else{
					$('#my_client_'+f).attr("disabled", true);
					$("#div_"+f).css("display", "none");	
				} 
			}
		}
	}
</script>