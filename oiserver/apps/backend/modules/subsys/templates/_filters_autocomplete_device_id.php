<link rel="stylesheet" type="text/css" media="all" href="/drivers/web/sfFormExtraPlugin/css/jquery.autocompleter.css" />
<script type="text/javascript" src="/drivers/web/sfFormExtraPlugin/js/jquery.autocompleter.js"></script>
	 <?php $device_id='';	?>
	 <?php if($sf_user->hasAttribute('subsys_filters_device_id')):?>
		<?php $device_id=$sf_user->getAttribute('subsys_filters_device_id');?>
	 <?php endif;?>
	 <?php $autocomplete_device_id='';	?>
	 <?php if($sf_user->hasAttribute('autocomplete_subsys_filters_device_id')):?>
		<?php $autocomplete_device_id=$sf_user->getAttribute('autocomplete_subsys_filters_device_id');?>
	 <?php endif;?>	 
      <input type="hidden" name="subsys_filters[device_id]" value="<?php echo $device_id?>" id="subsys_filters_device_id" />
	  <input type="text" name="autocomplete_subsys_filters[device_id]" value="<?php echo $autocomplete_device_id;?>" id="autocomplete_subsys_filters_device_id" />	  
<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery("#autocomplete_subsys_filters_device_id")
    .autocomplete('<?php echo url_for('ajax/device_id');?>', jQuery.extend({}, {
      dataType: 'json',
      parse:    function(data) {
        var parsed = [];
        for (key in data) {
          //kam
		  //parsed[parsed.length] = { data: [ data[key], key ], value: data[key], result: data[key] };
		  parsed[parsed.length] = { data: [ data[key], key], value: data[key], result: data[key] };
        }
        return parsed;
      }
    }, {
                                                                                          width: 320,
                                                                                          max: 10,
                                                                                          highlight: false,
                                                                                          multiple: false,
                                                                                          scroll: false,
                                                                                          scrollHeight: 300
                                                                                         }))
    .result(function(event, data) { 
		jQuery("#subsys_filters_device_id").val(data[1]);		
	});
  });
</script>