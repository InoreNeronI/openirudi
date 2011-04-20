<script type="text/javascript">
    var my_pc_id_array=new Array(<?php echo $pc_id_js_array?>);
	$(document).ready(function() {
        var id=0;
		var my_name="";
		for (var i = 0;i<my_pc_id_array.length;i++)
		{
			id=my_pc_id_array[i];
			my_name="txek_"+id;
			$('#'+my_name).click(function() {				
				var bai=$(this).attr('checked');
				if(bai){
					var my_id=$(this).attr('value');
					begizta_txek(my_id,false);
				}
			});
		}
    });
	///////////////////
	function begizta_txek(my_id,modua){
		for (var i = 0;i<my_pc_id_array.length;i++)
		{
			if(my_pc_id_array[i]!=my_id){
				$('#txek_'+my_pc_id_array[i]).attr('checked',modua);
			}
		}
	}
</script>