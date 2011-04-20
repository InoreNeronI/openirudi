<?php $device_id='';	?>
	 <?php if($sf_user->hasAttribute('driver_filters_device_id')):?>
		<?php $device_id=$sf_user->getAttribute('driver_filters_device_id');?>
	 <?php endif;?>
	 <?php $autocomplete_device_id='';	?>
	 <?php if($sf_user->hasAttribute('autocomplete_driver_filters_device_id')):?>
		<?php $autocomplete_device_id=$sf_user->getAttribute('autocomplete_driver_filters_device_id');?>
	 <?php endif;?>
	 <?php //OHARRA::::autoocomplete ta device aurrizki bezela jarri ez gero filter balidazioan ez da ezer egin beharrik, filterraren parte driver_filters aurrizkia dutenak harzten baitira?>
	 <?php $device_vendor_id='';?> 
	 <?php if($sf_user->hasAttribute('device_driver_filters_vendor_id')):?>
		<?php $device_vendor_id=$sf_user->getAttribute('device_driver_filters_vendor_id');?>
	 <?php endif;?>
	 <?php $device_type_id='';?> 
	 <?php if($sf_user->hasAttribute('device_driver_filters_type_id')):?>
		<?php $device_type_id=$sf_user->getAttribute('device_driver_filters_type_id');?>
	 <?php endif;?>
      <input type="hidden" name="driver_filters[device_id]" value="<?php echo $device_id?>" id="driver_filters_device_id" />
	  <input type="text" name="autocomplete_driver_filters[device_id]" value="<?php echo $autocomplete_device_id;?>" id="autocomplete_driver_filters_device_id" />
	  <input type="hidden" name="device_driver_filters[vendor_id]" value="<?php echo $device_vendor_id?>" id="device_driver_filters_vendor_id" />	
	  <input type="hidden" name="device_driver_filters[type_id]" value="<?php echo $device_type_id?>" id="device_driver_filters_type_id" />	
<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery("#autocomplete_driver_filters_device_id")
    .autocomplete('<?php echo url_for('ajax/device');?>', jQuery.extend({}, {
      dataType: 'json',
      parse:    function(data) {
        var parsed = [];
        for (key in data) {
          //kam
		  //parsed[parsed.length] = { data: [ data[key], key ], value: data[key], result: data[key] };
		  parsed[parsed.length] = { data: [ data[key].name, data[key].code,data[key].vendor_id,data[key].type_id ], value: data[key].name, result: data[key].name };
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
		jQuery("#driver_filters_device_id").val(data[1]);
		//kam		
		jQuery("#device_driver_filters_vendor_id").val(data[2]);
		jQuery("#device_driver_filters_type_id").val(data[3]);
	});
  });
</script>