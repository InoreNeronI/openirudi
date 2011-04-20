<script type="text/javascript">
    jQuery(document).ready(function() {    	
			$(":checkbox").click(function() {
				is_checked=false;
				if($(this).attr("checked")){
					is_checked=true;
				}
				$(":checkbox").removeAttr("checked");
				if(is_checked){
					$(this).attr("checked","checked");
				}
			 });
    });
</script>