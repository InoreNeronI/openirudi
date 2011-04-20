<script type="text/javascript">
    jQuery(document).ready(function() {       
	jQuery('#my_task_pc_id').change(function() {
           var pc_id=$(this).attr('value');
		   jQuery.ajax({
				type: "POST",
				url: "<?php echo url_for('@ajax?action=partition_list')?>",
				data: {pc_id:pc_id},
				success: function(myJSONtext){
					//removeall
					jQuery("#my_task_partition").removeOption(/./);
					
					//gaur
					jQuery("#my_task_disk").removeOption(/./);
					//
					
					var result = eval('(' + myJSONtext + ')');
					
					//gaur
					//jQuery("#my_task_partition").addOption(result, false);
					jQuery("#my_task_partition").addOption(result.partition, false);
					jQuery("#my_task_disk").addOption(result.disk, false);
					//
				}
			});
        });
    });
</script>