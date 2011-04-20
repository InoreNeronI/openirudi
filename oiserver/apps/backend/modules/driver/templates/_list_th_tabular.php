  <th id="sf_admin_list_th_string">
        <?php if ('string' == $sort[0]): ?>
    <?php echo link_to(__('String', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=string&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('String', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=string&sort_type=asc')) ?>
  <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_name">
         <?php if ('name' == $sort[0]): ?>
    <?php echo link_to(__('Name', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=name&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Name', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=name&sort_type=asc')) ?>
  <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_class_type">
          <?php if ('class_type' == $sort[0]): ?>
    <?php echo link_to(__('Class type', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=class_type&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Class type', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=class_type&sort_type=asc')) ?>
  <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_date">
          <?php if ('date' == $sort[0]): ?>
    <?php echo link_to(__('Date', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=date&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Date', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=date&sort_type=asc')) ?>
  <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_type_link">
         <?php if ('type_id' == $sort[0]): ?>
    <?php echo link_to(__('Type', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=type_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Type', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=type_id&sort_type=asc')) ?>
  <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_vendor_id">
          <?php if ('vendor_id' == $sort[0]): ?>
    <?php echo link_to(__('Vendor', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=vendor_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Vendor', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=vendor_id&sort_type=asc')) ?>
  <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_device_id">
          <?php if ('device_id' == $sort[0]): ?>
    <?php echo link_to(__('Device', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=device_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Device', array(), 'messages'), 'driver', array(), array('query_string' => 'sort=device_id&sort_type=asc')) ?>
  <?php endif; ?>
          </th>