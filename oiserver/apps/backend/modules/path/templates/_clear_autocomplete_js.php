<script type="text/javascript">
$(document).ready(function() { 
	
	$("img.img_class_driver_name").click(function(){
		$("#path_filters_driver_name").val("");
		$("#autocomplete_path_filters_driver_name").val("");
		$("#autocomplete_path_filters_driver_name").focus();
	});

	$("img.img_class_vendor_id").click(function(){
		$("#path_filters_vendor_id").val("");
		$("#autocomplete_path_filters_vendor_id").val("");
		$("#autocomplete_path_filters_vendor_id").focus();
	});		
}); 
</script> 