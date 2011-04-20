<script type="text/javascript">
$(document).ready(function() { 
	
	$("img.img_class_vendor_id").click(function(){
		$("#driver_filters_vendor_id").val("");
		$("#autocomplete_driver_filters_vendor_id").val("");
		$("#autocomplete_driver_filters_vendor_id").focus();
	});

	$("img.img_class_device_id").click(function(){
		$("#driver_filters_device_id").val("");
		$("#autocomplete_driver_filters_device_id").val("");
		$("#device_driver_filters_vendor_id").val("");
		$("#device_driver_filters_type_id").val("");
		$("#autocomplete_driver_filters_device_id").focus();
	});
}); 
</script> 