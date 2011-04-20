<script type="text/javascript">
    jQuery(document).ready(function() {    	
		program_is_imageset_change();
		$("#is_imageset").change(function() {			
            program_is_imageset_change();			
        });		
    });
	function program_is_imageset_change(){
		is_txek=$("#is_imageset").attr("checked");
		if(is_txek){
			$("#imageset_id").removeAttr("disabled");
			//gaur
			$("#disk").removeAttr("disabled");
			//
			$(".my_style").attr("disabled",true);
			$(".my_style").val("");			
		}else{			
			$("#imageset_id").attr("disabled",true);
			//gaur
			$("#disk").attr("disabled",true);
			//
			$("#imageset_id").val("");
			//gaur
			$("#disk").val("");
			//
			$(".my_style").removeAttr("disabled");			
		}
	}
</script>