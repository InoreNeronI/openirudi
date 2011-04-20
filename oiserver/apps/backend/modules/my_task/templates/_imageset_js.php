<script type="text/javascript">
    jQuery(document).ready(function() {    	
		is_imageset_change();
		$("#my_task_is_imageset").change(function() {
            is_imageset_change();
        });
    });
	function is_imageset_change(){
		is_txek=$("#my_task_is_imageset").attr("checked");
		if(is_txek){
			$(".sf_admin_form_field_imageset_id").css("display", "block");
			$(".sf_admin_form_field_disk").css("display", "block");
			$(".sf_admin_form_field_oiimages_id").css("display", "none");
			$(".sf_admin_form_field_partition").css("display", "none");
			$("#my_task_oiimages_id").val("");
			$("#my_task_partition").val("");
		}else{
			$(".sf_admin_form_field_imageset_id").css("display", "none");
			$(".sf_admin_form_field_disk").css("display", "none");
			$(".sf_admin_form_field_oiimages_id").css("display", "block");
			$(".sf_admin_form_field_partition").css("display", "block");
			$("#my_task_imageset_id").val("");
			$("#my_task_disk").val("");
		}
	}	
</script>