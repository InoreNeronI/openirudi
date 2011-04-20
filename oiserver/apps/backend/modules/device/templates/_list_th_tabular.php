
  <th id="sf_admin_list_th_code">
          <?php if ('code' == $sort[0]): ?>
    <?php echo link_to(__('Code', array(), 'messages'), 'device', array(), array('query_string' => 'sort=code&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Code', array(), 'messages'), 'device', array(), array('query_string' => 'sort=code&sort_type=asc')) ?>
  <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_name">
          <?php if ('name' == $sort[0]): ?>
    <?php echo link_to(__('Name', array(), 'messages'), 'device', array(), array('query_string' => 'sort=name&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Name', array(), 'messages'), 'device', array(), array('query_string' => 'sort=name&sort_type=asc')) ?>
  <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_vendor_id">
         <?php if ('vendor_id' == $sort[0]): ?>
    <?php echo link_to(__('Vendor', array(), 'messages'), 'device', array(), array('query_string' => 'sort=vendor_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Vendor', array(), 'messages'), 'device', array(), array('query_string' => 'sort=vendor_id&sort_type=asc')) ?>
  <?php endif; ?>
          </th>
  <th id="sf_admin_list_th_type_id">
          <?php if ('type_id' == $sort[0]): ?>
    <?php echo link_to(__('Type', array(), 'messages'), 'device', array(), array('query_string' => 'sort=type_id&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Type', array(), 'messages'), 'device', array(), array('query_string' => 'sort=type_id&sort_type=asc')) ?>
  <?php endif; ?>
          </th>